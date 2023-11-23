@extends('admin.master')
@section('dashboard')

    <div class="page-content-wrapper">
        <div class="content sm-gutter">
            <div class="container-fluid padding-25 sm-padding-10">
                <div class="row">
                    <div class="col-12">
                        <div class="section-title py-3">
                            <h5 style="margin-left:2% ;">Goals List</h5>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="block table-block mb-4" style="margin-top: 20px;">
                            <div class="row">
                                <div class="card w-100">
                                    <div class="card-body">
                                        <table id="table_id" class="table table-bordered table-striped">
                                            <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Title</th>
                                                <th>Actions</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($goals as $goal)
                                                <tr>
                                                    <td>{{ $goal->id }}</td>
                                                    <td>{{ $goal->title }}</td>
                                                    <td>
                                                        <a class="btn btn-sm btn-info" href="{{ url('manager/exercise/goals/' .$goal->id . '/edit') }}"><i
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
    </div>
@endsection

