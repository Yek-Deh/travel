@extends('admin.layout.master')
@section('main_content')
    @include('admin.layout.nav')
    @include('admin.layout.sidebar')
    <div class="main-content">
        <section class="section">
            <div class="section-header justify-content-between">
                <h1>Edit Home Item</h1>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{route('admin_home_item_update',$home_item->id)}}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <h4>Destination Section </h4>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label">Destination Heading *</label>
                                                <input type="text" class="form-control"
                                                       name="destination_heading" value="{{$home_item->destination_heading }}">
                                                @error('destination_heading')
                                                <div class="alert alert-danger mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label">Destination Subheading *</label>
                                                <input type="text" class="form-control"
                                                       name="destination_subheading" value="{{$home_item->destination_subheading }}">
                                                @error('destination_subheading')
                                                <div class="alert alert-danger mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label">Destination Status </label>
                                                <select name="destination_status" class="form-select">
                                                    <option
                                                        value="Show" {{$home_item->destination_status == 'Show' ? 'selected' : '' }}>
                                                        Show
                                                    </option>
                                                    <option
                                                        value="Hide" {{$home_item->destination_status == 'Hide' ? 'selected' : '' }}>
                                                        Hide
                                                    </option>
                                                </select>
                                                @error('destination_status')
                                                <div class="alert alert-danger mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <br>

                                    <h4>Feature Section </h4>
                                    <div class="mb-3">
                                        <label class="form-label">Feature Status </label>
                                        <select name="feature_status" class="form-select">
                                            <option
                                                value="Show" {{$home_item->feature_status == 'Show' ? 'selected' : '' }}>
                                                Show
                                            </option>
                                            <option
                                                value="Hide" {{$home_item->feature_status == 'Hide' ? 'selected' : '' }}>
                                                Hide
                                            </option>
                                        </select>
                                        @error('feature_status')
                                        <div class="alert alert-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <br>

                                    <h4>Package Section </h4>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label">Package Heading *</label>
                                                <input type="text" class="form-control"
                                                       name="package_heading" value="{{$home_item->package_heading }}">
                                                @error('package_heading')
                                                <div class="alert alert-danger mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label">Package Subheading *</label>
                                                <input type="text" class="form-control"
                                                       name="package_subheading" value="{{$home_item->package_subheading }}">
                                                @error('package_subheading')
                                                <div class="alert alert-danger mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label">Package Status </label>
                                                <select name="package_status" class="form-select">
                                                    <option
                                                        value="Show" {{$home_item->package_status == 'Show' ? 'selected' : '' }}>
                                                        Show
                                                    </option>
                                                    <option
                                                        value="Hide" {{$home_item->package_status == 'Hide' ? 'selected' : '' }}>
                                                        Hide
                                                    </option>
                                                </select>
                                                @error('package_status')
                                                <div class="alert alert-danger mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <br>

                                    <h4>Testimonial Section </h4>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Testimonial Existing Background</label>
                                                <div>
                                                    <img src="{{asset('uploads/'.$home_item->testimonial_background)}}" alt="" class="w_200">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Testimonial Change Background </label>
                                                <div>
                                                    <input type="file" name="testimonial_background">
                                                </div>
                                                @error('testimonial_background')
                                                <div class="alert alert-danger mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label">Testimonial Heading *</label>
                                                <input type="text" class="form-control"
                                                       name="testimonial_heading" value="{{$home_item->testimonial_heading }}">
                                                @error('testimonial_heading')
                                                <div class="alert alert-danger mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label">Testimonial Subheading *</label>
                                                <input type="text" class="form-control"
                                                       name="testimonial_subheading" value="{{$home_item->testimonial_subheading }}">
                                                @error('testimonial_subheading')
                                                <div class="alert alert-danger mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label">Testimonial Status </label>
                                                <select name="testimonial_status" class="form-select">
                                                    <option
                                                        value="Show" {{$home_item->testimonial_status == 'Show' ? 'selected' : '' }}>
                                                        Show
                                                    </option>
                                                    <option
                                                        value="Hide" {{$home_item->testimonial_status == 'Hide' ? 'selected' : '' }}>
                                                        Hide
                                                    </option>
                                                </select>
                                                @error('testimonial_status')
                                                <div class="alert alert-danger mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <h4>Blog Section </h4>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label">Blog Heading *</label>
                                                <input type="text" class="form-control"
                                                       name="blog_heading" value="{{$home_item->blog_heading }}">
                                                @error('blog_heading')
                                                <div class="alert alert-danger mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label">Blog Subheading *</label>
                                                <input type="text" class="form-control"
                                                       name="blog_subheading" value="{{$home_item->blog_subheading }}">
                                                @error('blog_subheading')
                                                <div class="alert alert-danger mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label">Blog Status </label>
                                                <select name="blog_status" class="form-select">
                                                    <option
                                                        value="Show" {{$home_item->blog_status == 'Show' ? 'selected' : '' }}>
                                                        Show
                                                    </option>
                                                    <option
                                                        value="Hide" {{$home_item->blog_status == 'Hide' ? 'selected' : '' }}>
                                                        Hide
                                                    </option>
                                                </select>
                                                @error('blog_status')
                                                <div class="alert alert-danger mt-1">{{ $message }}</div>
                                                @enderror
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

