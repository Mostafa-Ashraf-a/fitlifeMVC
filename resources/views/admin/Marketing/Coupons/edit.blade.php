@extends('admin.master')
@section('dashboard')
    <style>
        .hide-percentage{
            display: none;
        }
    </style>
    <div class="page-content-wrapper">
        <div class="content sm-gutter">
            <div class="container-fluid padding-25 sm-padding-10 py-1">
                <div class="card card-default mt-3">
                    <div class="card-header">
                        <h3 class="card-title">Edit Coupon</h3>
                    </div>
                    <form action="{{ url('manager/marketing/coupons/'.$coupon->id) }}" method="POST">
                        @csrf
                        @method('put')
                        <div class="card-body">
                            <div class="row col-md-12">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Name <span
                                                class="text-danger">*</span></label>
                                        <input type="text" maxlength="80" placeholder="Name" value="{{ $coupon->name }}"
                                               name="name" class="form-control" required>
                                        @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Code <span
                                                class="text-danger">*</span></label>
                                        <input type="text" id="coupon-code"
                                               name="code" value="{{ $coupon->code }}" class="form-control" required>

                                        @error('code')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group mt-4">
                                        <button type="button" class="link mt-2" id="coupon-code-generate">
                                            <span> Generate Coupon</span>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="row col-md-12">
                                <div class="col-md-4">
                                    <label>Discount Type</label>
                                    <div>
                                        <label class="form-check-label mx-1">
                                            Fixed <input type="radio" id="fixed_discount_type" name="discount_type" value="1" @if ($coupon->discount_type == 1) checked @endif>
                                            <span></span>
                                        </label>
                                        <label class="form-check-label mx-2">
                                            Percentage <input type="radio" id="percentage_discount_type" name="discount_type" value="2" @if ($coupon->discount_type == 2) checked @endif>
                                            <span></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label>Discount Value</label>
                                    <div class="input-group mb-3">
                                        <input type="number" value="{{ $coupon->discount_value }}" name="discount_value" class="form-control">
                                        <div class="input-group-append">
                                                <span class="input-group-text hide-percentage" id="fixed_value">SAR</span>
                                                <span class="input-group-text hide-percentage" id="percentage_value">%</span>
                                        </div>
                                    </div>
                                </div>

                            </div>


                            <div class="row col-md-12">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Start Date <span
                                                class="text-danger">*</span></label>
                                        <input type="date" id="start_date" value="{{ $coupon->start_date }}"
                                               name="start_date" class="form-control" required>
                                        @error('start_date')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">End Date <span
                                                class="text-danger">*</span></label>
                                        <input type="date" id="end_date" value="{{ $coupon->end_date }}"
                                               name="end_date" class="form-control" required>
                                        @error('end_date')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row col-md-6">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Usage Limit <span
                                                class="text-danger">*</span></label>
                                        <input type="number" value="{{ $coupon->usage_limit }}"
                                               name="usage_limit" class="form-control" required>
                                        @error('usage_limit')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="d-grid gap-10 col-1 mx-auto">
                                <button type="submit" class="btn btn-success" >Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>

        $(document).ready(function () {
            $('#coupon-code-generate').on('click', function () {
                $('#coupon-code').val('');
                var couponCode = Array(6).fill().map(n=>(Math.random()*36|0).toString(36)).join('');
                $('#coupon-code').val(couponCode);
            });

            $('#fixed_discount_type').on('change', function () {
                $('#percentage_value').addClass('hide-percentage')
                $('#fixed_value').removeClass('hide-percentage')
            });

            $('#percentage_discount_type').on('change', function () {
                $('#fixed_value').addClass('hide-percentage')
                $('#percentage_value').removeClass('hide-percentage')
            });
        });
    </script>
@endsection

















{{--@extends('admin.master')--}}
{{--@section('dashboard')--}}
{{--    <div class="page-content-wrapper">--}}
{{--        <div class="content sm-gutter">--}}
{{--            <div class="container-fluid padding-25 sm-padding-10 py-1">--}}
{{--                <div class="card card-default mt-3">--}}
{{--                    <div class="card-header">--}}
{{--                        <h3 class="card-title">Edit Suggested Plan</h3>--}}
{{--                    </div>--}}

