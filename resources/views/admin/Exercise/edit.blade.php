@extends('admin.master')

@section('dashboard')
    <div class="page-content-wrapper">
        <!--Main Content-->
        <div class="content sm-gutter">
            <div class="container-fluid padding-25 sm-padding-10 py-1">
                <div class="card card-default mt-3">
                    <div class="card-header">
                        <h3 class="card-title">Edit Exercise</h3>
                    </div>
                    <form action="{{ url('manager/exercises/' .$exercise->id) }}" method="post"
                          enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        <div class="card-body">
                            <div class="row">

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Title (English)<span
                                                class="text-danger">*</span></label>
                                        <input type="text" maxlength="80" placeholder="Title"
                                               value="{{ $exerciseEn->title }}" name="title_en" class="form-control">
                                        @error('title_en')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Title (Arabic)<span
                                                class="text-danger">*</span></label>
                                        <input type="text" maxlength="80" placeholder="Title"
                                               value="{{ $exerciseAr->title }}" name="title_ar" class="form-control">
                                        @error('title_ar')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label"> Exercise Place <span class="text-danger">*</span></label>
                                        <select class="form-control selectpicker" data-live-search="true" name="place">
                                            <option value="1" {{ $exercise->place == "1" ? 'selected' : '' }}>Gym
                                                Exercise
                                            </option>
                                            <option value="2" {{ $exercise->place == "2" ? 'selected' : '' }}>Home
                                                Exercise
                                            </option>
                                        </select>
                                        @error('place')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label"> Type <span class="text-danger">*</span></label>
                                        <select class="form-control selectpicker" data-live-search="true"
                                                name="exercise_category" id="exercise_category">
                                            @foreach($exerciseTypes as $exerciseType)
                                                <option
                                                    value="{{ $exerciseType->id }}" {{ $exercise->exercise_category == $exerciseType->id ? 'selected' : '' }}>{{ $exerciseType->value }}</option>
                                            @endforeach
                                        </select>
                                        @error('exercise_category')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Body part</label>
                                        <select class="form-control selectpicker" data-live-search="true"
                                                name="body_part_id" id="body_part_id">
                                            @foreach($bodyParts as $bodyPart)
                                                <option value="{{ $bodyPart->id }}"
                                                        @if ($bodyPart->id == $exercise->muscle_id)
                                                        selected
                                                    @endif >{{ $bodyPart->title }}</option>
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
                                        <select class="form-control selectpicker" data-live-search="true"
                                                name="equipment_id">
                                            <option value="" {{ $exercise->equipment_id == null ? 'selected' : '' }}>
                                                choose Equipment
                                            </option>
                                            @foreach($equipments as $equipment)
                                                <option
                                                    value="{{ $equipment->id }}" {{ $equipment->id  === $exercise->equipment_id ? 'selected' : '' }}>{{ $equipment->title }}</option>
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
                                        <select class="form-control selectpicker" data-live-search="true"
                                                name="level_id">
                                            <option value="" {{ $exercise->level_id == null ? 'selected' : '' }}>choose
                                                Level
                                            </option>
                                            @foreach($levels as $level)
                                                <option
                                                    value="{{ $level->id }}" {{ $level->id  === $exercise->level_id ? 'selected' : '' }}>{{ $level->title }}</option>
                                            @endforeach
                                        </select>
                                        @error('level_id')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>


                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Instructions (English)<span
                                                class="text-danger">*</span></label>
                                        <textarea name="instruction_en" class="form-control"
                                                  id="editor-en"> {{ $exerciseEn->instructions }} </textarea>
                                        @error('instruction_en')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Instructions (Arabic)<span
                                                class="text-danger">*</span></label>
                                        <textarea name="instruction_ar" class="form-control"
                                                  id="editor-ar"> {{ $exerciseAr->instructions }} </textarea>
                                        @error('instruction_ar')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Tips (English)<span
                                                class="text-danger">*</span></label>
                                        <textarea name="tip_en" class="form-control"
                                                  id="editor-en-3">{{ $exerciseEn->tips }}</textarea>
                                        @error('tip_en')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Tips (Arabic)<span
                                                class="text-danger">*</span></label>
                                        <textarea name="tip_ar" class="form-control"
                                                  id="editor-ar-3">{{ $exerciseAr->tips }}</textarea>
                                        @error('tip_ar')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Video (MP4) </label>
                                        <input type="file" name="video" class="form-control" accept="video/mp4" style="border: 1px solid #ccc;
                                        border-radius: 7px;">
                                        @if(isset($exercise->video))
                                            <video width="320" height="240" controls>
                                                <source
                                                    src="{{ \Storage::url('files/exercise/videos/' . $exercise->id . '/' . $exercise->video) }}"
                                                    type="video/mp4">
                                            </video>
                                        @endif
                                        @error('video')
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
                                            @if(isset($exercise->image))
                                                <img id="profile-img-tag"
                                                     src="{{ \Storage::url('files/exercise/images/' . $exercise->id . '/thumb-' . $exercise->image) }}"
                                                     style="width: 120px; height: 110px; padding: 2px;">
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
                            <div class="d-grid gap-10 col-1 mx-auto">
                                <button type="submit" class="btn btn-success"
                                        style="padding: 5px 52px; border-radius: 15px;">Update
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
