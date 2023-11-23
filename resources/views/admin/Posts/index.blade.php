@extends('admin.master')
@section('dashboard')

        <div class="page-content-wrapper">
            <!--Main Content-->
            <div class="content sm-gutter">
                <div class="container-fluid padding-25 sm-padding-10">
                    <div class="row">
                        <div class="col-12">
                            <div class="section-title py-3">
                                <h5 style="margin-left:2% ;">Post List</h5>
                            </div>
                        </div>
                        <div class="col-12">
                            <a class="btn btn-primary" href="{{ url('manager/posts/create') }}" style="color: white; margin-left:89% ; background-color:#2a3f5a; border:0; border-radius: 12px;"><i class="fa fa-plus">  Add New</i></a>
                            <div class="block table-block mb-4" style="margin-top: 20px;">
                                <div class="row">
                                    <div class="table-responsive px-2">
                                        <table id="table-id" class="table table-striped table-bordered" cellspacing="0" width="100%" style="border-radius: 5px;">
                                            <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Image</th>
                                                <th>Title</th>
                                                <th>Tag</th>
                                                <th>Category</th>
                                                <th>Featured</th>
                                                <th>Status</th>
                                                <th>Date</th>
                                                <th>Actions</th>
                                            </tr>
                                            </thead>
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
            $('#table-id').DataTable({
                processing   : true,
                serverSide   : true,
                responsive   : true,
                sorting      : false,
                lengthChange : true,
                autoWidth    : false,
                pageLength   : 5,
                searching:   false,
                dom:'lBfrtip',
                "ajax" : '{{ url("manager/posts/index") }}',
                "columns" : [
                    {
                        "data" : "id"
                    },
                    {
                        "data" : "image",
                    },
                    {
                        "data" : 'title'
                    },
                    {
                        "data" : 'tag'
                    },
                    {
                        "data" : 'category'
                    },
                    {
                        "data" : 'featured'
                    },
                    {
                        "data" : 'status'
                    },
                    {
                        "data" : 'date'
                    },
                    {
                        "data" : 'action'
                    }
                ],
                buttons: ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#table-id_wrapper .col-md-6:eq(0)');




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
                                url: '{{ url("manager/posts") }}/' + model_id,
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
