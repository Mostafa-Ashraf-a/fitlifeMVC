@extends('admin.master')
@section('dashboard')
    <div class="page-content-wrapper">
        <div class="content sm-gutter">
            <div class="container-fluid padding-25 sm-padding-10 py-2">
            <div class="card card-default mt-3">
                    <div class="card-header">
                        <h3 class="card-title">Edit Tip Of The Day</h3>
                    </div>
                    <form action="{{ url('manager/tips/' . $id) }}" method="POST">
                                    @csrf
                                    @method('put')
                        <div class="card-body">
                        <div class="row">

                                <div class="col-md-6">
                                <div class="form-group">
                                                    <label class="control-label mb-1">Title (English) <span class="text-danger">*</span></label>
                                                    <input type="text" maxlength="80" placeholder="Title" value="{{ $tipEn->title_en }}" name="title_en" class="form-control">
                                                    @error('title_en')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                </div>
                                <div class="col-md-6">
                                <div class="form-group mb-2">
                                                    <label class="control-label mb-1">Title (Arabic) <span class="text-danger">*</span></label>
                                                    <input type="text" maxlength="80" placeholder="Title" value="{{ $tipAr->title_ar }}" name="title_ar" class="form-control">
                                                    @error('title_ar')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                </div>
                                <div class="col-md-6">
                                <div class="form-group">
                                                    <label class="control-label">Content (English)<span class="text-danger">*</span></label>
                                                    <textarea name="content_en" class="form-control"  id="editor-en">{{ $tipEn->content_en }}</textarea>
                                                    @error('title_en')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                </div>
                                <div class="col-md-6">
                                <div class="form-group">
                                                    <label class="control-label">Content (Arabic)<span class="text-danger">*</span></label>
                                                    <textarea name="content_ar" class="form-control"  id="editor-ar">{{ $tipAr->content_ar }}</textarea>
                                                    @error('title_ar')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                </div>


                        </div>
                        <!-- end-row -->
                        <div class="d-grid gap-10 col-1 mx-auto mt-5">
                            <button type="submit" class="btn btn-success" style="padding: 5px 52px; border-radius: 15px;">Update</button>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
