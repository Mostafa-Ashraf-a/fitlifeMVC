@extends('admin.master')
@section('dashboard')
    <div class="page-content-wrapper">
        <!--Main Content-->
        <div class="content sm-gutter">
            <div class="container-fluid padding-25 sm-padding-10 py-2">
                <div class="card card-default mt-3">
                    <div class="card-header">
                        <h3 class="card-title">Setting</h3>
                    </div>
                    <form action="{{ url('manager/settings/' . $setting->id) }}" method="POST"
                          enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        <div class="card-body">
                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Privacy Policy (English)<span
                                                class="text-danger">*</span></label>
                                        <textarea name="privacy_policy_en" class="form-control"
                                                  id="editor-en"> {{ $settingEn->privacy_policy }} </textarea>
                                        @error('privacy_policy_en')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Privacy Policy (Arabic)<span
                                                class="text-danger">*</span></label>
                                        <textarea name="privacy_policy_ar" class="form-control"
                                                  id="editor-ar"> {{ $settingAr->privacy_policy }} </textarea>
                                        @error('privacy_policy_ar')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="control-label">Terms Of Service (English)<span
                                                class="text-danger">*</span></label>
                                        <textarea name="terms_of_service_en" class="form-control"
                                                  id="editor-en-3"> {{ $settingEn->terms_of_service }} </textarea>
                                        @error('terms_of_service_en')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Terms Of Service (Arabic)<span class="text-danger">*</span></label>
                                        <textarea name="terms_of_service_ar" class="form-control"
                                                  id="editor-ar-3"> {{ $settingAr->terms_of_service }} </textarea>
                                        @error('terms_of_service_ar')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="control-label">About Us (English)<span
                                                class="text-danger">*</span></label>
                                        <textarea name="about_us_en" class="form-control"
                                                  id="editor-en-4"> {{ $settingEn->about_us }} </textarea>
                                        @error('about_us_en')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">About Us (Arabic)<span class="text-danger">*</span></label>
                                        <textarea name="about_us_ar" class="form-control"
                                                  id="editor-ar-4"> {{ $settingAr->about_us }} </textarea>
                                        @error('about_us_ar')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                            </div>



                            <br>
                            <br>
                            <hr>
                            <h2 style="text-align: center;font-weight: bold;">Contact Us Details</h2>
                            <hr>

                            <div class="row col-12">

                                <div class="col-6">
                                    <label class="form-label">Mobile (+966)</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                        </div>
                                        <input name="mobile" type="text"
                                               value="{{ $setting->mobile }}"
                                               class="form-control @error('mobile') is-invalid @enderror"
                                               autocomplete="off" placeholder="512345678">
                                    </div>
                                    @error('mobile')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>


                                <div class="col-6">
                                    <label  class="form-label">Email</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                        </div>
                                        <input name="email" type="email"
                                               value="{{ $setting->email }}"
                                               class="form-control @error('email') is-invalid @enderror"
                                               autocomplete="off" max="70"
                                               placeholder="Email">
                                    </div>
                                    @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>


                                <div class="col-6 mt-4">
                                    <label  class="form-label">Site Url</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-link"></i></span>
                                        </div>
                                        <input name="site_url" type="text"
                                               value="{{ $setting->site_url }}"
                                               class="form-control @error('site_url') is-invalid @enderror"
                                               autocomplete="off" max="70"
                                               placeholder="Site Url">
                                    </div>
                                    @error('site_url')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-6 mt-4">
                                    <div class="form-group">
                                        <label class="control-label">Mobile Introduction Video (MP4) </label>
                                        <input type="file" name="intro_video" class="form-control" accept="video/mp4" style="border: 1px solid #ccc;
                                        border-radius: 7px;">
                                        @if(isset($setting->intro_video))
                                            <video width="320" height="240" controls>
                                                <source
                                                    src="{{ \Storage::url('files/settings/videos/' . $setting->id . '/' . $setting->intro_video) }}"
                                                    type="video/mp4">
                                            </video>
                                        @endif
                                        @error('intro_video')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <br>
                            <br>
                            <div class="d-grid gap-10 col-1 mx-auto">
                                <button type="submit" class="btn btn-success"
                                        style="padding: 5px 52px; border-radius: 15px;">Update
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
