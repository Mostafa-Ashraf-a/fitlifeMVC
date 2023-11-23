@extends('admin.master')
@section('dashboard')

    <div class="page-content-wrapper">
        <!--Main Content-->
        <div class="content sm-gutter">
            <div class="container-fluid padding-25 sm-padding-10">
                <div class="row">
                    <div class="col-12">
                        <div class="section-title py-3">
                            <h5 style="margin-left:2% ;">Users List</h5>
                        </div>
                    </div>
                    <div class="col-12">
                        <a class="btn btn-primary" href="{{ url('manager/users/create') }}" style="color: white; margin-left:89% ; background-color:#2a3f5a; border:0; border-radius: 12px;"><i
                                class="fa fa-plus"> Add New</i></a>
                        <div class="block table-block mb-4" style="margin-top: 20px;">
                            <div class="row">
                                <div class="table-responsive px-3">
                                    <table id="table_id" class="table table-striped table-bordered" cellspacing="0"
                                           width="100%" style="border-radius: 5px;">
                                        <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Image</th>
                                            <th>Full Name</th>
                                            <th>Gender</th>
                                            <th>Mobile</th>
                                            <th>Status</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($users as $user)
                                            <tr>
                                                <td>{{ $user->id }}</td>
                                                <td width="30px" align="center">
                                                    @if(isset($user->image))
                                                        <img src="{{ \Storage::url('files/users/images/' . $user->id . '/thumb-' . $user->image) }}" style="width: 40px; height: 40px; padding: 2px;">
                                                    @endif
                                                </td>
                                                <td>{{ $user->full_name }}</td>
                                                <td>
                                                    @if($user->gender == 1)
                                                        <button style="color: black;" class="btn btn-secondary">Male
                                                        </button>
                                                    @else
                                                        <button style="color: black;" class="btn btn-secondary">Female
                                                        </button>
                                                    @endif
                                                </td>
                                                <td>{{ $user->mobile }}</td>
                                                <td>
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input m-auto" id="user-status" onclick="userStatus({{ $user->id }})" type="checkbox" role="switch" {{ $user->status == true ? 'checked' : '' }}>
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
