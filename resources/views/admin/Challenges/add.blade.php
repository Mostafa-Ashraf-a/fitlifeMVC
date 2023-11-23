@extends('admin.master')
@section('dashboard')

    <div class="page-content-wrapper">
        <!--Main Content-->
        <div class="content sm-gutter">
            <div class="container-fluid padding-25 sm-padding-10 py-2">
                <div class="card card-default mt-3">
                    <div class="card-header">
                        <h3 class="card-title">Add New Challenge</h3>
                    </div>
                    <form action="{{ url('manager/challenges') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Title (English) <span class="text-danger">*</span></label>
                                        <input type="text" maxlength="80" placeholder="Title En" name="title_en"
                                               class="form-control">
                                        @error('title_en')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Title (Arabic)<span
                                                class="text-danger">*</span></label>
                                        <input type="text" maxlength="80" placeholder="Title Ar" name="title_ar"
                                               class="form-control">
                                        @error('title_ar')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Description (English)<span
                                                class="text-danger">*</span></label>
                                        <textarea name="description_en" class="form-control" id="editor-en"></textarea>
                                        @error('description_en')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Description (Arabic)<span
                                                class="text-danger">*</span></label>
                                        <textarea name="description_ar" class="form-control" id="editor-ar"></textarea>
                                        @error('description_ar')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Exercise <span class="text-danger">*</span></label>
                                        <select class="form-control selectpicker" data-live-search="true" name="exercise_id[]" multiple>
                                            @foreach($exercises as $exercise)
                                                <option value="{{ $exercise->id }}">{{ $exercise->title }}</option>
                                            @endforeach
                                        </select>
                                        @error('exercise_id')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Image</label>
                                        <div>
                                            <input type="file" name="image" onchange="loadFile(event)"/>
                                            <img id="output" width="100px" height="100px"/>
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
                                <button type="submit" class="btn btn-success"
                                        style="padding: 5px 52px; border-radius: 15px;">Save
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function () {
            $('.selectpicker').selectpicker('refresh');
        });
    </script>
@endsection
