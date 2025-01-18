@extends('admin.layout.master')
@section('main_content')
    @include('admin.layout.nav')
    @include('admin.layout.sidebar')
    <div class="main-content">
        <section class="section">
            <div class="section-header justify-content-between">
                <h1>Edit Destination</h1>
                <div class="ml-auto">
                    <a href="{{route('admin_destination_index')}}" class="btn btn-primary"><i class="fas fa-plus">View
                            All</i></a>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{route('admin_destination_edit_submit',$destination->id)}}" method="post"
                                      enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label">Existing Photo</label>
                                        <div><img src="{{asset('uploads/'.$destination->featured_photo)}}" alt="" srcset="" class="w_200"></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label class="form-label">Change Featured Photo </label>
                                                <div><input type="file" name="featured_photo"></div>
                                                @error('featured_photo')
                                                <div class="alert alert-danger mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label class="form-label">Name *</label>
                                                <input type="text" class="form-control" name="name"
                                                       value="{{$destination->name}}">
                                                @error('name')
                                                <div class="alert alert-danger mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label class="form-label">Slug *</label>
                                                <input type="text" class="form-control" name="slug"
                                                       value="{{$destination->slug}}">
                                                @error('slug')
                                                <div class="alert alert-danger mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label class="form-label">Country </label>
                                                <input type="text" class="form-control" name="country"
                                                       value="{{$destination->country}}">
                                                @error('country')
                                                <div class="alert alert-danger mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label">Area </label>
                                                <input type="text" class="form-control" name="area"
                                                       value="{{$destination->area}}">
                                                @error('area')
                                                <div class="alert alert-danger mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label">Timezone </label>
                                                <input type="text" class="form-control" name="timezone"
                                                       value="{{$destination->timezone}}">
                                                @error('timezone')
                                                <div class="alert alert-danger mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label">View Count </label>
                                                <input type="text" class="form-control" name="view_count"
                                                       value="{{$destination->view_count}}">
                                                @error('view_count')
                                                <div class="alert alert-danger mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label">Language </label>
                                                <input type="text" class="form-control" name="language"
                                                       value="{{$destination->language}}">
                                                @error('language')
                                                <div class="alert alert-danger mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label">Currency </label>
                                                <input type="text" class="form-control" name="currency"
                                                       value="{{$destination->language}}">
                                                @error('currency')
                                                <div class="alert alert-danger mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label">Map (iframe code)</label>
                                                <textarea name="map" class="form-control h_100" cols="30"
                                                          rows="10">{{$destination->map}}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="mb-3">
                                                <label class="form-label">Description *</label>
                                                <textarea name="description" class="form-control editor" cols="30"
                                                          rows="10">{{$destination->description}}</textarea>
                                                @error('description')
                                                <div class="alert alert-danger mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="mb-3">
                                                <label class="form-label">Activity </label>
                                                <textarea name="activity" class="form-control editor" cols="30"
                                                          rows="10">{{$destination->activity}}</textarea>
                                                @error('activity')
                                                <div class="alert alert-danger mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="mb-3">
                                                <label class="form-label">Visa Requirement </label>
                                                <textarea name="visa_requirement" class="form-control editor" cols="30"
                                                          rows="10">{{$destination->visa_requirement}}</textarea>
                                                @error('visa_requirement')
                                                <div class="alert alert-danger mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="mb-3">
                                                <label class="form-label">Best Time To Visit</label>
                                                <textarea name="best_time" class="form-control editor" cols="30"
                                                          rows="10">{{$destination->best_time}}</textarea>
                                                @error('best_time')
                                                <div class="alert alert-danger mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="mb-3">
                                                <label class="form-label">Health & Safety</label>
                                                <textarea name="health_safety" class="form-control editor"
                                                          cols="30" rows="10">{{$destination->health_safety}}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3 text-center">
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