{{--                    <form action="{{ url('manager/marketing/coupons/'.$coupon->id) }}" method="POST">--}}
{{--                        @csrf--}}
{{--                        @method('put')--}}
{{--                        <div class="row col-md-12">--}}
{{--                            <div class="col-md-4">--}}
{{--                                <div class="form-group">--}}
{{--                                    <label class="control-label">Name <span--}}
{{--                                            class="text-danger">*</span></label>--}}
{{--                                    <input type="text" maxlength="80" value="{{ $coupon->name }}"--}}
{{--                                           name="name" class="form-control" required>--}}
{{--                                    @error('name')--}}
{{--                                    <span class="text-danger">{{ $message }}</span>--}}
{{--                                    @enderror--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="col-md-4">--}}
{{--                                <div class="form-group">--}}
{{--                                    <label class="control-label">Code <span--}}
{{--                                            class="text-danger">*</span></label>--}}
{{--                                    <input type="text" id="coupon-code"--}}
{{--                                           name="code" class="form-control" value="{{ $coupon->code }}" required>--}}

{{--                                    @error('code')--}}
{{--                                    <span class="text-danger">{{ $message }}</span>--}}
{{--                                    @enderror--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="col-md-2">--}}
{{--                                <div class="form-group mt-4">--}}
{{--                                    <button type="button" class="link mt-2" id="coupon-code-generate">--}}
{{--                                        <span> Generate Coupon</span>--}}
{{--                                    </button>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}

{{--                        <div class="row col-md-8">--}}
{{--                            <div>--}}
{{--                                <label>Discount Type</label>--}}
{{--                                <div>--}}
{{--                                    <label class="form-check-label">--}}
{{--                                        Fixed <input type="radio" name="discount_type" value="1" @if ($coupon->discount_type == 1) checked @endif>--}}
{{--                                        <span></span>--}}
{{--                                    </label>--}}
{{--                                    <label class="form-check-label">--}}
{{--                                        Percentage <input type="radio" name="discount_type" value="2" @if ($coupon->discount_type == 2) checked @endif>--}}
{{--                                        <span></span>--}}
{{--                                    </label>--}}
{{--                                </div>--}}
{{--                            </div>--}}

{{--                            <div class="col-md-4 ml-5">--}}
{{--                                <div class="form-group">--}}
{{--                                    <label class="control-label">Discount Value<span--}}
{{--                                            class="text-danger">*</span></label>--}}
{{--                                    <input type="number" min="1" value="{{ $coupon->discount_value }}"--}}
{{--                                           name="discount_value" class="form-control" required>--}}
{{--                                    @error('discount_value')--}}
{{--                                    <span class="text-danger">{{ $message }}</span>--}}
{{--                                    @enderror--}}
{{--                                </div>--}}
{{--                            </div>--}}

{{--                        </div>--}}


{{--                        <div class="row col-md-12">--}}
{{--                            <div class="col-md-6">--}}
{{--                                <div class="form-group">--}}
{{--                                    <label class="control-label">Start Date <span--}}
{{--                                            class="text-danger">*</span></label>--}}
{{--                                    <input type="date" value="{{ $coupon->start_date }}"--}}
{{--                                           name="start_date" class="form-control" required>--}}
{{--                                    @error('start_date')--}}
{{--                                    <span class="text-danger">{{ $message }}</span>--}}
{{--                                    @enderror--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="col-md-6">--}}
{{--                                <div class="form-group">--}}
{{--                                    <label class="control-label">End Date <span--}}
{{--                                            class="text-danger">*</span></label>--}}
{{--                                    <input type="date" value="{{ $coupon->end_date }}"--}}
{{--                                           name="end_date" class="form-control" required>--}}
{{--                                    @error('end_date')--}}
{{--                                    <span class="text-danger">{{ $message }}</span>--}}
{{--                                    @enderror--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}

{{--                        <div class="row col-md-6">--}}
{{--                            <div class="col-md-6">--}}
{{--                                <div class="form-group">--}}
{{--                                    <label class="control-label">Usage Limit <span--}}
{{--                                            class="text-danger">*</span></label>--}}
{{--                                    <input type="number" value="{{ $coupon->usage_limit }}"--}}
{{--                                           name="usage_limit" class="form-control" required>--}}
{{--                                    @error('usage_limit')--}}
{{--                                    <span class="text-danger">{{ $message }}</span>--}}
{{--                                    @enderror--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}

{{--                        <div class="d-grid gap-10 col-1 mx-auto">--}}
{{--                            <button type="submit" class="btn btn-success" >Update</button>--}}
{{--                        </div>--}}
{{--                    </form>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--@endsection--}}
{{--@section('scripts')--}}
{{--    <script>--}}
{{--        $(document).ready(function () {--}}
{{--            $('#coupon-code-generate').on('click', function () {--}}
{{--                $('#coupon-code').val('');--}}
{{--                var couponCode = Array(6).fill().map(n=>(Math.random()*36|0).toString(36)).join('');--}}
{{--                $('#coupon-code').val(couponCode);--}}
{{--            });--}}
{{--        });--}}
{{--    </script>--}}
{{--@endsection--}}
