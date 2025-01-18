@extends('admin.layout.master')
@section('main_content')
    @include('admin.layout.nav')
    @include('admin.layout.sidebar')
    <div class="main-content">
        <section class="section">
            <div class="section-header justify-content-between">
                <h1>Edit TeamMember</h1>
                <div class="ml-auto">
                    <a href="{{route('admin_team_member_index')}}" class="btn btn-primary"><i class="fas fa-plus">View
                            All</i></a>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body ">
                                <form action="{{route('admin_team_member_edit_submit',$team_member->id)}}" method="post"
                                      enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-3 w-50">
                                        <label class="form-label">Existing Photo</label>
                                        <div><img src="{{asset('uploads/'.$team_member->photo)}}" alt="" srcset="" class="w-25" ></div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Change Photo</label>
                                        <div><input type="file" name="photo"></div>
                                        @error('photo')
                                        <div class="alert alert-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label">Name *</label>
                                                <input type="text" class="form-control" name="name"
                                                       value="{{$team_member->name}}">
                                                @error('name')
                                                <div class="alert alert-danger mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label">Slug *</label>
                                                <input type="text" class="form-control" name="slug"
                                                       value="{{$team_member->slug}}">
                                                @error('slug')
                                                <div class="alert alert-danger mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label">Designation *</label>
                                                <input type="text" class="form-control" name="designation"
                                                       value="{{$team_member->designation}}">
                                                @error('designation')
                                                <div class="alert alert-danger mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label">Email *</label>
                                                <input type="text" class="form-control" name="email"
                                                       value="{{$team_member->email}}">
                                                @error('email')
                                                <div class="alert alert-danger mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label">Adders *</label>
                                                <input type="text" class="form-control" name="address"
                                                       value="{{$team_member->address}}">
                                                @error('address')
                                                <div class="alert alert-danger mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label">Phone *</label>
                                                <input type="text" class="form-control" name="phone"
                                                       value="{{$team_member->phone}}">
                                                @error('phone')
                                                <div class="alert alert-danger mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label class="form-label">Facebook *</label>
                                                <input type="text" class="form-control" name="facebook"
                                                       value="{{$team_member->facebook}}">
                                                @error('facebook')
                                                <div class="alert alert-danger mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label class="form-label">Twitter *</label>
                                                <input type="text" class="form-control" name="twitter"
                                                       value="{{$team_member->twitter}}">
                                                @error('twitter')
                                                <div class="alert alert-danger mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label class="form-label">Linkedin *</label>
                                                <input type="text" class="form-control" name="linkedin"
                                                       value="{{$team_member->linkedin}}">
                                                @error('linkedin')
                                                <div class="alert alert-danger mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label class="form-label">Instagram *</label>
                                                <input type="text" class="form-control" name="instagram"
                                                       value="{{$team_member->instagram}}">
                                                @error('instagram')
                                                <div class="alert alert-danger mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Biography *</label>
                                        <textarea name="biography" class="form-control editor" cols="30"
                                                  rows="10">{{$team_member->biography}}</textarea>
                                        @error('biography')
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
