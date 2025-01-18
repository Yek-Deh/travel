@extends('admin.layout.master')
@section('main_content')
    @include('admin.layout.nav')
    @include('admin.layout.sidebar')
    <div class="main-content">
        <section class="section">
            <div class="section-header justify-content-between">
                <h1>Itineraries of {{$package->name}}</h1>
                <div class="ml-auto">
                    <a href="{{route('admin_package_index')}}" class="btn btn-primary"><i class="fas fa-plus">back
                            to previous</i></a>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-body">
                                <h4>Existing Itineraries </h4>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th>SL</th>
                                            <th>Name</th>
                                            <th>Description</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($package_itineraries as $item)
                                            <tr>
                                                <td>{{$loop->iteration}}</td>
                                                <td>{{$item->name}}</td>
                                                <td>{!! $item->description !!}</td>
                                                <td>
                                                    <a href="{{route('admin_package_itinerary_delete',$item->id)}}"
                                                       class="btn btn-outline-danger btn-sm"
                                                       onclick="return confirm('Are you sure to delete?')">Delete</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h4>Add Itinerary </h4>
                                <form action="{{route('admin_package_itinerary_submit',$package->id)}}" method="post"
                                      enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label">Name *</label>
                                        <input name="name" type="text" class="form-control" value="{{old('name')}}">
                                        @error('name')
                                        <div class="alert alert-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Description *</label>
                                        <textarea name="description" class="form-control editor" cols="30" rows="10">{{old('description')}}</textarea>
                                        @error('description')
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

