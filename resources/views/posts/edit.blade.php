<x-<x-layouts.main>
    <x-slot:title>
        Postni o'zgartirish {{ $post->id }}
    </x-slot:title>
    <x-page-header>
        Postni o'zgartirish {{ $post->id }}

    </x-page-header>
    <div class="container py-7">
        <div class="row align-items-center py-4">
            <div class="contact-form">
                <div id="success"></div>

                <form action="{{ route('posts.update',['post'=> $post])}}" method="post" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <div class="control-group mb-4">
                        <input type="text" class="form-control p-4" id="name" name="title" value="{{ $post->title }}" placeholder="Title" />
                        @error('title')
                        <p class="help-block text-danger">{{ $message }}</p>
                        @enderror

                    </div>
                    <div class="control-group mb-4">
                        <label for="category">Select a Category:</label>
                        <select class="form-control" id="category" name="category">
                            @foreach ($categories as $category)
                            <option value="{{ $category->id }}"> 
                                {{ old('category', $post->category_id) == $category->id ? 'selected' : '' }}
                                {{ $category->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="control-group mb-4">
                        <label for="category">Select a Category:</label>
                        <select class="form-control" id="category" name="tags[]" multiple>

                            @foreach ($tags as $tag)
                            <option value="{{ $tag->id }}">
                            {{ in_array($tag->id, old('tags', $post->tags->pluck('id')->toArray())) ? 'selected' : '' }}
    
                            {{ $tag->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="control-group mb-4">
                        <input type="text" class="form-control p-4" id="subject" name="short_content" value="{{ $post->short_content}}" placeholder="Short Content" />
                        @error('short_content')
                        <p class="help-block text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="control-group mb-4">
                        <textarea class="form-control p-4" rows="6" id="message" name="content" placeholder="Content">{{ $post->content}}</textarea>
                        @error('content')
                        <p class="help-block text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="text-left">
                        <img src="/storage/<?= $post->photo ?>" width="100" alt="">
                    </div>
                    <div class="control-group mb-5">
                        <input type="file" class="form-control p-5" id="email" placeholder="Image File" value="{{ $post->photo }}" name="photo" />
                        @error('photo')
                        <p class="help-block text-danger">{{ $message }}</p>
                        @enderror
                    </div>


                    <div class="flex">
                        <button class="btn btn-success py-3 px-5" type="submit">Saqlash</button>

                        <a class="btn btn-danger  py-3 px-5" href="{{ route('posts.show',['post'=>$post->id])}}">Bekor qilish</a>
                    </div>
                </form>
            </div>
        </div>


    </div>
    </x-layouts.main>