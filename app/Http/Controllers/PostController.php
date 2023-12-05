<?php

namespace App\Http\Controllers;

use App\Events\PostCreated;
use App\Http\Requests\StorePostRequest;
use App\Jobs\UploadBigFile;
use App\Models\Category;
use App\Models\Post;
use App\Models\Role;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    public function index()
    {
        $posts = Post::latest()->paginate('3');

        return view('posts.index', ['posts' => $posts]);
    }


    public function create()
    {
        Gate::authorize('create-post', Role::where('name','admin')->first()); 
        return view('posts.create')->with([
            'tags' => Tag::all(),
        ]);
    }

    public function store(StorePostRequest $request)
    {
        $name = $request->file('photo')->getClientOriginalName();
        $path = $request->file('photo')->storeAs('post-photos', $name);

        $post = Post::create([
            'title' => $request->title,
            'user_id' => auth()->user()->id,
            'category_id' => $request->category,
            'short_content' => $request->short_content,
            'content' => $request->content,
            'photo' => $path
        ]);
         
        if (isset($request->tags)) {
            foreach ($request->tags as $tag) {
                $post->tags()->attach($tag);
            }
        }

        PostCreated::dispatch($post);


        return redirect(route('posts.index'))->with([
            'categories' => Category::all(),
        ]);
    }


    public function show(Post $post)
    {
        //$post = Post::find($id);
        return view(
            'posts.show',
            ['post' => $post],
            ['tags' => Tag::all()],
            ['categories' => Category::all()],
        )->with(
            ['recent_posts' => Post::latest()->get()->except($post->id)->take(3)],
        );
    }


    public function edit(Post $post)
    {

        // bu post yaratgan odam faqat ozgartira olishini tamilaydi 1 yo'li
        /*if (! Gate::allows('update-post', $post)) {
            abort(403);
        }*/
        // 2 yo'li
        Gate::authorize('update', $post);

        return view('posts.edit', ['post' => $post])->with([
            'categories' => Category::all(),
            'tags' => Tag::all()
        ]);
    }


    public function update(Request $request, Post $post)
    {
        Gate::authorize('update', $post);

        // Validate the request
        $request->validate([
            'title' => 'required|string',
            'category' => 'required|exists:categories,id', // Make sure the category exists.
            'short_content' => 'required|string',
            'content' => 'required|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust the validation rules as needed.
        ]);

        // Update the post fields
        $post->title = $request->input('title');
        $post->category_id = $request->input('category');
        $post->short_content = $request->input('short_content');
        $post->content = $request->input('content');

        // Handle file upload if a new file is provided
        if ($request->hasFile('photo')) {
            // Delete the old photo (if it exists)
            Storage::delete($post->photo);

            $name = $request->file('photo')->getClientOriginalName();
            $path = $request->file('photo')->storeAs('post-photos', $name);

            $post->photo = $path;
        }

        $post->save();

        // Sync tags
        if (isset($request->tags)) {
            $post->tags()->sync($request->tags);
        } else {
            // If no tags are selected, remove all existing tags
            $post->tags()->detach();
        }

        return redirect(route('posts.index'))->with([
            'categories' => Category::all(),
            'success' => 'Post updated successfully.',
        ]);
    }



    public function destroy(Post $post)
    {
        $post->comments()->delete();

        if (isset($post->photo)) {
            Storage::delete($post->photo);
        }
        // Detach all related tags first
        $post->tags()->detach();
        $post->delete();

        return redirect(route('posts.index'));
    }
}
