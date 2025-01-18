@extends('admin.layout.master')
@section('main_content')
    @include('admin.layout.nav')
    @include('admin.layout.sidebar')
    <div class="main-content">
        <section class="section">
            <div class="section-header justify-content-between">
                <h1>Edit Welcome Item</h1>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{route('admin_welcome_item_update',$welcome_item->id)}}" method="post"
                                      enctype="multipart/form-data">
                                    @csrf
                                    <div class="row  align-items-center">
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label">Existing Photo</label>
                                                <div><img src="{{asset('uploads/'.$welcome_item->photo)}}" alt=""
                                                          srcset="" class="w_300"></div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Change Photo</label>
                                                <div><input type="file" name="photo"></div>
                                                @error('photo')
                                                <div class="alert alert-danger mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label">Existing Video</label>
                                                <iframe class="iframe1" width="560" height="315"
                                                        src="https://www.youtube.com/embed/{{$welcome_item->video}}"
                                                        title="YouTube video player" frameborder="0"
                                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                                        referrerpolicy="strict-origin-when-cross-origin"
                                                        allowfullscreen></iframe>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Video (Youtube Id) *</label>
                                                <input type="text" class="form-control" name="video"
                                                       value="{{$welcome_item->video}}">
                                                @error('video')
                                                <div class="alert alert-danger mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Heading *</label>
                                        <input type="text" class="form-control" name="heading"
                                               value="{{$welcome_item->heading}}">
                                        @error('heading')
                                        <div class="alert alert-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Description *</label>
                                        <textarea name="description" class="form-control editor" cols="30"
                                                  rows="10">{{$welcome_item->description}}</textarea>
                                        @error('description')
                                        <div class="alert alert-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Button Text </label>
                                        <input type="text" class="form-control" name="button_text"
                                               value="{{$welcome_item->button_text}}">
                                        @error('button_text')
                                        <div class="alert alert-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Button Link </label>
                                        <input type="text" class="form-control" name="button_link"
                                               value="{{$welcome_item->button_link}}">
                                        @error('button_link')
                                        <div class="alert alert-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Status </label>
                                        <select name="status" class="form-select">
                                            <option
                                                value="Show" {{$welcome_item->status == 'Show' ? 'selected' : '' }}>
                                                Show
                                            </option>
                                            <option
                                                value="Hide" {{$welcome_item->status == 'Hide' ? 'selected' : '' }}>
                                                Hide
                                            </option>
                                        </select>
                                        @error('status')
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

