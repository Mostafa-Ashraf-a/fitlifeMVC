@extends('admin.master')
@section('dashboard')
    <div class="page-content-wrapper">
        <div class="content sm-gutter">
            <div class="container-fluid padding-25 sm-padding-10 py-1">
                <div class="card card-default mt-3">
                    <div class="card-header">
                        <h3 class="card-title">Edit Recipe</h3>
                    </div>
                    <form action="{{ url('manager/nutrition/recipes/' .$recipe->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        <div class="card-body">
                            <div class="row">

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Title (English)<span class="text-danger">*</span></label>
                                        <input type="text" maxlength="80" placeholder="Title" value="{{ $recipeEn->title }}" name="title_en" class="form-control">
                                        @error('title_en')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Title (Arabic)<span class="text-danger">*</span></label>
                                        <input type="text" maxlength="80" placeholder="Title" value="{{ $recipeAr->title }}" name="title_ar" class="form-control">
                                        @error('title_ar')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>



                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label">Ingredients list (food exchanges) <span
                                                class="text-danger">*</span></label>
                                        <select class="form-control selectpicker" data-live-search="true" name="food_exchange_id[]" id="food_exchange_id" multiple>
                                            @foreach($foodExchanges as $foodExchange)
                                                <option
                                                    value="{{ $foodExchange->id }}"

                                                    @foreach($recipeFoodExchanges as $recipeFoodExchange)
                                                         {{ $foodExchange->id == $recipeFoodExchange->food_exchange_id ? 'selected' : '' }}
                                                    @endforeach>

                                                    {{ $foodExchange->title }}

                                                </option>
                                            @endforeach
                                        </select>
                                        @error('food_exchange_id')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>


                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Instructions (English)<span class="text-danger">*</span></label>
                                        <textarea name="instruction_en" class="form-control"  id="editor-en"> {{ $recipeEn->instructions }} </textarea>
                                        @error('instruction_en')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Instructions (Arabic)<span class="text-danger">*</span></label>
                                        <textarea name="instruction_ar" class="form-control"  id="editor-ar"> {{ $recipeAr->instructions }} </textarea>
                                        @error('instruction_ar')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>


                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Other Information (English)</label>
                                        <textarea name="other_info_en" class="form-control" id="editor-en-3">{{ $recipeEn->other_info }}</textarea>
                                        @error('other_info_en')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Other Information (Arabic)</label>
                                        <textarea name="other_info_ar" class="form-control" id="editor-ar-3">{{ $recipeAr->other_info }}</textarea>
                                        @error('other_info_ar')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>



                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Image <span
                                                class="text-danger">*</span></label>
                                        <div>
                                            <input type="file" name="image" id="profile-img" style="border: 1px solid #ccc;
                                        border-radius: 7px;">
                                            <br/>
                                            <br/>
                                            @if(isset($recipe->image))
                                                <img id="profile-img-tag" src="{{ \Storage::url('files/recipes/images/' . $recipe->id . '/thumb-' . $recipe->image) }}" style="width: 120px; height: 110px; padding: 2px;">
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
                                <button type="submit" class="btn btn-success" >Update</button>
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
