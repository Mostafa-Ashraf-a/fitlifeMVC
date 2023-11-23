@extends('admin.master')
@section('dashboard')
    <div class="page-content-wrapper">
        <!--Main Content-->
        <div class="content sm-gutter">
            <div class="container-fluid padding-25 sm-padding-10">
                <div class="row">
                    <div class="col-12">
                        <div class="section-title">
                            <h5>Edit Tag</h5>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="block table-block mb-4" style="margin-top: 20px;">
                            <div class="row">
                                <form action="{{ url('manager/tags/update/') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="tag_id" value="{{ $id }}">
                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <div class="block col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label">Title (English)<span class="text-danger">*</span></label>
                                                    <input type="text" maxlength="80" placeholder="Title" value="{{ $tagEn->title_en }}" name="title_en" class="form-control">
                                                    @error('title_en')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <br/>

                                                <div class="form-group">
                                                    <label class="control-label">Title (Arabic)<span class="text-danger">*</span></label>
                                                    <input type="text" maxlength="80" placeholder="Title Ar" value="{{ $tagAr->title_ar }}" name="title_ar" class="form-control">
                                                    @error('title_ar')
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
