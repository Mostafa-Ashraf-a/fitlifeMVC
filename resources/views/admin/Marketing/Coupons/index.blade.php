@extends('admin.master')
@section('dashboard')

    <div class="page-content-wrapper">
        <!--Main Content-->
        <div class="content sm-gutter">
            <div class="container-fluid padding-25 sm-padding-10">
                <div class="row">
                    <div class="col-12">
                        <div class="section-title py-3">
                            <h5 style="margin-left:2% ;">Coupons</h5>
                        </div>
                    </div>
                    <div class="col-12">
                        <a class="btn btn-primary" href="{{ url('manager/marketing/coupons/create') }}" style="color: white; background-color:#2a3f5a; border:0; border-radius: 12px; width: 130px;margin-left: 87%;"><i class="fa fa-plus">  Add Coupon</i></a>
                        <div class="block table-block mb-4" style="margin-top: 20px;">
                            <div class="row">
                                <div class="table-responsive px-3">
                                    <table id="table_id" class="table table-striped table-bordered" cellspacing="0" width="100%" style="border-radius: 5px;">
                                        <thead>
                                        <tr>
                                            <th>id</th>
                                            <th>Name</th>
                                            <th>Code</th>
                                            <th>Usage Limit</th>
                                            <th>Discount Value</th>
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                            <th>Activation Status</th>
                                            <th>Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        @foreach($coupons as $coupon)
                                            <tr>
                                                <td>{{ $coupon->id }}</td>
                                                <td>{{ $coupon->name }}</td>
                                                <td>{{ $coupon->code }}</td>
                                                <td>{{ $coupon->usage_limit }}</td>
                                                <td>{{ $coupon->discount_value }}</td>
                                                <td>{{ $coupon->start_date }}</td>
                                                <td>{{ $coupon->end_date }}</td>

                                                <td>
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input m-auto" onclick="changeStatus({{ $coupon->id }})" type="checkbox" role="switch" {{ $coupon->status == true ? 'checked' : '' }}>
                                                    </div>
                                                </td>
                                                <td>
                                                    <a class="btn btn-sm btn-info" href="{{ url('manager/marketing/coupons/'.$coupon->id.'/edit') }}"><i
                                                            class="fa fa-edit" title="Edit"></i></a>
                                                    <button class="btn btn-sm btn-danger" value="{{ $coupon->id }}" id="delete-model"><i class="fa fa-trash" title="Delete"></i></button>
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
    <script>
        function changeStatus(id)
        {
            var id = id;
            $.ajax({
                url: '{{ url("manager/marketing/coupons") }}/' + id + '/change-status',
                type: 'PUT',
                data: {
                    "_token": "{{ csrf_token() }}",
                },
                success:function (response, jqXHR, xhr)
                {
                    if(xhr.status === 200)
                    {
                        Swal.fire(
                            'changed!',
                            'The status has been changed',
                            'success'
                        )
                    }
                },
            });
        }
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
                                url: '{{ url("manager/marketing/coupons") }}/' + model_id,
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
