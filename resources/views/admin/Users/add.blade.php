@extends('admin.master')
@section('dashboard')

    <div class="page-content-wrapper">
        <!--Main Content-->
        <div class="content sm-gutter">
            <div class="container-fluid padding-25 sm-padding-10 py-2">
            <div class="card card-default mt-3">
                    <div class="card-header">
                        <h3 class="card-title">Add New Customer</h3>
                    </div>
                    <form action="{{ url('manager/users') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                        <div class="card-body">
                        <div class="row">
                                <div class="col-md-6">
                                        <div class="form-group">
                                                    <label class="control-label">Full Name<span class="text-danger">*</span></label>
                                                    <input type="text" maxlength="80" placeholder="Full Name" value="{{ old('full_name') }}" name="full_name" class="form-control">
                                                    @error('full_name')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                        </div>
                                </div>
                                <div class="col-md-6">
                                <div class="form-group">
                                                    <label class="control-label">Mobile<span class="text-danger">*</span></label>
                                                    <input type="number" name="mobile" value="{{ old('mobile') }}" class="form-control">
                                                    @error('mobile')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                                    <label class="control-label">Email</label>
                                                    <input type="email" name="email" value="{{ old('email') }}" class="form-control">
                                                    @error('email')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                <div class="form-group">
                                                    <label class="control-label">Gender<span class="text-danger">*</span></label>
                                                    <select name="gender" class="form-control">
                                                        <option value="1">Male</option>
                                                        <option value="2">Female</option>
                                                    </select>
                                                    @error('gender')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                </div>
                                <div class="col-md-6">
                                <div class="form-group">
                                                    <label class="control-label">Password<span class="text-danger">*</span></label>
                                                    <input type="text" name="password" placeholder="Password" class="form-control">
                                                    @error('password')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                </div>                              

                        </div>
                        <!-- end-row -->
                        <div class="d-grid gap-10 col-1 mx-auto">
                            <button type="submit" class="btn btn-success" style="padding: 5px 52px; border-radius: 15px;">Save</button>
                        </div>
                    </div>
                    </form>
                </div>
                <!-- <div class="row">
                    <div class="col-12">
                        <div class="section-title">
                            <h5>Add New Customer</h5>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="block table-block mb-4" style="margin-top: 20px;">
                            <div class="row">
                                <form action="{{ url('manager/users') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <div class="block col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label">Full Name<span class="text-danger">*</span></label>
                                                    <input type="text" maxlength="80" placeholder="Full Name" value="{{ old('full_name') }}" name="full_name" class="form-control">
                                                    @error('full_name')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <br/>
                                                <div class="form-group">
                                                    <label class="control-label">Mobile<span class="text-danger">*</span></label>
                                                    <input type="number" name="mobile" value="{{ old('mobile') }}" class="form-control">
                                                    @error('mobile')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <br/>
                                                <div class="form-group">
                                                    <label class="control-label">Email</label>
                                                    <input type="email" name="email" value="{{ old('email') }}" class="form-control">
                                                    @error('email')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <br/>
                                                <div class="form-group">
                                                    <label class="control-label">Gender<span class="text-danger">*</span></label>
                                                    <select name="gender" class="form-control">
                                                        <option value="1">Male</option>
                                                        <option value="2">Female</option>
                                                    </select>
                                                    @error('gender')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <br/>
                                                <div class="form-group">
                                                    <label class="control-label">Password<span class="text-danger">*</span></label>
                                                    <input type="text" name="password" placeholder="Password" class="form-control">
                                                    @error('password')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <br/>
                                                <br/>
                                                <div class="d-grid gap-10 col-1 mx-auto">
                                                    <button type="submit" class="btn btn-success" >Save</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div> -->
            </div>
        </div>
    </div>
@endsection
