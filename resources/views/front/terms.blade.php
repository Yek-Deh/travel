@extends('front.layout.master')
@section('main_content')
    <div class="page-top" style="background-image: url({{asset('uploads/banner.jpg')}})">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>Terms of Use</h2>
                    <div class="breadcrumb-container">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                            <li class="breadcrumb-item active">Terms of Use</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="page-content pt_50 pb_50">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    {!! $term_privacy_item->term !!}
                </div>
            </div>
        </div>
    </div>

@endsection
