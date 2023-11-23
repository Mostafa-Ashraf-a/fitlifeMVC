@extends('admin.master')
@section('dashboard')

    <div class="page-content-wrapper">
        <!--Main Content-->
        <div class="content sm-gutter">
            <div class="container-fluid padding-25 sm-padding-10 py-2">
                <div class="card card-default mt-3">
                    <div class="card-header">
                        <h3 class="card-title">Add New FAQ</h3>
                    </div>
                    <form action="{{ url('manager/faqs/') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label mb-3">Question (English)<span
                                                class="text-danger">*</span></label>
                                        <input type="text" maxlength="80" placeholder="Title" name="question_en"
                                               class="form-control">
                                        @error('question_en')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label mb-3">Question (Arabic)<span
                                                class="text-danger">*</span></label>
                                        <input type="text" maxlength="80" placeholder="Title" name="question_ar"
                                               class="form-control">
                                        @error('question_ar')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label mb-3">Answer (English)<span
                                                class="text-danger">*</span></label>
                                        <textarea name="answer_en" class="form-control" id="editor-en"></textarea>
                                        @error('answer_en')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label mb-3">Answer (Arabic)<span
                                                class="text-danger">*</span></label>
                                        <textarea name="answer_ar" class="form-control" id="editor-ar"></textarea>
                                        @error('answer_ar')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                            </div>

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
