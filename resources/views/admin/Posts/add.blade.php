@extends('admin.master')
@section('dashboard')

    <div class="page-content-wrapper">
        <!--Main Content-->
        <div class="content sm-gutter">
            <div class="container-fluid padding-25 sm-padding-10 py-2">
            <div class="card card-default mt-3">
                    <div class="card-header">
                        <h3 class="card-title">Add New Post</h3>
                    </div>
                    <form action="{{ url('manager/posts/') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                        <div class="card-body">
                        <div class="row">
                                <div class="col-md-6">
                                <div class="form-group">
                                                    <label class="control-label mb-3">Title (English)<span class="text-danger">*</span></label>
                                                    <input type="text" maxlength="80" placeholder="Title" name="title_en" value="{{ old('title_en') }}" class="form-control">
                                                    @error('title_en')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                </div>
                                <div class="col-md-6">
                                <div class="form-group">
                                                    <label class="control-label mb-3">Title (Arabic)<span class="text-danger">*</span></label>
                                                    <input type="text" maxlength="80" placeholder="Title" name="title_ar" value="{{ old('title_ar') }}" class="form-control">
                                                    @error('title_ar')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                </div>
                                <div class="col-md-6">
                                <div class="form-group">
                                                    <label class="control-label mb-3">Description (English)<span class="text-danger">*</span></label>
                                                    <textarea name="description_en" class="form-control" id="editor-en">{{ old('description_en') }}</textarea>
                                                    @error('description_en')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                </div>
                                <div class="col-md-6">
                                <div class="form-group">
                                                    <label class="control-label mb-3">Description (Arabic)<span class="text-danger">*</span></label>
                                                    <textarea name="description_ar" class="form-control" id="editor-ar">{{ old('description_ar') }}</textarea>
                                                    @error('description_ar')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                </div>
                                <div class="col-md-12 w-50">
                                <div class="form-group ">
                                                    <label class="control-label mb-2"> Tag </label>
                                                    <select class="form-control" name="tag_id">
                                                        @foreach($tags as $tag)
                                                            <option value="{{ $tag->id }}">{{ $tag->title }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('tag_id')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                </div>
                                <div class="col-md-6">
                                <div class="form-group">
                                                    <label class="control-label mb-2"> Category Type <span class="text-danger">*</span></label>
                                                    <select class="form-control" name="category_type_id" id="category_type_id">
                                                        <option value="">Choose Category Type</option>
                                                        @foreach($categoryTypes as $categoryType)
                                                            <option value="{{ $categoryType->id }}" >{{ $categoryType->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('category_type_id')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                </div>
                                <div class="col-md-6">
                                            <div class="form-group d-none" id="category_div_id">
                                                    <label class="control-label mb-3"> Category <span class="text-danger">*</span></label>
                                                    <select class="form-control" name="category_id" id="category_id">
                                                        <option value="" disabled>Choose Category</option>
                                                    </select>
                                                    @error('category_id')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                            </div>
                                </div>

                                <div class="col-md-6">
                                <label class="control-label mb-2">Featured</label>
                                                <table>
                                                    <tr>
                                                        <td>
                                                            <div class="radio radio-success mx-2">
                                                                <input type="radio" name="featured" id="radio3" value="1">
                                                                <label for="radio3">
                                                                    Yes
                                                                </label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="radio radio-danger">
                                                                <input type="radio" name="featured" id="radio4" value="0">
                                                                <label for="radio4">
                                                                    No
                                                                </label>
                                                            </div>
                                                        </td>
                                                    </tr>

                                                </table>
                                </div>
                                <div class="col-md-6">
                                <label class="control-label mb-2">Status</label>
                                                <table>
                                                    <tr>
                                                        <td>
                                                            <div class="radio radio-success mx-2">
                                                                <input type="radio" name="status" id="radio5" value="1">
                                                                <label for="radio5">
                                                                    Publish
                                                                </label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="radio radio-danger">
                                                                <input type="radio" name="status" id="radio6" value="0">
                                                                <label for="radio6">
                                                                    Draft
                                                                </label>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </table>
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
                            <button type="submit" class="btn btn-success" style="padding: 5px 52px; border-radius: 15px;">Save</button>
                        </div>
                    </div>
                    </form>
                </div>
                <!-- <div class="row">
                    <div class="col-12">
                        <div class="section-title">
                            <h5>Add New Post</h5>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="block table-block mb-4" style="margin-top: 20px;">
                            <div class="row">
                                <form action="{{ url('manager/posts/') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <div class="block col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label mb-3">Title (English)<span class="text-danger">*</span></label>
                                                    <input type="text" maxlength="80" placeholder="Title" name="title_en" value="{{ old('title_en') }}" class="form-control">
                                                    @error('title_en')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>

                                                <div class="form-group">
                                                    <label class="control-label mb-3">Title (Arabic)<span class="text-danger">*</span></label>
                                                    <input type="text" maxlength="80" placeholder="Title" name="title_ar" value="{{ old('title_ar') }}" class="form-control">
                                                    @error('title_ar')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>

                                                <div class="form-group">
                                                    <label class="control-label mb-3">Description (English)<span class="text-danger">*</span></label>
                                                    <textarea name="description_en" class="form-control" id="editor-en">{{ old('description_en') }}</textarea>
                                                    @error('description_en')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <br/>
                                                <br/>
                                                <div class="form-group">
                                                    <label class="control-label mb-3">Description (Arabic)<span class="text-danger">*</span></label>
                                                    <textarea name="description_ar" class="form-control" id="editor-ar">{{ old('description_ar') }}</textarea>
                                                    @error('description_ar')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>

                                                <div class="form-group">
                                                    <label class="control-label mb-2"> Tag </label>
                                                    <select class="form-control" name="tag_id">
                                                        @foreach($tags as $tag)
                                                            <option value="{{ $tag->id }}">{{ $tag->title }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('tag_id')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label mb-2"> Category Type <span class="text-danger">*</span></label>
                                                    <select class="form-control" name="category_type_id" id="category_type_id">
                                                        <option value="">Choose Category Type</option>
                                                        @foreach($categoryTypes as $categoryType)
                                                            <option value="{{ $categoryType->id }}" >{{ $categoryType->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('category_type_id')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>

                                                <div class="form-group d-none" id="category_div_id">
                                                    <label class="control-label mb-3"> Category <span class="text-danger">*</span></label>
                                                    <select class="form-control" name="category_id" id="category_id">
                                                        <option value="" disabled>Choose Category</option>
                                                    </select>
                                                    @error('category_id')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>


                                                <style type="text/css">
                                                    td{padding: 0 .5rem !important;}
                                                </style>

                                                <label class="control-label mb-2">Featured</label>
                                                <table>
                                                    <tr>
                                                        <td>
                                                            <div class="radio radio-success">
                                                                <input type="radio" name="featured" id="radio3" value="1">
                                                                <label for="radio3">
                                                                    Yes
                                                                </label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="radio radio-danger">
                                                                <input type="radio" name="featured" id="radio4" value="0">
                                                                <label for="radio4">
                                                                    No
                                                                </label>
                                                            </div>
                                                        </td>
                                                    </tr>

                                                </table>

                                                <label class="control-label mb-2">Status</label>
                                                <table>
                                                    <tr>
                                                        <td>
                                                            <div class="radio radio-success">
                                                                <input type="radio" name="status" id="radio5" value="1">
                                                                <label for="radio5">
                                                                    Publish
                                                                </label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="radio radio-danger">
                                                                <input type="radio" name="status" id="radio6" value="0">
                                                                <label for="radio6">
                                                                    Draft
                                                                </label>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </table>

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
                                                <br/>
                                                <br/>
                                                <div class="d-grid gap-10 col-1 mx-auto">
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
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function (){
            $('#category_type_id').change(function (){
                var category_id = $('#category_id');
                console.log($(this).val())
                $.ajax({
                    url: 'get-categories',
                    data:{
                        id:$(this).val()
                    },
                    success:function (data){
                        // console.log(data)
                        category_id.html('<option value="" disabled>Choose Category</option>')
                        $.each(data,function (id,value){
                            category_id.append('<option value="'+ value.id +'">' + value.title + '</option>');
                        })
                    }
                });
                $('#category_div_id').removeClass('d-none');
            });

        });
    </script>
@endsection
