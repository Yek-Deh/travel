@extends('front.layout.master')
@section('main_content')
    <div class="page-top" style="background-image: url({{asset('uploads/banner.jpg')}})">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>Review</h2>
                    <div class="breadcrumb-container">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                            <li class="breadcrumb-item active">Review</li>
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
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tbody>
                            <tr>
                                <th>SL</th>
                                <th>Photo</th>
                                <th>Package</th>
                                <th>My Review</th>
                                <th>My Comment</th>
                            </tr>
                            @foreach($reviews as $review)
                                <tr>
                                    <td class="align-content-center">{{$loop->iteration}}</td>
                                    <td>
                                        <img src="{{asset('uploads/'.$review->package->featured_photo)}}" alt=""
                                             class="w-200">
                                    </td>
                                    <td class="align-content-center">
                                        {{$review->package->name}}<br>
                                        <a href="{{route('package',$review->package->slug)}}" target="_blank" class="text-decoration-underline">See Details</a>
                                    </td>
                                    <td class="align-content-center">
                                        <div class="review">
                                            @for($i=1; $i <= 5; $i++)
                                                @if($i <= $review->rating)
                                                    <i class="fas fa-star"></i>
                                                @else
                                                    <i class="far fa-star"></i>
                                                @endif
                                            @endfor
                                        </div>
                                    </td>
                                    <td class="align-content-center">
                                        <a href="" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                           data-bs-target="#exampleModal{{$loop->iteration}}">Comment</a>
                                    </td>
                                </tr>

                                <!-- Modal -->
                                <div class="modal fade" id="exampleModal{{$loop->iteration}}" tabindex="-1"
                                     aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="exampleModalLabel">Comment</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3 row">
                                                    <div class="col-md-12">{!! $review->comment !!}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- // Modal -->
                            @endforeach
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
