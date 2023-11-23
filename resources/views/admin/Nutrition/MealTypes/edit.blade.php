@extends('admin.master')
@section('dashboard')
    <div class="page-content-wrapper">
        <div class="content sm-gutter">
            <div class="container-fluid padding-25 sm-padding-10 py-1">
            <div class="card card-default mt-3">
                    <div class="card-header">
                        <h3 class="card-title">Edit Meal Type</h3>
                    </div>
                    <form action="{{ url('manager/nutrition/meal-types/' .$mealType->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        <div class="card-body">
                        <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Title (English)<span class="text-danger">*</span></label>
                                        <input type="text" maxlength="80" placeholder="Title" value="{{ $mealTypeEn->title }}" name="title_en" required class="form-control">
                                        @error('title_en')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Title (Arabic)<span class="text-danger">*</span></label>
                                        <input type="text" maxlength="80" placeholder="Title" value="{{ $mealTypeAr->title }}" required name="title_ar" class="form-control">
                                        @error('title_ar')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Image</label>
                                    <div>
                                        <input type="file" name="image" id="profile-img" style="border: 1px solid #ccc;
                                        border-radius: 7px;">
                                        <br/>
                                        <br/>
                                        @if(isset($mealType->image))
                                            <img id="profile-img-tag" src="{{ \Storage::url('files/mealTypes/images/' . $mealType->id . '/thumb-' . $mealType->image) }}" style="width: 120px; height: 110px; padding: 2px;">
                                        @else
                                            <img id="profile-img-tag" width="100px" height="100px"/>
                                        @endif
                                    </div>
                                    <br/>
                                    @error('image')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                        <div class="d-grid gap-10 col-1 mx-auto">
                            <button type="submit" class="btn btn-success" >Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

