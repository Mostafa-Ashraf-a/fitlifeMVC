@extends('admin.master')
@section('dashboard')
    <div class="page-content-wrapper">
        <div class="content sm-gutter">
            <div class="container-fluid padding-25 sm-padding-10 py-1">
                <div class="card card-default mt-3">
                    <div class="card-header">
                        <h3 class="card-title">Add New Suggested Plan</h3>
                    </div>
                    <form action="{{ url('manager/nutrition/meal-plans/') }}" method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="row">

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Title <span
                                                class="text-danger">*</span></label>
                                        <input type="text" maxlength="80" placeholder="Title" value="{{ old('title') }}"
                                               name="title" class="form-control">
                                        @error('title')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label"> Goal Type <span
                                                class="text-danger">*</span></label>
                                        <select class="form-control selectpicker" data-live-search="true" name="goal_id">
                                            <option selected disabled>Choose Goal</option>
                                            @foreach($goals as $goal)
                                                <option value="{{ $goal->id }}">{{ $goal->title }}</option>
                                            @endforeach
                                        </select>
                                        @error('goal_id')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="card-body tasks_body">
                                            <table class="table table-bordered">
                                                <thead>
                                                <tr>
                                                    <th class="col-6">Meal Type</th>
                                                    <th class="col-12">Meals</th>
                                                    <th class="col-4">
                                                        <button type="button" class="btn btn-sm btn-primary"
                                                                id="add_plan"><i class="fa fa-plus"></i></button>
                                                    </th>
                                                </tr>
                                                </thead>
                                                <tbody id="tbody_task_group">
                                                <tr>
                                                    <td class="col-6">

                                                    </td>
                                                    <td class="col-12 meal_id">

                                                    </td>
                                                    <td class="col-4">
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end-row -->
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
@section('scripts')
   <script>
        $(document).ready(function () {
            $('.selectpicker').selectpicker('refresh');
            var count = 0;
            $(document).on('click', '#add_plan', function () {
                count++;
                var html = '';
                html = '<tr>';
                html += '<td class="col-6"><select name="meal_type_id[]" id="meal_type_id" class="form-control selectpicker meal_type_select" data-live-search="true" data-meal_type_id="'+count+'"><?php echo $mealTypesOutput?></select></td>';
                html += '<td class="col-8"><select name="meal_id[]" class="form-control selectpicker" data-live-search="true" id="meal_id'+count+'" data-meal_id="'+count+'"></select></td>';
                html += '<td class="col-4"><button type="button" class="btn btn-sm btn-danger" id="remove_plan"><i class="fa fa-trash"></i></button></td>';
                html += '</tr>';
                $('#tbody_task_group').append(html);

                $('.selectpicker').selectpicker('refresh');
                $(document).on('click', '#remove_plan', function () {
                    $(this).closest('tr').remove();
                })
            });
        });

         $(document).ready(function () {
             $(document).on('change', '#meal_type_id', function () {
                 event.preventDefault();
                 var meal_type_id = $(this).val();
                 var meal_id_count = $(this).data('meal_type_id');
                 $('#meal_id'+meal_id_count).empty();
                 $.ajax({
                     type: "GET",
                     url: '{{ url("manager/nutrition/meals") }}/' + meal_type_id + '/list',
                     dataType: "json",
                     success: function (response) {
                         $.each(response.data, function (key, value) {
                           console.log(response.data)
                             $('#meal_id'+meal_id_count).append('<option value="' + value
                                 .id + '">' + value.title + '</option>');
                             $('.selectpicker').selectpicker('refresh');
                         });
                     },
                     error: function (jqXHR, textStatus, errorThrown) {
                         console.log(textStatus + ": " + jqXHR.status + " " + errorThrown);
                     },
                 });
             })
        })
    </script>
@endsection
