@extends('admin.master')
@section('dashboard')
    <div class="page-content-wrapper">
        <!--Main Content-->
        <div class="content sm-gutter">
            <div class="container-fluid padding-25 sm-padding-10">
                <div class="row">
                    <div class="col-12">
                        <div class="section-title py-3">
                            <h5 style="margin-left:2% ;">Exercises List</h5>
                        </div>
                    </div>
                    <div class="col-12">

                        <a class="btn btn-primary" href="{{ url('manager/exercises/create') }}"
                            style="color: white; margin-left:89% ; background-color:#2a3f5a; border:0; border-radius: 12px;">
                            <i class="fa fa-plus"> Add New</i>
                        </a>

                        <div class="block table-block mb-4" style="margin-top: 20px;">
                            <div class="row">
                                <div class="card w-100">
                                    <div class="card-body">
                                        @livewire('exercise-table')
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
