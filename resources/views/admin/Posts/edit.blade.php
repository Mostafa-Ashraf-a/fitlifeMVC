@extends('admin.master')
@section('dashboard')
    <div class="page-content-wrapper">
        <!--Main Content-->
        <div class="content sm-gutter">
            <div class="container-fluid padding-25 sm-padding-10">
            <div class="card card-default mt-3">
                    <div class="card-header">
                        <h3 class="card-title">Edit Post</h3>
                    </div>
                    <form action="{{ url('manager/posts/'.$post->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('put')
                        <div class="card-body">
                        <div class="row">

                                <div class="col-md-6">
                                <div class="form-group">
                                                    <label class="control-label mb-1">Title (English) <span class="text-danger">*</span></label>
                                                    <input type="text" maxlength="80" placeholder="Title" value="{{ $postEn->title_en }}" name="title_en" class="form-control">
                                                    @error('title_en')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                </div>
                                <div class="col-md-6">
                                <div class="form-group mb-2">
                                                    <label class="control-label mb-1">Title (Arabic) <span class="text-danger">*</span></label>
                                                    <input type="text" maxlength="80" placeholder="Title" value="{{ $postAr->title_ar }}" name="title_ar" class="form-control">
                                                    @error('title_ar')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                </div>
                                <div class="col-md-6  mt-2">
                                <div class="form-group">
                                                    <label class="control-label mb-1">Description (English) <span class="text-danger"> *</span></label>
                                                    <textarea name="description_en" class="form-control" id="editor-en">{{ $postEn->description_en }}</textarea>
                                                    @error('description_en')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                </div>
                                <div class="col-md-6  mt-2">
                                <div class="form-group">
                                                    <label class="control-label mb-1">Description (Arabic) <span class="text-danger"> *</span></label>
                                                    <textarea name="description_ar" class="form-control" id="editor-ar">{{ $postAr->description_ar }}</textarea>
                                                    @error('description_ar')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                </div>
                                <div class="col-md-6">
                                <div class="form-group">
                                                    <label class="control-label">Tag </label>
                                                    <select class="form-control" name="tag_id">
                                                        @foreach($tags as $tag)
                                                            <option value="{{ $tag->id }}" {{ $tag->id  === $post->tag_id ? 'selected' : '' }}>{{ $tag->title }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('tag_id')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                </div>
                                <div class="col-md-6">
                                <div class="form-group">
                                                    <label class="control-label"> Category Type <span class="text-danger">*</span></label>
                                                    <select class="form-control" name="category_type_id" id="category_type_id">
                                                        <option value="">Choose Category Type</option>
                                                        @foreach($categoryTypes as $categoryType)
                                                            <option value="{{ $categoryType->id }}" {{ $post->category_type_id  == $categoryType->id ? 'selected' : '' }}>{{ $categoryType->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('category_type_id')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                </div>
                                <div class="col-md-6">
                                <div class="form-group" id="category_div_id">
                                                    <label class="control-label"> Category <span class="text-danger">*</span></label>
                                                    <select class="form-control" name="category_id" id="category_id">
                                                        @foreach($categories as $category)
                                                            <option value="{{ $category->id }}" {{ $post->category_id == $category->id ? 'selected' : '' }}>{{ $category->title }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('category_id')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                </div>


                                <div class="col-md-6">
                                <label class="control-label">Featured</label>
                                                <table>
                                                    <tr>
                                                        <td>
                                                            <div class="radio radio-success">
                                                                <input type="radio" name="featured" id="radio3" value="1" {{ $post->featured == 1 ? 'checked' : '' }}>
                                                                <label for="radio3">
                                                                    Yes
                                                                </label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="radio radio-danger">
                                                                <input type="radio" name="featured" id="radio4" value="0" {{ $post->featured == 0 ? 'checked' : '' }}>
                                                                <label for="radio4">
                                                                    No
                                                                </label>
                                                            </div>
                                                        </td>
                                                    </tr>

                                                </table>
                                </div>
                                <div class="col-md-6">
                                <label class="control-label">Status</label>
                                                <table>
                                                    <tr>
                                                        <td>
                                                            <div class="radio radio-success">
                                                                <input type="radio" name="status" id="radio5" value="1" {{ $post->status == 1 ? 'checked' : '' }}>
                                                                <label for="radio5">
                                                                    Publish
                                                                </label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="radio radio-danger">
                                                                <input type="radio" name="status" id="radio6" value="0" {{ $post->status == 0 ? 'checked' : '' }}>
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
                                                        <input type="file" name="image" id="profile-img">
                                                        <br/>
                                                        <br/>
                                                        @if(isset($post->image))
                                                            <img id="profile-img-tag" src="{{ \Storage::url('files/posts/images/' . $post->id . '/thumb-' . $post->image) }}" style="width: 120px; height: 110px; padding: 2px;">
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
                        <!-- end-row -->
                        <div class="d-grid gap-10 col-1 mx-auto">
                                <button type="submit" class="btn btn-success" style="padding: 5px 52px; border-radius: 15px;">Update</button>
                        </div>
                    </div>
                    </form>
                </div>
                <!-- <div class="row">
                    <div class="col-12">
                        <div class="section-title">
                            <h5>Edit Post</h5>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="block table-block mb-4" style="margin-top: 20px;">
                            <div class="row">
                                <form action="{{ url('manager/posts/'.$post->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('put')
                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <div class="block col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label mb-1">Title (English) <span class="text-danger">*</span></label>
                                                    <input type="text" maxlength="80" placeholder="Title" value="{{ $postEn->title_en }}" name="title_en" class="form-control">
                                                    @error('title_en')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>

                                                <div class="form-group mb-2">
                                                    <label class="control-label mb-1">Title (Arabic) <span class="text-danger">*</span></label>
                                                    <input type="text" maxlength="80" placeholder="Title" value="{{ $postAr->title_ar }}" name="title_ar" class="form-control">
                                                    @error('title_ar')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>


                                                <div class="form-group mt-2">
                                                    <label class="control-label mb-1">Description (English) <span class="text-danger"> *</span></label>
                                                    <textarea name="description_en" class="form-control" id="editor-en">{{ $postEn->description_en }}</textarea>
                                                    @error('description_en')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>

                                                <div class="form-group mt-2">
                                                    <label class="control-label mb-1">Description (Arabic) <span class="text-danger"> *</span></label>
                                                    <textarea name="description_ar" class="form-control" id="editor-ar">{{ $postAr->description_ar }}</textarea>
                                                    @error('description_ar')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>


                                                <div class="form-group">
                                                    <label class="control-label">Tag </label>
                                                    <select class="form-control" name="tag_id">
                                                        @foreach($tags as $tag)
                                                            <option value="{{ $tag->id }}" {{ $tag->id  === $post->tag_id ? 'selected' : '' }}>{{ $tag->title }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('tag_id')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>

                                                <div class="form-group">
                                                    <label class="control-label"> Category Type <span class="text-danger">*</span></label>
                                                    <select class="form-control" name="category_type_id" id="category_type_id">
                                                        <option value="">Choose Category Type</option>
                                                        @foreach($categoryTypes as $categoryType)
                                                            <option value="{{ $categoryType->id }}" {{ $post->category_type_id  == $categoryType->id ? 'selected' : '' }}>{{ $categoryType->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('category_type_id')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>

                                                <div class="form-group" id="category_div_id">
                                                    <label class="control-label"> Category <span class="text-danger">*</span></label>
                                                    <select class="form-control" name="category_id" id="category_id">
                                                        @foreach($categories as $category)
                                                            <option value="{{ $category->id }}" {{ $post->category_id == $category->id ? 'selected' : '' }}>{{ $category->title }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('category_id')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>


                                                <style type="text/css">
                                                    td{padding: 0 .5rem !important;}
                                                </style>

                                                <label class="control-label">Featured</label>
                                                <table>
                                                    <tr>
                                                        <td>
                                                            <div class="radio radio-success">
                                                                <input type="radio" name="featured" id="radio3" value="1" {{ $post->featured == 1 ? 'checked' : '' }}>
                                                                <label for="radio3">
                                                                    Yes
                                                                </label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="radio radio-danger">
                                                                <input type="radio" name="featured" id="radio4" value="0" {{ $post->featured == 0 ? 'checked' : '' }}>
                                                                <label for="radio4">
                                                                    No
                                                                </label>
                                                            </div>
                                                        </td>
                                                    </tr>

                                                </table>

                                                <label class="control-label">Status</label>
                                                <table>
                                                    <tr>
                                                        <td>
                                                            <div class="radio radio-success">
                                                                <input type="radio" name="status" id="radio5" value="1" {{ $post->status == 1 ? 'checked' : '' }}>
                                                                <label for="radio5">
                                                                    Publish
                                                                </label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="radio radio-danger">
                                                                <input type="radio" name="status" id="radio6" value="0" {{ $post->status == 0 ? 'checked' : '' }}>
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
                                                        <input type="file" name="image" id="profile-img">
                                                        <br/>
                                                        <br/>
                                                        @if(isset($post->image))
                                                            <img id="profile-img-tag" src="{{ \Storage::url('files/posts/images/' . $post->id . '/thumb-' . $post->image) }}" style="width: 120px; height: 110px; padding: 2px;">
                                                        @else
                                                            <img id="profile-img-tag" width="100px" height="100px"/>
                                                        @endif
                                                    </div>
                                                    <br/>
                                                    @error('image')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <div class="d-grid gap-10 col-1 mx-auto">
                                                    <button type="submit" class="btn btn-success" >Update</button>
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
                $.ajax({
                    url: '{{ url("manager/posts/get-categories") }}',
                    data:{
                        id:$(this).val()
                    },
                    success:function (data){
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
