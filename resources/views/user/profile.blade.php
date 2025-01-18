@extends('front.layout.master')
@section('main_content')
    <div class="page-top" style="background-image: url({{asset('uploads/banner.jpg')}})">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>Profile</h2>
                    <div class="breadcrumb-container">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                            <li class="breadcrumb-item active">Profile</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="page-content user-panel pt_70 pb_70">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3 col-md-12">
                    <div class="card">
                        @include('user.sidebar')
                    </div>
                </div>
                <div class="col-lg-9 col-md-12">
                    <form action="{{route('user_profile_submit')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="">Existing Photo</label>
                                <div class="form-group">
                                    @if(Auth::guard('web')->user()->photo != '')
                                        <img src="{{asset('uploads/'.Auth::guard('web')->user()->photo)}}" alt="" class="user-photo">
                                    @else
                                        <img src="{{asset('uploads/default.png')}}" alt="" class="user-photo">
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="photo">Change Photo</label>
                                <div class="form-group">
                                    <input type="file" name="photo">
                                    @error('photo')
                                    <div class="alert alert-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="name">Full Name *</label>
                                <div class="form-group">
                                    <input type="text" name="name" class="form-control" value="{{Auth::guard('web')->user()->name}}">
                                    @error('name')
                                    <div class="alert alert-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email">Email Address *</label>
                                <div class="form-group">
                                    <input type="text" name="email" class="form-control" value="{{Auth::guard('web')->user()->email}}">
                                    @error('email')
                                    <div class="alert alert-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="phone">Phone *</label>
                                <div class="form-group">
                                    <input type="text" name="phone" class="form-control" value="{{Auth::guard('web')->user()->phone}}">
                                    @error('phone')
                                    <div class="alert alert-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="country">Country *</label>
                                <div class="form-group">
                                    <input type="text" name="country" class="form-control" value="{{Auth::guard('web')->user()->country}}">
                                    @error('country')
                                    <div class="alert alert-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="address">Address *</label>
                                <div class="form-group">
                                    <input type="text" name="address" class="form-control" value="{{Auth::guard('web')->user()->address}}">
                                    @error('address')
                                    <div class="alert alert-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="state">State *</label>
                                <div class="form-group">
                                    <input type="text" name="state" class="form-control" value="{{Auth::guard('web')->user()->state}}">
                                    @error('state')
                                    <div class="alert alert-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="city">City *</label>
                                <div class="form-group">
                                    <input type="text" name="city" class="form-control" value="{{Auth::guard('web')->user()->city}}">
                                    @error('city')
                                    <div class="alert alert-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="zip">Zip Code *</label>
                                <div class="form-group">
                                    <input type="text" name="zip" class="form-control" value="{{Auth::guard('web')->user()->zip}}">
                                    @error('zip')
                                    <div class="alert alert-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="password">Password</label>
                                <div class="form-group">
                                    <input type="password" name="password" class="form-control">
                                    @error('password')
                                    <div class="alert alert-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="retype_password">Retype Password</label>
                                <div class="form-group">
                                    <input type="password" name="retype_password" class="form-control">
                                    @error('retype_password')
                                    <div class="alert alert-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input name="form_update" type="submit" class="btn btn-primary" value="Update">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
