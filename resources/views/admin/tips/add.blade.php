@extends('admin.master')
@section('dashboard')

    <div class="page-content-wrapper">
        <!--Main Content-->
        <div class="content sm-gutter">
            <div class="container-fluid padding-25 sm-padding-10 py-2">
            <div class="card card-default mt-3">
                    <div class="card-header">
                        <h3 class="card-title">Add New Tip Of The Day</h3>
                    </div>
                    <form action="{{ url('manager/tips') }}" method="POST">
                                    @csrf
                        <div class="card-body">
                        <div class="row">
                                <div class="col-md-6">
                                <div class="form-group">
                                                    <label class="control-label">Title (English)<span class="text-danger">*</span></label>
                                                    <input name="title_en" value="{{ old('title_en') }}" class="form-control">
                                                    @error('title_en')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                </div>
                                <div class="col-md-6">
                                <div class="form-group">
                                                    <label class="control-label">Title (Arabic)<span class="text-danger">*</span></label>
                                                    <input name="title_ar" value="{{ old('title_ar') }}" class="form-control">
                                                    @error('title_ar')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                </div>
                                <div class="col-md-6">
                                <div class="form-group">
                                                    <label class="control-label">Content (English)<span class="text-danger">*</span></label>
                                                    <textarea name="content_en" class="form-control" id="editor-en">{{ old('content_en') }}</textarea>
                                                    @error('content_en')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                </div>
                                <div class="col-md-6">
                                <div class="form-group">
                                                    <label class="control-label">Content (Arabic)<span class="text-danger">*</span></label>
                                                    <textarea name="content_ar" class="form-control" id="editor-ar">{{ old('content_ar') }}</textarea>
                                                    @error('content_ar')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                </div>



                        </div>
                        <!-- end-row -->
                        <div class="d-grid gap-10 col-1 mx-auto  mt-5">
                                <button type="submit" class="btn btn-success" style="padding: 5px 52px; border-radius: 15px;" >Save</button>
                        </div>
                    </div>
                    </form>
                </div>
                <!-- <div class="row">
                    <div class="col-12">
                        <div class="section-title">
                            <h5>Add New Tip Of The Day</h5>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="block table-block mb-4" style="margin-top: 20px;">
                            <div class="row">
                                <form action="{{ url('manager/tips') }}" method="POST">
                                    @csrf
                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <div class="block col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label">Title (English)<span class="text-danger">*</span></label>
                                                    <input name="title_en" value="{{ old('title_en') }}" class="form-control">
                                                    @error('title_en')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>

                                                <div class="form-group">
                                                    <label class="control-label">Title (Arabic)<span class="text-danger">*</span></label>
                                                    <input name="title_ar" value="{{ old('title_ar') }}" class="form-control">
                                                    @error('title_ar')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <br/>


                                                <div class="form-group">
                                                    <label class="control-label">Content (English)<span class="text-danger">*</span></label>
                                                    <textarea name="content_en" class="form-control" id="editor-en">{{ old('content_en') }}</textarea>
                                                    @error('content_en')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>

                                                <div class="form-group">
                                                    <label class="control-label">Content (Arabic)<span class="text-danger">*</span></label>
                                                    <textarea name="content_ar" class="form-control" id="editor-ar">{{ old('content_ar') }}</textarea>
                                                    @error('content_ar')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>

                                                <div class="d-grid gap-10 col-1 mx-auto  mt-5">
                                                    <button type="submit" class="btn btn-success" >Save</button>
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
