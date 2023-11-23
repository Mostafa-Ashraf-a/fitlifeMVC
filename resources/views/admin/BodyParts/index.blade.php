@extends('admin.master')
@section('dashboard')

        <div class="page-content-wrapper">
            <!--Main Content-->
            <div class="content sm-gutter">
                <div class="container-fluid padding-25 sm-padding-10">
                    <div class="row">
                        <div class="col-12">
                            <div class="section-title my-3">
                                <h5 style="margin-left:2% ;">Body Parts List</h5>
                            </div>
                        </div>
                        <div class="col-12">
{{--                            <a class="btn btn-primary" href="{{ url('manager/body-parts/create') }}"style="color: white; margin-left:89% ; background-color:#2a3f5a; border:0; border-radius: 12px;"><i class="fa fa-plus">  Add New</i></a>--}}
                            <div class="block table-block mb-4" style="margin-top: 20px;">
                                <div class="row">
                                    <div class="table-responsive px-2">
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
                                            @foreach($bodyParts as $bodyPart)
                                                <tr>
                                                    <td>{{ $bodyPart->id }}</td>
                                                    <td width="30px" align="center">
                                                        @if(isset($bodyPart->image))
                                                            <img src="{{ \Storage::url('files/bodyParts/images/' . $bodyPart->id . '/thumb-' . $bodyPart->image) }}" style="width: 40px; height: 40px; padding: 2px;">
                                                        @endif
                                                    </td>
                                                    <td>{{ $bodyPart->title }}</td>
                                                    <td>
                                                        <a class="btn btn-sm btn-info" href="{{ url('manager/body-parts/'.$bodyPart->id. '/edit') }}"><i class="fa fa-edit" title="Edit"></i></a>
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
