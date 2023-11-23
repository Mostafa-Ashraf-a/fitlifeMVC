@extends('admin.master')
@section('dashboard')

    <div class="page-content-wrapper">
        <div class="content sm-gutter">
            <div class="container-fluid padding-25 sm-padding-10">
                <div class="row">
                    <div class="col-12">
                        <div class="section-title py-3">
                            <h5 style="margin-left:2% ;">Meals List</h5>
                        </div>
                    </div>
                    <div class="col-12">
                        <a class="btn btn-primary" href="{{ url('manager/nutrition/meals/create') }}"  style="color: white; margin-left:89% ; background-color:#2a3f5a; border:0; border-radius: 12px;"><i
                                class="fa fa-plus"> Add New</i></a>
                        <div class="block table-block mb-4" style="margin-top: 20px;">
                            <div class="row">

                                <div class="card w-100">

                                    <div class="card-body">
                                        <table id="table_id" class="table table-bordered table-striped">
                                            <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Title</th>
                                                <th>Meal Type</th>
                                                <th>Added By</th>
                                                <th>Actions</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($meals as $meal)
                                                <tr>
                                                    <td>{{ $meal->id }}</td>
                                                    <td>{{ $meal->title }}</td>
                                                    <td>{{ $meal->mealType->title ?? null }}</td>
                                                    <td>{{ $meal->is_default == 1 ? 'Admin' : 'Customer' }}</td>
                                                    <td>
                                                        <a class="btn btn-sm btn-info" href="{{ url('manager/nutrition/meals/' .$meal->id . '/edit') }}"><i
                                                                class="fa fa-edit" title="Edit"></i></a>
                                                        <button class="btn btn-sm btn-danger" value="{{ $meal->id }}" id="delete-model"><i class="fa fa-trash" title="Delete"></i></button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>

                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            $(document).on('click', '#delete-model', function () {
                Swal
                    .fire({
                        title: 'Are you sure want to delete this ?',
                        text: "You won't be able to revert this!",
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!'
                    })
                    .then((result) => {
                        if (result.isConfirmed) {
                            var model_id = $(this).val();
                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });
                            $.ajax({
                                type: "DELETE",
                                url: '{{ url("manager/nutrition/meals") }}/' + model_id,
                                dataType: "json",
                                success : function (response, textStatus, jqXHR) {
                                    if(jqXHR.status === 200){
                                        Swal.fire(
                                            'Deleted!',
                                            `${ jqXHR.responseJSON.message }`,
                                            'success'
                                        ).then(() => {
                                            location.reload();
                                        })
                                    }
                                },
                                error: function(jqXHR){
                                    if(jqXHR.status === 400){
                                        Swal.fire(
                                            'Warning!',
                                            `${ jqXHR.responseJSON.message }`,
                                            'warning'
                                        )
                                    }
                                },
                            });
                        }
                    })
            });
        });
    </script>
@endsection
