@extends('admin.master')
@section('dashboard')
    <div class="page-content-wrapper">
        <!--Main Content-->
        <div class="content sm-gutter">
            <div class="container-fluid padding-25 sm-padding-10 py-2">
                <div class="card card-default mt-3">
                    <div class="card-header">
                        <h3 class="card-title">Edit Measurement Unit</h3>
                    </div>
                    <form action="{{ url('manager/nutrition/measurement-units/'.$id) }}" method="POST">
                        @csrf
                        @method('put')
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Name (EN)<span class="text-danger">*</span></label>
                                        <input type="text" maxlength="80" placeholder="Name" value="{{ $measurementUnitEn->name_en }}" name="name_en" class="form-control">
                                        @error('name_en')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Title (AR)<span class="text-danger">*</span></label>
                                        <input type="text" maxlength="80" placeholder="Name" value="{{ $measurementUnitAr->name_ar }}" name="name_ar" class="form-control">
                                        @error('name_ar')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="d-grid gap-10 col-1 mx-auto">
                                <button type="submit" class="btn btn-success" style="padding: 5px 52px; border-radius: 15px;" >Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

