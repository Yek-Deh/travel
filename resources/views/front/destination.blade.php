@extends('front.layout.master')
@section('main_content')

    <div class="page-top" style="background-image: url({{asset('uploads/banner.jpg')}})">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>{{$destination->name}}</h2>
                    <div class="breadcrumb-container">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{route('destinations')}}">Destinations</a></li>
                            <li class="breadcrumb-item active">{{$destination->name}}</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="destination-detail pt_50 pb_50">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="main-item mb_50">
                        <div class="main-photo">
                            <img src="{{asset('uploads/'.$destination->featured_photo)}}" alt="">
                        </div>
                    </div>
                    <div class="main-item mb_50">
                        <h2>Description</h2>
                        {!! $destination->description!!}
                    </div>

                    {{--Packages--}}
                    @if($packages->count()>0)
                        <div class="main-item mb_50">
                            <h2>Packages</h2>
                            <div class="package">
                                <div class="row">
                                    @foreach($packages as $item)
                                        <div class="col-lg-4 col-md-6">
                                            <div class="item pb_25">
                                                <div class="photo">
                                                    <a href="{{route('package',$item->slug)}}" target="_blank"><img
                                                            src="{{asset('uploads/'.$item->featured_photo)}}"
                                                            alt=""></a>
                                                    <div class="wishlist">
                                                        <a href="{{route('wishlist',$item->id)}}"><i class="far fa-heart"></i></a>
                                                    </div>
                                                </div>
                                                <div class="text">
                                                    <div class="price">
                                                        ${{$item->price}}
                                                        @if($item->old_price != '')
                                                            <del>${{$item->old_price}}</del>
                                                        @endif

                                                    </div>
                                                    <h2>
                                                        <a href="{{route('package',$item->slug)}}"
                                                           target="_blank">{{$item->name}}</a>
                                                    </h2>
                                                    @if($item->total_score || $item->total_rating)
                                                        <div class="review">
                                                            @php
                                                                $rating = ceil($item->total_score/$item->total_rating);
                                                            @endphp
                                                            @for($i=1; $i <= 5; $i++)
                                                                @if($i <= $rating)
                                                                    <i class="fas fa-star"></i>
                                                                @elseif($i-0.5 <= $rating)
                                                                    <i class="fas fa-star-half-alt"></i>
                                                                @else
                                                                    <i class="far fa-star"></i>
                                                                @endif
                                                            @endfor
                                                                        ({{$item->reviews->count()}} Reviews)
                                                        </div>
                                                    @else
                                                        <div class="review">
                                                            @for($i=1; $i<=5; $i++)
                                                                <i class="far fa-star"></i>
                                                            @endfor
                                                            ({{$item->reviews->count()}} Reviews)
                                                        </div>
                                                    @endif
                                                    <div class="element">
                                                        <div class="element-left">
                                                            <i class="fas fa-plane-departure"></i> {{$item->destination->name}}
                                                        </div>
                                                        <div class="element-right">
                                                            <i class="fas fa-th-large"></i> {{$item->package_amenities->count()}}
                                                            Amenities
                                                        </div>
                                                    </div>
                                                    <div class="element">
                                                        <div class="element-left">
                                                            <i class="fas fa-users"></i> {{$item->tours->count()}} Tours
                                                        </div>
                                                        <div class="element-right">
                                                            <i class="fas fa-clock"></i> {{$item->package_itineraries->count()}}
                                                            Days
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif


                    <div class="main-item mb_50">
                        <h2>
                            Information
                        </h2>
                        <div class="summary">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <tr>
                                        <td><b>Country</b></td>
                                        <td>{{$destination->country}}</td>
                                    </tr>
                                    <tr>
                                        <td><b>Visa Requirements</b></td>
                                        <td>{!! $destination->visa_requirement !!}</td>
                                    </tr>
                                    <tr>
                                        <td><b>Languages Spoken</b></td>
                                        <td>{{$destination->language}}</td>
                                    </tr>
                                    <tr>
                                        <td><b>Currency Used</b></td>
                                        <td>{{$destination->currency}}</td>
                                    </tr>
                                    <tr>
                                        <td><b>Activities</b></td>
                                        <td>{!! $destination->activity !!}</td>
                                    </tr>
                                    <tr>
                                        <td><b>Best Time to Visit</b></td>
                                        <td>{!! $destination->best_time !!}</td>
                                    </tr>
                                    <tr>
                                        <td><b>Health and Safety</b></td>
                                        <td>{!! $destination->health_safety !!}</td>
                                    </tr>
                                    <tr>
                                        <td><b>Area</b></td>
                                        <td>{!! $destination->area !!}</td>
                                    </tr>
                                    <tr>
                                        <td><b>Time Zone</b></td>
                                        <td>{!! $destination->timezone !!}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>


                    {{-- photos --}}
                    @if($destination_photos->count()>0)
                        <div class="main-item mb_50">
                            <h2>
                                Photos
                            </h2>
                            <div class="photo-all">
                                <div class="row">
                                    @foreach($destination_photos as $destination_photo)
                                        <div class="col-md-6 col-lg-3">
                                            <div class="item">
                                                <a href="{{asset('uploads/'.$destination_photo->photo)}}"
                                                   class="magnific">
                                                    <img src="{{asset('uploads/'.$destination_photo->photo)}}" alt="">
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- videos --}}
                    @if($destination_videos->count()>0)
                        <div class="main-item mb_50">
                            <h2>
                                Videos
                            </h2>
                            <div class="video-all">
                                <div class="row">
                                    @foreach($destination_videos as $destination_video)
                                        <div class="col-md-6 col-lg-6">
                                            <div class="item">
                                                <a class="video-button"
                                                   href="http://www.youtube.com/watch?v={{$destination_video->video}}">
                                                    <img
                                                        src="http://img.youtube.com/vi/{{$destination_video->video}}/0.jpg"
                                                        alt="">
                                                    <div class="icon">
                                                        <i class="far fa-play-circle"></i>
                                                    </div>
                                                    <div class="bg"></div>
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
                    {{-- map --}}
                    @if($destination->map != '')
                        <div class="main-item">
                            <h2>Map</h2>
                            <div class="location-map">
                                {!! $destination->map !!}
                                {{--                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d29736668.18356832!2d111.81148767494898!3d-24.521314978627814!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2b2bfd076787c5df%3A0x538267a1955b1352!2sAustralia!5e0!3m2!1sen!2sbd!4v1716870853572!5m2!1sen!2sbd" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>--}}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
