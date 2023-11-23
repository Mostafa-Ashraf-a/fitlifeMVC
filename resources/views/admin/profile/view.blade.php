@extends('admin.master')
@section('dashboard')
    <div class="page-content-wrapper">
        <div class="content sm-gutter">
            <div class="container-fluid padding-25 sm-padding-10 py-1">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title my-1">Update Information</h3>
                            </div>

                            <form action="{{ url('manager/profile/view') }}" method="POST">
                                @csrf
                                @method('put')
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
                                        <label class="form-label">Full Name</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                                            </div>
                                            <input name="username" type="text"
                                                   class="form-control @error('username') is-invalid @enderror"
                                                   max="70" autocomplete="off" value="{{ \Auth::guard('manager')->user()->username }}"
                                                   placeholder="Full Name" required>
                                        </div>
                                        @error('username')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label  class="form-label">Email</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                            </div>
                                            <input name="email" type="email"
                                                   class="form-control @error('email') is-invalid @enderror"
                                                   autocomplete="off" max="70" value="{{ \Auth::guard('manager')->user()->email }}"
                                                   placeholder="Email" required>
                                        </div>
                                        @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Mobile (+966)</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                            </div>
                                            <input name="mobile" type="text"
                                                   class="form-control @error('mobile') is-invalid @enderror"
                                                   autocomplete="off" required placeholder="512345678" value="{{ \Auth::guard('manager')->user()->mobile }}">
                                        </div>
                                        @error('mobile')
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
