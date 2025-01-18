@extends('admin.layout.master')
@section('main_content')
    @include('admin.layout.nav')
    @include('admin.layout.sidebar')
    <div class="main-content">
        <section class="section">
            <div class="section-header justify-content-between">
                <h1>Edit Package</h1>
                <div class="ml-auto">
                    <a href="{{route('admin_package_index')}}" class="btn btn-primary"><i class="fas fa-plus">View
                            All</i></a>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{route('admin_package_edit_submit',$package->id)}}" method="post"
                                      enctype="multipart/form-data">
                                    @csrf
                                    <div class="row align-items-center">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Existing Photo</label>
                                                <div><img src="{{asset('uploads/'.$package->featured_photo)}}" alt=""
                                                          srcset="" class="w_200"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Existing Photo</label>
                                                <div><img src="{{asset('uploads/'.$package->banner)}}" alt=""
                                                          srcset="" class="w_200"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Change Featured Photo </label>
                                                <div><input type="file" name="featured_photo"></div>
                                                @error('featured_photo')
                                                <div class="alert alert-danger mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Change Banner Photo </label>
                                                <div><input type="file" name="banner"></div>
                                                @error('banner')
                                                <div class="alert alert-danger mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label">Name *</label>
                                                <input type="text" class="form-control" name="name"
                                                       value="{{$package->name}}">
                                                @error('name')
                                                <div class="alert alert-danger mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label">Slug *</label>
                                                <input type="text" class="form-control" name="slug"
                                                       value="{{$package->slug}}">
                                                @error('slug')
                                                <div class="alert alert-danger mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label">Select Destination *</label>
                                                <select class="form-select" name="destination_id">
                                                    @foreach($destinations as $destination)
                                                        <option value="{{ $destination->id }}"
                                                                @if($package->destination_id == $destination->id ) selected @endif>{{$destination->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('destination_id')
                                                <div class="alert alert-danger mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Price *</label>
                                                <input type="text" class="form-control" name="price"
                                                       value="{{$package->price}}">
                                                @error('price')
                                                <div class="alert alert-danger mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Old Price </label>
                                                <input type="text" class="form-control" name="old_price"
                                                       value="{{$package->old_price}}">
                                                @error('old_price')
                                                <div class="alert alert-danger mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Description *</label>
                                                <textarea name="description" class="form-control editor" cols="30"
                                                          rows="10">{{$package->description}}</textarea>
                                                @error('description')
                                                <div class="alert alert-danger mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Map (iframe code)</label>
                                                <textarea name="map" class="form-control h_100" cols="30"
                                                          rows="10">{{$package->map}}</textarea>
                                            </div>
                                        </div>
                                        <div class="mb-3 text-center">
                                            <label class="form-label"></label>
                                            <button type="submit" class="btn btn-primary">Update</button>
                                        </div>
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
