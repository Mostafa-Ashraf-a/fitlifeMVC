@extends('admin.master')
@section('dashboard')

        <div class="page-content-wrapper">
            <!--Main Content-->
            <div class="content sm-gutter">
                <div class="container-fluid padding-25 sm-padding-10">
                    <div class="row">
                        <div class="col-12">
                            <div class="section-title py-3">
                                <h5 style="margin-left:2% ;">Plan Managements</h5>
                            </div>
                        </div>
                        <div class="col-12">
                            @if($planManagements->count() < 6)
                            <a class="btn btn-primary" href="{{ url('manager/plan-managements/create') }}" style="color: white; margin-left:89% ; background-color:#2a3f5a; border:0; border-radius: 12px;"><i class="fa fa-plus">  Add New</i></a>
                            @endif
                                <div class="block table-block mb-4" style="margin-top: 20px;">
                                <div class="row">
                                    <div class="table-responsive px-3">
                                        <table id="table_id" class="table table-striped table-bordered" cellspacing="0" width="100%" style="border-radius: 5px;">
                                            <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Plan Name</th>
                                                <th>Description</th>
                                                <th>Features</th>
                                                <th>Plan Duration</th>
                                                <th>Trail Period </th>
                                                <th>Currency</th>
                                                <th>Price</th>
                                                <th>status</th>
                                                <th>Actions</th>

                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($planManagements as $planManagement)
                                                <tr>
                                                    <td>{{ $planManagement->id }}</td>
                                                    <td>{{ $planManagement->plan_name }}</td>
                                                    <td>{!! $planManagement->description !!}</td>
                                                    <td>{!! $planManagement->features !!}</td>
                                                    <td>{{ $planManagement->planDuration->duration_name }}</td>
                                                    <td>{{ $planManagement->trail_period }}</td>
                                                    <td>{{ $planManagement->currency }}</td>
                                                    <td>{{ $planManagement->price }}</td>
                                                    <td>
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input m-auto" id="status" onclick="planStatus({{ $planManagement->id }})" type="checkbox" role="switch" {{ $planManagement->is_active == 1 ? 'checked' : '' }}>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <a class="btn btn-sm btn-info" href="{{ url('manager/plan-managements',$planManagement->id) }}"><i
                                                                class="fa fa-edit" title="Edit"></i></a>
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
                url: "plan-managements/change-status",
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


