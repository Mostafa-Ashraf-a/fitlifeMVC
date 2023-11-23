@extends('admin.master')
@section('dashboard')

        <div class="page-content-wrapper">
            <!--Main Content-->
            <div class="content sm-gutter">
                <div class="container-fluid padding-25 sm-padding-10">
                    <div class="row">
                        <div class="col-12">
                            <div class="section-title py-3">
                                <h5 style="margin-left:2% ;">Plan Durations</h5>
                            </div>
                        </div>
                        <div class="col-12">
{{--                            <a class="btn btn-primary" href="{{ url('manager/plan-durations/create') }}" style="color: white; margin-left:89% ; background-color:#2a3f5a; border:0; border-radius: 12px;"><i class="fa fa-plus">  Add New</i></a>--}}
                            <div class="block table-block mb-4" style="margin-top: 20px;">
                                <div class="row">
                                    <div class="table-responsive px-3">
                                        <table id="table_id" class="table table-striped table-bordered" cellspacing="0" width="100%" style="border-radius: 5px;">
                                            <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Duration Name</th>
                                                <th>status</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($planDurations as $planDuration)
                                                <tr>
                                                    <td>{{ $planDuration->id }}</td>
                                                    <td>{{ $planDuration->duration_name }}</td>
                                                    <td>
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input m-auto" id="status" onclick="planStatus({{ $planDuration->id }})" type="checkbox" role="switch" {{ $planDuration->status == 1 ? 'checked' : '' }}>
                                                        </div>
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
        function planStatus(id)
        {
            var id = id;
            $.ajax({
                url: "plan-durations/change-status",
                type: 'POST',
                data: {
                    id:id,
                    "_token": "{{ csrf_token() }}",
                },
                success:function (data)
                {
                    if(data.result == 1)
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
    </script>
@endsection

