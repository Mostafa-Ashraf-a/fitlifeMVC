@extends('admin.master')
@section('dashboard')

        <div class="page-content-wrapper">
            <!--Main Content-->
            <div class="content sm-gutter">
                <div class="container-fluid padding-25 sm-padding-10">
                    <div class="row">
                        <div class="col-12">
                            <div class="section-title py-3">
                                <h5 style="margin-left:2% ;">Equipments List</h5>
                            </div>
                        </div>
                        <div class="col-12">
                            <a class="btn btn-primary" href="{{ url('manager/equipments/create') }}" style="color: white; margin-left:89% ; background-color:#2a3f5a; border:0; border-radius: 12px;"><i class="fa fa-plus">  Add New</i></a>
                            <div class="block table-block mb-4" style="margin-top: 20px;">
                                <div class="row">
                                    <div class="table-responsive px-3">
                                        <table id="table_id" class="table table-striped table-bordered" cellspacing="0" width="100%" style="border-radius: 5px;">
                                            <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Image</th>
                                                <th>Title</th>
                                                <th>Actions</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($equipments as $equipment)
                                                <tr>
                                                    <td>{{ $equipment->id }}</td>
                                                    <td width="30px" align="center">
                                                        @if(isset($equipment->image))
                                                            <img src="{{ \Storage::url('files/equipments/images/' . $equipment->id . '/thumb-' . $equipment->image) }}" style="width: 40px; height: 40px; padding: 2px;">
                                                        @endif
                                                    </td>
                                                    <td>{{ $equipment->title }}</td>
                                                    <td>
                                                        <a class="btn btn-sm btn-info" href="{{ url('manager/equipments/'.$equipment->id. '/edit') }}"><i class="fa fa-edit" title="Edit Equipment"></i></a>
                                                        <button class="btn btn-sm btn-danger" value="{{ $equipment->id }}" id="delete-equipment"><i class="fa fa-trash" title="Delete Equipment"></i></button>
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
@endsection
@section('scripts')
<script type="text/javascript">
    $(document).ready(function () {
            $(document).on('click', '#delete-equipment', function () {
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
                                url: '{{ url("manager/equipments") }}/' + model_id,
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
