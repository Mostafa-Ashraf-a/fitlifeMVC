@extends('admin.master')
@section('dashboard')
    <div class="page-content-wrapper">
        <div class="content sm-gutter">
            <div class="container-fluid padding-25 sm-padding-10 py-1">
                <div class="card card-default mt-3">
                    <div class="card-header">
                        <h3 class="card-title">Add New Meal</h3>
                    </div>
                    <form action="{{ url('manager/nutrition/meals') }}" method="POST" enctype="multipart/form-data">
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
                                        <input type="text" maxlength="80" placeholder="Title" value="{{ old('title_ar') }}"
                                               name="title_ar" class="form-control" required>
                                        @error('title_ar')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>


                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label">Meal Type <span
                                                class="text-danger">*</span>  </label>
                                        <select  class="form-control selectpicker" data-live-search="true" name="meal_type_id">
                                            <option disabled selected>Choose Meal Type</option>
                                            @foreach($mealTypes as $mealType)
                                                <option value="{{ $mealType->id }}">{{ $mealType->title }}</option>
                                            @endforeach
                                        </select>
                                        @error('meal_type_id')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label">Recipes <span
                                                class="text-danger">*</span></label>
                                        <select  class="form-control selectpicker" data-live-search="true" name="recipe_id[]" id="recipe_id" multiple>
                                            <option disabled selected>Choose recipe</option>
                                            @foreach($recipes as $recipe)
                                                <option value="{{ $recipe->id }}">{{ $recipe->title }}</option>
                                            @endforeach
                                        </select>
                                        @error('recipe_id')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>



                                <div class="d-grid gap-10 col-1 mx-auto">
                                    <button type="submit" class="btn btn-success">Save</button>
                                </div>
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
