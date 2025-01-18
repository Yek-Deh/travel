@extends('admin.layout.master')
@section('main_content')
    @include('admin.layout.nav')
    @include('admin.layout.sidebar')
    <div class="main-content">
        <section class="section">
            <div class="section-header justify-content-between">
                <h1>Photos of {{$destination->name}}</h1>
                <div class="ml-auto">
                    <a href="{{route('admin_destination_index')}}" class="btn btn-primary"><i class="fas fa-plus">back
                            to previous</i></a>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-md-7">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th>SL</th>
                                            <th>Photo</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($destination_photos as $destination_photo)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td><img src="{{asset('uploads/'.$destination_photo->photo)}}" alt="" class="w_100"></td>
                                            <td>
                                                <a href="{{route('admin_destination_photo_delete',$destination_photo->id)}}" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure to delete?')">Delete</a>
                                            </td>
                                        </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{route('admin_destination_photo_submit',$destination->id)}}" method="post"
                                      enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label">Photo *</label>
                                        <div><input type="file" name="photo"></div>
                                        @error('photo')
                                        <div class="alert alert-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
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

