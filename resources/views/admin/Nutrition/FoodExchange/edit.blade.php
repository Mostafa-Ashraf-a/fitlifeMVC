@extends('admin.master')
@section('dashboard')
    <div class="page-content-wrapper">
        <div class="content sm-gutter">
            <div class="container-fluid padding-25 sm-padding-10 py-1">
                <div class="card card-default mt-3">
                    <div class="card-header">
                        <h3 class="card-title">Edit Food Exchange</h3>
                    </div>
                    <form id="update-form" action="{{ url('manager/nutrition/food-exchanges/'.$foodExchange->id) }}"
                          method="post" enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Title (English)<span
                                                class="text-danger">*</span></label>
                                        <input type="text" maxlength="80" placeholder="Title"
                                               value="{{ $foodExchangeEn->title_en }}" name="title_en"
                                               class="form-control">
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
                                               value="{{ $foodExchangeAr->title_ar }}" name="title_ar"
                                               class="form-control">
                                        @error('title_ar')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label">Food Type <span
                                                class="text-danger">*</span></label>
                                        <select class="form-control selectpicker" data-live-search="true"
                                                name="food_type_id">
                                            @foreach($foodTypes as $foodType)
                                                <option
                                                    value="{{ $foodType->id }}" {{ $foodType->id === $foodExchange->food_type_id ? 'selected' : ''}}>{{ $foodType->title }}</option>
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
                                                @if($foodExchangeMeasurements->count() > 0)

                                                    @foreach($foodExchangeMeasurements as $foodExchangeMeasurement)
                                                        <tr>
                                                            <td>
                                                                <select name="measurement_unit_id[]"
                                                                        class="form-control selectpicker" data-live-search="true">
                                                                    @foreach($measurementUnits as $measurementUnit)
                                                                        <option
                                                                            value="{{ $measurementUnit->id }}" {{ $measurementUnit->id  === $foodExchangeMeasurement->measurement_unit_id ? 'selected' : '' }}>{{ $measurementUnit->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <input type="text" class="form-control"
                                                                       name="quantity[]" id="measurement_quantity"
                                                                       value="{{ $foodExchangeMeasurement->quantity }}">
                                                            </td>
                                                            <td>
                                                                <button type="button" class="btn btn-sm btn-danger"
                                                                        id="remove_measurement_{{ $foodExchangeMeasurement->measurement_unit_id }}"
                                                                        onclick="deleteMeasurementUnit({{ $foodExchangeMeasurement->measurement_unit_id }}, {{ $foodExchange->id }})">
                                                                    <i class="fa fa-trash"></i>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                                </tbody>

                                            </table>
                                        </div>
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
                                            @if(isset($foodExchange->image))
                                                <img id="profile-img-tag"
                                                     src="{{ \Storage::url('files/foodExchanges/images/' . $foodExchange->id . '/thumb-' . $foodExchange->image) }}"
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
                        </div>
                        <div class="d-grid gap-10 col-1 mx-auto">
                            <button type="submit" class="btn btn-success">Update</button>
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
                html += '<td><select name="measurement_unit_id[]" class="form-control selectpicker measurement_unit_id" data-live-search="true"><?php echo $output;?></select></td>';
                html += '<td><input class="form-control" type="text" name="quantity[]" id="measurement_quantity" ></td>';
                html += '<td><button type="button" name="remove" class="btn btn-sm btn-danger" id="remove_measurement"> <i class="fa fa-trash"></i></button></td>';
                html += '</tr>';
                $('tbody').append(html);
                $('.selectpicker').selectpicker('refresh');
            });
            $(document).on('click', '#remove_measurement', function () {
                $(this).closest('tr').remove();
            });

            $('#update-form').submit(function (event) {
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

        function deleteMeasurementUnit(measurementId, foodExchangeId) {
            Swal.fire({
                title: 'Are you sure want to delete this measurement unit ?',
                text: "You won't be able to revert this!",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
                    $.ajax({
                        type: "DELETE",
                        url: '{{ url("manager/nutrition/food-exchanges/measurement-unit") }}/' + measurementId + '/' + foodExchangeId,
                        dataType: "json",
                        success: function (response, textStatus, jqXHR) {
                            if (jqXHR.status === 200) {
                                Swal.fire(
                                    'Deleted!',
                                    `${jqXHR.responseJSON.message}`,
                                    'success'
                                ).then(() => {
                                    $('#remove_measurement_' + measurementId).closest('tr').remove();
                                })
                            }
                        },
                        error: function (jqXHR) {
                            if (jqXHR.status === 400) {
                                Swal.fire(
                                    'Warning!',
                                    `${jqXHR.responseJSON.message}`,
                                    'warning'
                                )
                            }
                        },
                    });
                }
            })
        }
    </script>
@endsection
