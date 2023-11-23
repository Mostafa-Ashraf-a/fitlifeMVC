@extends('admin.master')
@section('dashboard')
    <div class="page-content-wrapper">
        <!--Main Content-->
        <div class="content sm-gutter">
            <div class="container-fluid padding-25 sm-padding-10">
                <div class="row">
                    <div class="col-12">
                        <div class="section-title">
                            <h5>Edit Challenge</h5>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="block table-block mb-4" style="margin-top: 20px;">
                            <div class="row">
                                <form method="post" action="{{ url('manager/challenges/update/' . $challenge->id) }}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <div class="block col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label">Title (English)<span class="text-danger">*</span></label>
                                                    <input type="text" maxlength="80" placeholder="Title" value="{{ $challengeEn->title }}" name="title_en" class="form-control">
                                                    @error('title_en')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <br/>

                                                <div class="form-group">
                                                    <label class="control-label">Title (Arabic)<span class="text-danger">*</span></label>
                                                    <input type="text" maxlength="80" placeholder="Title Ar" value="{{ $challengeAr->title }}" name="title_ar" class="form-control">
                                                    @error('title_ar')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <br/>

                                                <div class="form-group">
                                                    <label class="control-label">Description (English)<span class="text-danger">*</span></label>
                                                    <textarea name="description_en" class="form-control"  id="editor-en">{{ $challengeEn->description }}</textarea>
                                                    @error('description_en')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>

                                                <div class="form-group">
                                                    <label class="control-label">Description (Arabic)<span class="text-danger">*</span></label>
                                                    <textarea name="description_ar" class="form-control"  id="editor-ar">{{ $challengeAr->description }}</textarea>
                                                    @error('description_ar')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>

                                                <div class="form-group">
                                                    <label class="control-label">Exercise <span class="text-danger">*</span></label>
                                                    <select class="form-control my-select" name="exercise_id[]" multiple="multiple">
                                                        @foreach($exercises as $exercise)
                                                            <option  @foreach($challenge->exercises as $challengeExercise) @if(($challengeExercise->id == $exercise->id))  selected="selected" @endif @endforeach value="{{ $exercise->id }}">{{ $exercise->title }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('exercise_id')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>


                                                <div class="form-group">
                                                    <label class="control-label">Image <span class="text-danger">*</span></label>
                                                    <div>
                                                        <input type="file" name="image" id="profile-img">
                                                        <br/>
                                                        <img id="profile-img-tag" src="{{ asset('assets/images/challenges/' . $challenge->image ) }}" style="width: 120px; height: 110px; padding: 2px;">
                                                    </div>
                                                    <span class="text-danger recomendedsize">Recommended size: <b>550 x 350</b> </span>
                                                    <br/>
                                                    @error('image')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <br/>
                                                <br/>
                                                <div class="action-button">
                                                    <input type="submit" name="save" value="Update" class="btn btn-embossed btn-primary">
                                                    <input type="reset" name="reset" value="Reset" class="btn btn-embossed btn-danger">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
