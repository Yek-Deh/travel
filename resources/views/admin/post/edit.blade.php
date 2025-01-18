@extends('admin.layout.master')
@section('main_content')
    @include('admin.layout.nav')
    @include('admin.layout.sidebar')
    <div class="main-content">
        <section class="section">
            <div class="section-header justify-content-between">
                <h1>Edit Post</h1>
                <div class="ml-auto">
                    <a href="{{route('admin_post_index')}}" class="btn btn-primary"><i class="fas fa-plus">View
                            All</i></a>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body w-50 m-auto ">
                                <form action="{{route('admin_post_edit_submit',$post->id)}}" method="post"
                                      enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label">Existing Photo</label>
                                        <div><img src="{{asset('uploads/'.$post->photo)}}" alt="" srcset=""
                                                  class="w-25"></div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Change Photo</label>
                                        <div><input type="file" name="photo"></div>
                                        @error('photo')
                                        <div class="alert alert-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Title *</label>
                                                <input type="text" class="form-control" name="title"
                                                       value="{{$post->title}}">
                                                @error('title')
                                                <div class="alert alert-danger mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Slug *</label>
                                                <input type="text" class="form-control" name="slug"
                                                       value="{{$post->slug}}">
                                                @error('slug')
                                                <div class="alert alert-danger mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Short Description *</label>
                                        <textarea name="short_description" class="form-control h_100" cols="30"
                                                  rows="10">{{$post->short_description}}</textarea>
                                        @error('short_description')
                                        <div class="alert alert-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Description *</label>
                                        <textarea name="description" class="form-control editor" cols="30"
                                                  rows="10">{{$post->description}}</textarea>
                                        @error('description')
                                        <div class="alert alert-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Category *</label>
                                        <select name="blog_category_id" class="form-select">
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}"
                                                        @if($category->id == $post->blog_category_id) selected @endif> {{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('blog_category_id')
                                        <div class="alert alert-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label"></label>
                                        <button type="submit" class="btn btn-primary">Update</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
