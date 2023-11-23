@extends('admin.master')
@section('dashboard')
    <div class="page-content-wrapper">
        <!--Main Content-->
        <div class="content sm-gutter">
            <div class="container-fluid padding-25 sm-padding-10 py-2">
            <div class="card card-default mt-3">
                    <div class="card-header">
                        <h3 class="card-title">Edit Equipment</h3>
                    </div>
                    <form action="{{ url('manager/equipments/' . $equipment->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                        <div class="card-body">
                        <div class="row">

                                <div class="col-md-6">
                                <div class="form-group">
                                                    <label class="control-label">Title (English)<span class="text-danger">*</span></label>
                                                    <input type="text" maxlength="80" placeholder="Title" value="{{ $equipmentEn->title }}" name="title_en" class="form-control">
                                                    @error('title_en')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                </div>
                                <div class="col-md-6">
                                <div class="form-group">
                                                    <label class="control-label">Title (Arabic)<span class="text-danger">*</span></label>
                                                    <input type="text" maxlength="80" placeholder="Title" value="{{ $equipmentAr->title }}" name="title_ar" class="form-control">
                                                    @error('title_ar')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                </div>
                                <div class="col-md-6">
                                <div class="form-group">
                                                    <label class="control-label">Image</label>
                                                    <div>
                                                        <input type="file" name="image" id="profile-img">
                                                        <br/>
                                                        <br/>
                                                        @if(isset($equipment->image))
                                                            <img id="profile-img-tag" src="{{ \Storage::url('files/equipments/images/' . $equipment->id . '/thumb-' . $equipment->image) }}" style="width: 120px; height: 110px; padding: 2px;">
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
                        <!-- end-row -->
                        <div class="d-grid gap-10 col-1 mx-auto">
                            <button type="submit" class="btn btn-success"  style="padding: 5px 52px; border-radius: 15px;">Update</button>
                        </div>
                    </div>
                    </form>
                </div>
                <!-- <div class="row">
                    <div class="col-12">
                        <div class="section-title">
                            <h5>Edit Equipment</h5>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="block table-block mb-4" style="margin-top: 20px;">
                            <div class="row">
                                <form action="{{ url('manager/equipments/' . $equipment->id) }}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    @method('put')
                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <div class="block col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label">Title (English)<span class="text-danger">*</span></label>
                                                    <input type="text" maxlength="80" placeholder="Title" value="{{ $equipmentEn->title }}" name="title_en" class="form-control">
                                                    @error('title_en')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>

                                                <div class="form-group">
                                                    <label class="control-label">Title (Arabic)<span class="text-danger">*</span></label>
                                                    <input type="text" maxlength="80" placeholder="Title" value="{{ $equipmentAr->title }}" name="title_ar" class="form-control">
                                                    @error('title_ar')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>

                                                <div class="form-group">
                                                    <label class="control-label">Image</label>
                                                    <div>
                                                        <input type="file" name="image" id="profile-img">
                                                        <br/>
                                                        <br/>
                                                        @if(isset($equipment->image))
                                                            <img id="profile-img-tag" src="{{ \Storage::url('files/equipments/images/' . $equipment->id . '/thumb-' . $equipment->image) }}" style="width: 120px; height: 110px; padding: 2px;">
                                                        @else
                                                            <img id="profile-img-tag" width="100px" height="100px"/>
                                                        @endif
                                                    </div>
                                                    <br/>
                                                    @error('image')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <br/>
                                                <br/>
                                                <div class="d-grid gap-10 col-1 mx-auto">
                                                    <button type="submit" class="btn btn-success" >Update</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div> -->
            </div>
        </div>
    </div>
@endsection
