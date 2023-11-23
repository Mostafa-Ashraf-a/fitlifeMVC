@extends('admin.master')
@section('dashboard')
    <div class="page-content-wrapper">
        <!--Main Content-->
        <div class="content sm-gutter">
            <div class="container-fluid padding-25 sm-padding-10">
                <div class="row">
                    <div class="col-12">
                        <div class="section-title py-3">
                            <h5 style="margin-left:2% ;">Food Exchanges List</h5>
                        </div>
                    </div>
                    <div class="col-12">
                        <a class="btn btn-primary" href="{{ url('manager/nutrition/food-exchanges/create') }}" style="color: white; margin-left:89% ; background-color:#2a3f5a; border:0; border-radius: 12px;"><i
                                class="fa fa-plus"> Add New</i></a>
                        <div class="block table-block mb-4" style="margin-top: 20px;">
                            <div class="row">

                                <div class="card w-100">
                                    <div class="card-body">
                                        <table id="table-id" class="table table-bordered table-striped">
                                            <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Image</th>
                                                <th>Title</th>
                                                <th>Food Type</th>
                                                <th>Measurement Unit</th>
                                                <th>َQuantity</th>
                                                <th>Actions</th>
                                            </tr>
                                            </thead>
                                            <tbody>
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
    <script>
        $(document).ready(function () {
            $('#table-id').DataTable({
                processing   : true,
                serverSide   : true,
                responsive   : true,
                sorting      : false,
                lengthChange : true,
                autoWidth    : false,
                pageLength   : 10,
                searching:   false,
                dom:'lBfrtip',
                "ajax" : '{{ url("manager/nutrition/food-exchanges/index") }}',
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
                        "data" : 'food_type'
                    },
                    {
                        "data" : 'm_unit'
                    },
                    {
                        "data" : 'quantity'
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
                                url: '{{ url("manager/nutrition/food-exchanges") }}/' + model_id,
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


















{{--@extends('admin.master')--}}
{{--@section('dashboard')--}}

{{--    <div class="page-content-wrapper">--}}
{{--        <div class="content sm-gutter">--}}
{{--            <div class="container-fluid padding-25 sm-padding-10">--}}
{{--                <div class="row">--}}
{{--                    <div class="col-12">--}}
{{--                        <div class="section-title py-3">--}}
{{--                            <h5 style="margin-left:2% ;">Food Exchanges List</h5>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="col-12">--}}
{{--                        <a class="btn btn-primary" href="{{ url('manager/nutrition/food-exchanges/create') }}" style="color: white; margin-left:89% ; background-color:#2a3f5a; border:0; border-radius: 12px;"><i--}}
{{--                                class="fa fa-plus"> Add New</i></a>--}}
{{--                        <div class="block table-block mb-4" style="margin-top: 20px;">--}}
{{--                            <div class="row">--}}

{{--                                <div class="card w-100">--}}

{{--                                    <div class="card-body">--}}
{{--                                        <table id="table_id" class="table table-bordered table-striped">--}}
{{--                                            <thead>--}}
{{--                                            <tr>--}}
{{--                                                <th>Id</th>--}}
{{--                                                <th>Image</th>--}}
{{--                                                <th>Title</th>--}}
{{--                                                <th>Food Type</th>--}}
{{--                                                <th>Measurement Unit</th>--}}
{{--                                                <th>َQuantity</th>--}}
{{--                                                <th>Actions</th>--}}
{{--                                            </tr>--}}
{{--                                            </thead>--}}
{{--                                            <tbody>--}}
{{--                                            @foreach($foodExchanges as $foodExchange)--}}
{{--                                                <tr>--}}
{{--                                                    <td>{{ $foodExchange->id }}</td>--}}
{{--                                                    <td width="30px" align="center">--}}
{{--                                                        @if(isset($foodExchange->image))--}}
{{--                                                            <img src="{{ \Storage::url('files/foodExchanges/images/' . $foodExchange->id . '/thumb-' . $foodExchange->image) }}" style="width: 40px; height: 40px; padding: 2px;">--}}
{{--                                                        @endif--}}
{{--                                                    </td>--}}
{{--                                                    <td>{{ $foodExchange->title }}</td>--}}
{{--                                                    <td>{{ $foodExchange->foodType->title }}</td>--}}
{{--                                                    <td>--}}
{{--                                                        @foreach($foodExchange->mUnits as $row)--}}
{{--                                                            <li>{{ $row->name }}</li>--}}
{{--                                                        @endforeach--}}
{{--                                                    </td>--}}
{{--                                                    <td>--}}
{{--                                                        @foreach($foodExchange->mUnits as $row)--}}
{{--                                                            <li>{{ $row->pivot->quantity }}</li>--}}
{{--                                                        @endforeach--}}
{{--                                                    </td>--}}

{{--                                                    <td>--}}
{{--                                                        <a class="btn btn-sm btn-info" href="{{ url('manager/nutrition/food-exchanges/'.$foodExchange->id) }}"><i class="fa fa-edit" title="Edit"></i></a>--}}
{{--                                                        <button class="btn btn-sm btn-danger" value="{{ $foodExchange->id }}" id="delete-model"><i class="fa fa-trash" title="Delete"></i></button>--}}
{{--                                                    </td>--}}
{{--                                                </tr>--}}
{{--                                            @endforeach--}}
{{--                                            </tbody>--}}

{{--                                        </table>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--@endsection--}}
{{--@section('scripts')--}}
{{--    <script type="text/javascript">--}}
{{--        $(document).ready(function () {--}}
{{--            $(document).on('click', '#delete-model', function () {--}}
{{--                Swal--}}
{{--                    .fire({--}}
{{--                        title: 'Are you sure want to delete this ?',--}}
{{--                        text: "You won't be able to revert this!",--}}
{{--                        icon: 'question',--}}
{{--                        showCancelButton: true,--}}
{{--                        confirmButtonColor: '#3085d6',--}}
{{--                        cancelButtonColor: '#d33',--}}
{{--                        confirmButtonText: 'Yes, delete it!'--}}
{{--                    })--}}
{{--                    .then((result) => {--}}
{{--                        if (result.isConfirmed) {--}}
{{--                            var model_id = $(this).val();--}}
{{--                            $.ajaxSetup({--}}
{{--                                headers: {--}}
{{--                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')--}}
{{--                                }--}}
{{--                            });--}}
{{--                            $.ajax({--}}
{{--                                type: "DELETE",--}}
{{--                                url: '{{ url("manager/nutrition/food-exchanges") }}/' + model_id,--}}
{{--                                dataType: "json",--}}
{{--                                success : function (response, textStatus, jqXHR) {--}}
{{--                                    if(jqXHR.status === 200){--}}
{{--                                        Swal.fire(--}}
{{--                                            'Deleted!',--}}
{{--                                            `${ jqXHR.responseJSON.message }`,--}}
{{--                                            'success'--}}
{{--                                        ).then(() => {--}}
{{--                                            location.reload();--}}
{{--                                        })--}}
{{--                                    }--}}
{{--                                },--}}
{{--                                error: function(jqXHR){--}}
{{--                                    if(jqXHR.status === 400){--}}
{{--                                        Swal.fire(--}}
{{--                                            'Warning!',--}}
{{--                                            `${ jqXHR.responseJSON.message }`,--}}
{{--                                            'warning'--}}
{{--                                        )--}}
{{--                                    }--}}
{{--                                },--}}
{{--                            });--}}
{{--                        }--}}
{{--                    })--}}
{{--            });--}}
{{--        });--}}
{{--    </script>--}}
{{--@endsection--}}
