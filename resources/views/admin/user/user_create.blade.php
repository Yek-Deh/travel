@extends('admin.layout.master')
@section('main_content')
    @include('admin.layout.nav')
    @include('admin.layout.sidebar')
    <div class="main-content">
        <section class="section">
            <div class="section-header justify-content-between">
                <h1>Create User</h1>
                <div class="ml-auto">
                    <a href="{{route('admin_users')}}" class="btn btn-primary"><i class="fas fa-plus">View
                            All</i></a>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{route('admin_user_create_submit')}}" method="post"
                                      enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label">Photo *</label>
                                                <div><input type="file" name="photo"></div>
                                                @error('photo')
                                                <div class="alert alert-danger mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="name">Name *</label>
                                                <input type="text" name="name" class="form-control"
                                                       value="{{old('name')}}">
                                                @error('name')
                                                <div class="alert alert-danger mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="email">Email Address *</label>
                                                <input type="text" name="email" class="form-control"
                                                       value="{{old('email')}}">
                                                @error('email')
                                                <div class="alert alert-danger mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label for="password">Password *</label>
                                                <input type="password" name="password" class="form-control">
                                                @error('password')
                                                <div class="alert alert-danger mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label for="phone">Phone *</label>
                                                <input type="text" name="phone" class="form-control"
                                                       value="{{old('phone')}}">
                                                @error('phone')
                                                <div class="alert alert-danger mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label for="country">Country *</label>
                                                <input type="text" name="country" class="form-control"
                                                       value="{{old('country')}}">
                                                @error('country')
                                                <div class="alert alert-danger mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label for="address">Address *</label>
                                                <input type="text" name="address" class="form-control"
                                                       value="{{old('address')}}">
                                                @error('address')
                                                <div class="alert alert-danger mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label for="state">State *</label>
                                                <input type="text" name="state" class="form-control"
                                                       value="{{old('state')}}">
                                                @error('state')
                                                <div class="alert alert-danger mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label for="city">City *</label>
                                                <input type="text" name="city" class="form-control"
                                                       value="{{old('city')}}">
                                                @error('city')
                                                <div class="alert alert-danger mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label for="zip">Zip Code *</label>
                                                <input type="text" name="zip" class="form-control"
                                                       value="{{old('zip')}}">
                                                @error('zip')
                                                <div class="alert alert-danger mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label for="zip">Status *</label>
                                                <select name="status" class="form-select">
                                                    <option value="1">Active</option>
                                                    <option value="0">Pending</option>
                                                </select>
                                                @error('status')
                                                <div class="alert alert-danger mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3 text-center">
                                        <label class="form-label"></label>
                                        <button type="submit" class="btn btn-primary">Submit</button>
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

