@extends('admin.master')
@section('dashboard')
    <div class="page-content-wrapper">
        <div class="content sm-gutter">
            <div class="container-fluid padding-25 sm-padding-10 py-1">
                <div class="card card-default mt-3">
                    <div class="card-header">
                        <h3 class="card-title">Add New Meal Type</h3>
                    </div>
                    <form action="{{ url('manager/nutrition/meal-types') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                        <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Title (English) <span
                                                class="text-danger">*</span></label>
                                        <input type="text" maxlength="80" placeholder="Title" value="{{ old('title_en') }}"
                                               name="title_en" class="form-control" required>
                                        @error('title_en')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Title (Arabic)<span
                                                class="text-danger">*</span></label>
                                        <input type="text" maxlength="80" placeholder="Title" required value="{{ old('title_ar') }}"
                                               name="title_ar" class="form-control">
                                        @error('title_ar')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                        </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Image</label>
                                    <div>
                                        <input type="file" name="image" onchange="loadFile(event)" class="d-block mb-3" style="border: 1px solid #ccc;
    border-radius: 7px;"/>
                                        <img id="output" width="100px" height="100px"/>
                                    </div>
                                    <br/>
                                    @error('image')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                    </div>
                        <div class="d-grid gap-10 col-1 mx-auto mt-2">
                            <button type="submit" class="btn btn-success">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

