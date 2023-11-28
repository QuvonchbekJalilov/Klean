<?php

use App\Models\Category;

$categories = Category::all();

use function PHPSTORM_META\map;
?>
<x-layouts.main>
    <x-slot:title>
        create post
    </x-slot:title>
    <x-page-header>
        create post
    </x-page-header>
    <div class="container py-5">
        <div class="row align-items-center py-4"></div>
        <div class="contact-form">
            <div id="success"></div>
            {{-- @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
            @endforeach
            </ul>
        </div>
        @endif --}}
        <form action="{{ route('posts.store')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="control-group mb-4">
                <input type="text" class="form-control p-4" id="name" name="title" value="{{ old('title')}}" class="@error('title') is-invalid @enderror" placeholder="Title" />
                @error('title')
                <p class="help-block text-danger">{{ $message }}</p>
                @enderror

            </div>
            <div class="control-group mb-4">
                <label for="category">Select a Category:</label>
                <select class="form-control" id="category" name="category">
                    @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="control-group mb-4">
                <label for="category">Select a Category:</label>
                <select class="form-control" id="category" name="tags[]" multiple>
                    @foreach ($tags as $tag)
                    <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="control-group mb-4">
                <input type="text" class="form-control p-4" id="subject" name="short_content" value="{{ old('short_content')}}" placeholder="Short Content" />
                @error('short_content')
                <p class="help-block text-danger">{{ $message }}</p>
                @enderror
            </div>
            <div class="control-group mb-4">
                <textarea class="form-control p-4" rows="6" id="message" name="content" placeholder="Content">{{ old('content')}}</textarea>
                @error('content')
                <p class="help-block text-danger">{{ $message }}</p>
                @enderror
            </div>
            <div class="control-group mb-5">
                <input type="file" class="form-control p-5" id="email" placeholder="Image File" value="{{ old('photo')}}" name="photo" />
                @error('photo')
                <p class="help-block text-danger">{{ $message }}</p>
                @enderror
            </div>


            <div>
                <button class="btn btn-primary btn-block py-3 px-5" type="submit">Saqlash</button>
            </div>
        </form>
    </div>


    </div>
</x-layouts.main>