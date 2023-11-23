@extends('admin.master')
@section('dashboard')
    <div class="page-content-wrapper">
        <!--Main Content-->
        <div class="content sm-gutter">
            <div class="container-fluid padding-25 sm-padding-10">
                <div class="card card-default mt-3">
                    <div class="card-header">
                        <h3 class="card-title">Edit Workout</h3>
                    </div>
                    <form action="{{ url("manager/workouts/$workout->id") }}" method="POST"
                          enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="workout_id" value="{{ $workout->id }}">
                        <input type="hidden" name="old_image" value="{{ $workout->image }}">
                        <div class="card-body">
                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Title <span class="text-danger">*</span></label>
                                        <input type="text" maxlength="80" placeholder="Title"
                                               value="{{ $workout->title }}" name="title" class="form-control">
                                        @error('title')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Description</label>
                                        <textarea name="description" class="form-control"
                                                  id="editor-en">{{ $workout->description }}</textarea>
                                        @error('description')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Goal <span class="text-danger">*</span></label>
                                        <select class="form-control selectpicker" data-live-search="true" name="goal_id">
                                            @foreach($goals as $goal)
                                                <option
                                                    value="{{ $goal->id }}" {{ $goal->id  === $workout->goal_id ? 'selected' : '' }}>{{ $goal->title }}</option>
                                            @endforeach
                                        </select>
                                        @error('goal_id')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">

                                    <div class="form-group">
                                        <label class="control-label">Level <span class="text-danger">*</span> </label>
                                        <select class="form-control selectpicker" data-live-search="true" name="level_id">
                                            @foreach($levels as $level)
                                                <option
                                                    value="{{ $level->id }}" {{ $level->id  === $workout->level_id ? 'selected' : '' }}>{{ $level->title }}</option>
                                            @endforeach
                                        </select>
                                        @error('level_id')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label"> Place Type<span
                                                class="text-danger">*</span></label>
                                        <select class="form-control selectpicker" data-live-search="true" name="place_type">
                                            <option value="1" {{ $workout->place_type == "1" ? 'selected' : '' }}>Gym
                                                Exercise
                                            </option>
                                            <option value="2" {{ $workout->place_type == "2" ? 'selected' : '' }}>Home
                                                Exercise
                                            </option>
                                        </select>
                                        @error('place_type')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Type <span class="text-danger">*</span></label>
                                        <select class="form-control selectpicker" data-live-search="true" name="type_id">
                                            @foreach($types as $type)
                                                <option
                                                    value="{{ $type->id }}" {{ $type->id  === $workout->type_id ? 'selected' : '' }}>{{ $type->value }}</option>
                                            @endforeach
                                        </select>
                                        @error('type_id')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                @include('admin.Workouts._days-sections')

                            </div>
                        </div>
                        <div class="d-grid gap-10 col-1 mx-auto">
                            <button type="submit" class="btn btn-success" >Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @include('admin.Workouts._days-modal')
    </div>
@endsection

@section('scripts')
    @include('admin.Workouts._scripts')
@endsection
