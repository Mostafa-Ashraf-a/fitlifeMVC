@extends('admin.master')
@section('dashboard')
    <div class="page-content-wrapper">
        <div class="content sm-gutter">
            <div class="container-fluid padding-25 sm-padding-10 py-1">
                <div class="card card-default mt-3">
                    <div class="card-header">
                        <h3 class="card-title">Add New Food Exchange</h3>
                    </div>
                    <form action="{{ url('manager/nutrition/food-exchanges/') }}" id="save-form" method="POST"
                          enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="row">

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Title (English) <span
                                                class="text-danger">*</span></label>
                                        <input type="text" maxlength="80" placeholder="Title"
                                               value="{{ old('title_en') }}"
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
                                        <input type="text" maxlength="80" placeholder="Title"
                                               value="{{ old('title_ar') }}"
                                               name="title_ar" class="form-control" required>
                                        @error('title_ar')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label">Food Type<span
                                                class="text-danger">*</span> </label>
                                        <select class="form-control selectpicker" data-live-search="true"
                                                name="food_type_id">
                                            <option disabled selected>Choose Food Type</option>
                                            @foreach($foodTypes as $foodType)
                                                <option value="{{ $foodType->id }}">{{ $foodType->title }}</option>
                                            @endforeach
                                        </select>
                                        @error('food_type_id')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="card-body tasks_body">
                                            <table class="table table-bordered" id="measurement_unit_quantity">
                                                <thead>
                                                <tr>
                                                    <th><h4> Measurement Unit</h4></th>
                                                    <th><h4>Enter Quantity</h4></th>
                                                    <th>
                                                        <button type="button" name="add"
                                                                class="btn btn-sm btn-primary add">
                                                            <i class="fa fa-plus"></i>
                                                        </button>
                                                    </th>
                                                </tr>
                                                </thead>
                                                <tbody>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Image</label>
                                        <div>
                                            <input type="file" name="image" onchange="loadFile(event)"
                                                   class="d-block mb-3" style="border: 1px solid #ccc;
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
                        </div>
                        <div class="d-grid gap-10 col-1 mx-auto">
                            <button type="submit" class="btn btn-success">Save</button>
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
            $(document).on('click', '.add', function () {
                var html = '';
                html += '<tr>';
                html += '<td><select name="measurement_unit_id[]" class="form-control selectpicker" data-live-search="true" measurement_unit_id"><?php echo $output;?></select></td>';
                html += '<td><input class="form-control" type="number" step="any" name="quantity[]" id="measurement_quantity" required></td>';
                html += '<td><button type="button" name="remove" class="btn btn-sm btn-danger remove"><i class="fa fa-trash"></i></button></td>';
                html += '</tr>';
                $('tbody').append(html);
                $('.selectpicker').selectpicker('refresh');
            });
            $(document).on('click', '.remove', function () {
                $(this).closest('tr').remove();
            });
            $('#save-form').submit(function (event) {

                $.fn.rowCount = function () {
                    return $('tr', $(this).find('tbody')).length;
                };
                var rowQuantityCount = $('#measurement_unit_quantity').rowCount();
                if (rowQuantityCount > 2) {
                    event.preventDefault()
                    Swal.fire(
                        'Warning!',
                        'Number Of Measurement Units should not be greater than two',
                        'warning'
                    )
                }
            });
        });
    </script>
@endsection
