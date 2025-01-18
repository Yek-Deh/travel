@extends('admin.layout.master')
@section('main_content')
    @include('admin.layout.nav')
    @include('admin.layout.sidebar')
    <div class="main-content">
        <section class="section">
            <div class="section-header justify-content-between">
                <h1>Edit FAQ</h1>
                <div class="ml-auto">
                    <a href="{{route('admin_faq_index')}}" class="btn btn-primary"><i class="fas fa-plus">View
                            All</i></a>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body w-50 m-auto ">
                                <form action="{{route('admin_faq_edit_submit',$faq->id)}}" method="post">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label">Question *</label>
                                        <input type="text" class="form-control" name="question"
                                               value="{{$faq->question}}">
                                        @error('question')
                                        <div class="alert alert-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Answer *</label>
                                        <textarea name="answer" class="form-control h_200" cols="30"
                                                  rows="10">{{$faq->answer}}</textarea>
                                        @error('answer')
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
