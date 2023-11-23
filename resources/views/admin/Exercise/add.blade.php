@extends('admin.master')
@section('dashboard')
    <div class="page-content-wrapper">
        <div class="content sm-gutter">
            <div class="container-fluid padding-25 sm-padding-10 py-1">
                <div class="card card-default mt-3">
                    <div class="card-header">
                        <h3 class="card-title">Add New Exercise</h3>
                    </div>
                    <form action="{{ url('manager/exercises') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                        <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Title (English) <span
                                                class="text-danger">*</span></label>
                                        <input type="text" maxlength="80" placeholder="Title" value="{{ old('title_en') }}"
                                               name="title_en" class="form-control">
                                        @error('title_en')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Title (Arabic)<span
                                                class="text-danger">*</span></label>
                                        <input type="text" maxlength="80" placeholder="Title" value="{{ old('title_ar') }}"
                                               name="title_ar" class="form-control">
                                        @error('title_ar')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label"> Exercise Place <span
                                                class="text-danger">*</span></label>
                                        <select class="form-control selectpicker" data-live-search="true" name="place">
                                            <option value="1">Gym Exercise</option>
                                            <option value="2">Home Exercise</option>
                                        </select>
                                        @error('place')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label"> Type <span class="text-danger">*</span></label>
                                        <select class="form-control selectpicker" data-live-search="true" name="exercise_category" id="exercise_category">
                                            <option value="">choose Exercise Type</option>
                                            @foreach($exerciseTypes as $exerciseType)
                                                <option value="{{ $exerciseType->id }}">{{ $exerciseType->value }}</option>
                                            @endforeach
                                        </select>
                                        @error('exercise_category')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Body Parts </label>
                                        <select class="form-control selectpicker" data-live-search="true" name="body_part_id" id="body_part_id">
                                            <option disabled selected>Choose Body Parts</option>
                                            @foreach($bodyParts as $bodyPart)
                                                <option value="{{ $bodyPart->id }}">{{ $bodyPart->title }}</option>
                                            @endforeach
                                        </select>
                                        @error('body_part_id')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Equipment</label>
                                        <select class="form-control selectpicker" data-live-search="true" name="equipment_id">
                                            <option value="">choose Equipment</option>
                                            @foreach($equipments as $equipment)
                                                <option value="{{ $equipment->id }}">{{ $equipment->title }}</option>
                                            @endforeach
                                        </select>
                                        @error('equipment_id')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Level</label>
                                        <select class="form-control selectpicker" data-live-search="true" name="level_id">
                                            <option value="">choose Level</option>
                                            @foreach($levels as $level)
                                                <option value="{{ $level->id }}">{{ $level->title }}</option>
                                            @endforeach
                                        </select>
                                        @error('level_id')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="control-label">Instructions (English)<span
                                                class="text-danger">*</span></label>
                                        <textarea name="instruction_en" class="form-control"
                                                  id="editor-en">{{ old('instruction_en') }}</textarea>
                                        @error('instruction_en')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Instructions (Arabic)<span class="text-danger">*</span></label>
                                        <textarea name="instruction_ar" class="form-control"
                                                  id="editor-ar">{{ old('instruction_ar') }}</textarea>
                                        @error('instruction_ar')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="control-label">Tips (English)<span
                                                class="text-danger">*</span></label>
                                        <textarea name="tip_en" class="form-control"
                                                  id="editor-en-3">{{ old('tip_en') }}</textarea>
                                        @error('tip_en')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Tips (Arabic)<span class="text-danger">*</span></label>
                                        <textarea name="tip_ar" class="form-control"
                                                  id="editor-ar-3">{{ old('instruction_ar') }}</textarea>
                                        @error('tip_ar')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6 video-input">
                                    <div class="form-group">
                                        <label class="control-label">Video (MP4)</label>
                                        <input type="file" name="video" class="form-control" accept="video/mp4" style="border: 1px solid #ccc;
                                        border-radius: 7px;">
                                        @error('video')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
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
                        <!-- end-row -->
                        <div class="d-grid gap-10 col-1 mx-auto">
                                    <button type="submit" class="btn btn-success" style="padding: 5px 52px; border-radius: 15px;">Save</button>
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
            $('#exercise_category').on('change', function () {
                if ($(this).val() == 4) {
                    $('#body_part_id').val(16).attr('selected', 'selected');
                    $('#body_part_id').attr('disabled', true);
                } else {
                    $('#body_part_id').attr('disabled', false);
                    $('#body_part_id').val().attr('selected', 'selected');
                }
            });
        });
    </script>
@endsection
