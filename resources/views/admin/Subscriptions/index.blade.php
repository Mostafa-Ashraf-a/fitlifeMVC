@extends('admin.master')
@section('dashboard')

    <div class="page-content-wrapper">
        <!--Main Content-->
        <div class="content sm-gutter">
            <div class="container-fluid padding-25 sm-padding-10">
                <div class="row">
                    <div class="col-12">
                        <div class="section-title py-3">
                            <h5 style="margin-left:2% ;">Subscriptions List</h5>
                        </div>
                    </div>
                    <div class="col-12">
{{--                        <a class="btn btn-primary" href="{{ url('manager/users/create') }}" style="color: white; margin-left:89% ; background-color:#2a3f5a; border:0; border-radius: 12px;"><i--}}
{{--                                class="fa fa-plus"> Add New</i></a>--}}
                        <div class="block table-block mb-4" style="margin-top: 20px;">
                            <div class="row">
                                <div class="table-responsive px-3">
                                    <table id="table_id" class="table table-striped table-bordered" cellspacing="0"
                                           width="100%" style="border-radius: 5px;">
                                        <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Transaction Number</th>
                                            <th>Full Name</th>
                                            <th>Mobile</th>
                                            <th>Plan</th>
                                            <th>Subscribed At</th>
                                            <th>Expired At</th>
                                            <th>Free Trail Start At</th>
                                            <th>Free Trail End At</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($subscriptions as $subscription)
                                            <tr>
                                                <td>{{ $subscription->id }}</td>
                                                <td>{{ $subscription->transaction_number }}</td>
                                                <td>{{ $subscription->user->full_name }}</td>
                                                <td>{{ $subscription->user->mobile }}</td>
                                                <td>{{ $subscription->plan->planDuration->duration_name }}</td>
                                                @if($subscription->subscribed_at != null)
                                                    <td>{{ \Carbon\Carbon::createFromTimeStamp(strtotime($subscription->subscribed_at))->diffForHumans() }}</td>
                                                @else
                                                    <td>{{ $subscription->subscribed_at }}</td>
                                                @endif

                                                @if($subscription->expired_at != null)
                                                    <td>{{ \Carbon\Carbon::createFromTimeStamp(strtotime($subscription->expired_at))->diffForHumans() }}</td>
                                                @else
                                                    <td>{{ $subscription->expired_at }}</td>
                                                @endif

                                                @if($subscription->free_trail_start != null)
                                                    <td>{{ \Carbon\Carbon::createFromTimeStamp(strtotime($subscription->free_trail_start))->diffForHumans() }}</td>
                                                @else
                                                    <td>{{ $subscription->free_trail_start }}</td>
                                                @endif

                                                @if($subscription->free_trail_end != null)
                                                    <td>{{ \Carbon\Carbon::createFromTimeStamp(strtotime($subscription->free_trail_end))->diffForHumans() }}</td>
                                                @else
                                                    <td>{{ $subscription->free_trail_end }}</td>
                                                @endif
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
        function userStatus(id)
        {
            var id = id;
            $.ajax({
                url: "users/change-status",
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
