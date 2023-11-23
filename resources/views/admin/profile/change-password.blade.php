@extends('admin.master')
@section('dashboard')
    <div class="page-content-wrapper">
        <div class="content sm-gutter">
            <div class="container-fluid padding-25 sm-padding-10 py-1">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title my-1">Change Password</h3>
                                <img class="mx-3" src="https://img.icons8.com/color/30/null/keepass--v1.png"/>
                            </div>

                            <form action="{{ url('manager/profile/change-password') }}" method="POST">
                                @csrf
                                <div class="card-body">
                                    @if (session('status'))
                                        <div class="alert alert-success" role="alert">
                                            {{ session('status') }}
                                        </div>
                                    @elseif (session('error'))
                                        <div class="alert alert-danger" role="alert">
                                            {{ session('error') }}
                                        </div>
                                    @endif
                                    <div class="mb-3">
                                        <label for="oldPasswordInput" class="form-label">Old Password</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-key"></i></span>
                                            </div>
                                            <input name="old_password" type="password"
                                                   class="form-control @error('old_password') is-invalid @enderror"
                                                   id="oldPasswordInput"
                                                   placeholder="Old Password">
                                        </div>
                                        @error('old_password')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="newPasswordInput" class="form-label">New Password</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-key"></i></span>
                                            </div>
                                            <input name="new_password" type="password"
                                                   class="form-control @error('new_password') is-invalid @enderror"
                                                   id="newPasswordInput"
                                                   placeholder="New Password">
                                        </div>
                                        @error('new_password')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="confirmNewPasswordInput" class="form-label">Confirm New
                                            Password</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-key"></i></span>
                                            </div>
                                            <input name="new_password_confirmation" type="password"
                                                   class="form-control @error('new_password_confirmation') is-invalid @enderror"
                                                   id="confirmNewPasswordInput"
                                                   placeholder="Confirm New Password">
                                        </div>
                                        @error('new_password_confirmation')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                </div>

                                <div class="card-footer">
                                    <button class="btn btn-success">Update</button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
