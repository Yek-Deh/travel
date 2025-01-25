@extends('admin.layout.master')
@section('main_content')
    @include('admin.layout.nav')
    @include('admin.layout.sidebar')
    <div class="main-content">
        <section class="section">
            <div class="section-header justify-content-between">
                <h1>Edit Setting</h1>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{route('admin_setting_update',$setting->id)}}" method="post"
                                      enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label">Existing Logo</label>
                                                <div>
                                                    @if($setting->logo != '')
                                                        <img src="{{asset('uploads/'.$setting->logo)}}" alt="" srcset=""
                                                             class="w_150">
                                                    @else
                                                        <img src="{{asset('uploads/default.png')}}" alt="" srcset=""
                                                             class="w_150">
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Change Logo</label>
                                                <div><input type="file" name="logo"></div>
                                                @error('logo')
                                                <div class="alert alert-danger mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label">Existing Favicon</label>
                                                <div>
                                                    @if($setting->favicon != '')
                                                        <img src="{{asset('uploads/'.$setting->favicon)}}" alt=""
                                                             srcset=""
                                                             class="w_150">
                                                    @else
                                                        <img src="{{asset('uploads/default.png')}}" alt="" srcset=""
                                                             class="w_150">
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Change Favicon</label>
                                                <div><input type="file" name="favicon"></div>
                                                @error('favicon')
                                                <div class="alert alert-danger mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">

                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label for="name">Top Bar Phone *</label>
                                                <input type="text" name="top_bar_phone" class="form-control"
                                                       value="{{$setting->top_bar_phone}}">
                                                @error('top_bar_phone')
                                                <div class="alert alert-danger mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label for="email">Top Bar Email *</label>
                                                <input type="text" name="top_bar_email" class="form-control"
                                                       value="{{$setting->top_bar_email}}">
                                                @error('top_bar_email')
                                                <div class="alert alert-danger mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label for="name">Footer Address *</label>
                                                <input type="text" name="footer_address" class="form-control"
                                                       value="{{$setting->footer_address}}">
                                                @error('footer_address')
                                                <div class="alert alert-danger mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label for="name">Footer Phone *</label>
                                                <input type="text" name="footer_phone" class="form-control"
                                                       value="{{$setting->footer_phone}}">
                                                @error('footer_phone')
                                                <div class="alert alert-danger mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label for="email">Footer Email *</label>
                                                <input type="text" name="top_bar_email" class="form-control"
                                                       value="{{$setting->footer_email}}">
                                                @error('footer_email')
                                                <div class="alert alert-danger mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label for="email">Facebook *</label>
                                                <input type="text" name="facebook" class="form-control"
                                                       value="{{$setting->facebook}}">
                                                @error('facebook')
                                                <div class="alert alert-danger mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label for="email">Twitter *</label>
                                                <input type="text" name="twitter" class="form-control"
                                                       value="{{$setting->twitter}}">
                                                @error('twitter')
                                                <div class="alert alert-danger mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label for="email">Youtube *</label>
                                                <input type="text" name="youtube" class="form-control"
                                                       value="{{$setting->youtube}}">
                                                @error('youtube')
                                                <div class="alert alert-danger mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="email">Linkedin *</label>
                                                <input type="text" name="linkedin" class="form-control"
                                                       value="{{$setting->linkedin}}">
                                                @error('linkedin')
                                                <div class="alert alert-danger mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="email">Instagram *</label>
                                                <input type="text" name="instagram" class="form-control"
                                                       value="{{$setting->instagram}}">
                                                @error('instagram')
                                                <div class="alert alert-danger mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="email">Copyright Text *</label>
                                                <input type="text" name="copyright" class="form-control"
                                                       value="{{$setting->copyright}}">
                                                @error('copyright')
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

