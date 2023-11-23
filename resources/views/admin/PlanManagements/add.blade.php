@extends('admin.master')
@section('dashboard')

    <div class="page-content-wrapper">
        <!--Main Content-->
        <div class="content sm-gutter">
            <div class="container-fluid padding-25 sm-padding-10 py-2">
            <div class="card card-default mt-3">
                    <div class="card-header">
                        <h3 class="card-title">Add New Plan</h3>
                    </div>
                    <form action="{{ url('manager/plan-managements') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                        <div class="row">
                                <div class="col-md-6">
                                <div class="form-group">
                                                    <label class="control-label">Plan Name (English) <span class="text-danger">*</span></label>
                                                    <input type="text" maxlength="80" placeholder="Plan Name En" name="plan_name_en" value="{{ old('plan_name_en') }}" class="form-control">
                                                    @error('plan_name_en')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                </div>
                                <div class="col-md-6">
                                <div class="form-group">
                                                    <label class="control-label">Plan Name (Arabic)<span class="text-danger">*</span></label>
                                                    <input type="text" maxlength="80" placeholder="Plan Name Ar" name="plan_name_ar" value="{{ old('plan_name_ar') }}" class="form-control">
                                                    @error('plan_name_ar')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                </div>
                                <div class="col-md-6">
                                <div class="form-group">
                                                    <label class="control-label mb-2"> Plan Duration <span class="text-danger">*</span></label>
                                                    <select class="form-control" name="plan_duration_id" id="duration_name" >
                                                        <option readonly>Choose Plan</option>
                                                        @foreach($planDurations as $planDuration)
                                                            <option value="{{ $planDuration->id }}">{{ $planDuration->duration_name }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('plan_duration_id')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                </div>
                                <div class="col-md-6">
                                        <div class="form-group">
                                                            <label class="control-label">Plan Price<span class="text-danger">*</span></label>
                                                            <input type="number" placeholder="Plan Price"  name="price" value="{{ old('price') }}" class="form-control price">
                                                            @error('price')
                                                            <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                        </div>
                                </div>
                                <div class="col-md-6 my-3">
                                    
                                    <label for="trial_period">Trial available (Days) :</label>
                                    <input type="checkbox" id="trial_period_select" class="form-check-input trail-check mx-4" value="0" onchange="showTrailDay()" name="trial_period_select">
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex">
                                        
                                        <input type="number" class="form-control" style="display: none;" value="{{ old('trial_period') }}" id="trial_period" name="trial_period" placeholder="Trial Period can be given between 1 to 30 days">
                                    </div>
                                </div>
                                                   
                                       

                                <div class="col-md-6">
                                <div class="form-group">
                                                    <label class="control-label mb-3">Description (English)<span class="text-danger">*</span></label>
                                                    <textarea name="description_en" class="form-control" id="editor-en">{{ old('description_en') }}</textarea>
                                                    @error('description_en')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                </div>
                                <div class="col-md-6">
                                <div class="form-group">
                                                    <label class="control-label mb-3">Description (Arabic)<span class="text-danger">*</span></label>
                                                    <textarea name="description_ar" class="form-control" id="editor-ar">{{ old('description_ar') }}</textarea>
                                                    @error('description_ar')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                </div>

                                <div class="col-md-6">
                                <div class="form-group">
                                                    <label class="control-label mb-3">Features (English)<span class="text-danger">*</span></label>
                                                    <textarea name="features_en" class="form-control" id="editor-en-3">{{ old('features_en') }}</textarea>
                                                    @error('features_en')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                </div>
                                <div class="col-md-6">
                                <div class="form-group">
                                                    <label class="control-label mb-3">Features (Arabic)<span class="text-danger">*</span></label>
                                                    <textarea name="features_ar" class="form-control" id="editor-ar-3">{{ old('features_ar') }}</textarea>
                                                    @error('features_ar')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                </div>

                        </div>
                        <!-- end-row -->
                        <!-- <div class="d-grid gap-10 col-1 mx-auto">
                                    <button type="submit" class="btn btn-success" style="padding: 5px 52px; border-radius: 15px;">Save</button>
                        </div> -->
                        <div class="d-grid gap-10 col-1 mx-auto">
                                <button type="submit" class="btn btn-success"  style="padding: 5px 52px; border-radius: 15px;" >Save</button>
                        </div>
                    </div>
                    </form>
                </div>
                <!-- <div class="row">
                    <div class="col-12">
                        <div class="section-title">
                            <h5>Add New Plan</h5>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="block table-block mb-4" style="margin-top: 20px;">
                            <div class="row">
                                <form action="{{ url('manager/plan-managements') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <div class="block col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label">Plan Name (English) <span class="text-danger">*</span></label>
                                                    <input type="text" maxlength="80" placeholder="Plan Name En" name="plan_name_en" value="{{ old('plan_name_en') }}" class="form-control">
                                                    @error('plan_name_en')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <br/>
                                                <div class="form-group">
                                                    <label class="control-label">Plan Name (Arabic)<span class="text-danger">*</span></label>
                                                    <input type="text" maxlength="80" placeholder="Plan Name Ar" name="plan_name_ar" value="{{ old('plan_name_ar') }}" class="form-control">
                                                    @error('plan_name_ar')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>

                                                <br/>
                                                <div class="form-group">
                                                    <label class="control-label mb-2"> Plan Duration <span class="text-danger">*</span></label>
                                                    <select class="form-control" name="plan_duration_id" id="duration_name" >
                                                        <option readonly>Choose Plan</option>
                                                        @foreach($planDurations as $planDuration)
                                                            <option value="{{ $planDuration->id }}">{{ $planDuration->duration_name }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('plan_duration_id')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <br/>
                                                <div class="row">
                                                    <div style="padding-top: 0px;" class="col-lg-8">
                                                        <label for="trial_period">Trial available (Days) :</label>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <input type="checkbox" id="trial_period_select" class="form-check-input trail-check" value="0" onchange="showTrailDay()" name="trial_period_select">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <input type="number" class="form-control" style="display: none;" value="{{ old('trial_period') }}" id="trial_period" name="trial_period" placeholder="Trial Period can be given between 1 to 30 days">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <br/>
                                                <div class="form-group">
                                                    <label class="control-label">Plan Price<span class="text-danger">*</span></label>
                                                    <input type="number" placeholder="Plan Price"  name="price" value="{{ old('price') }}" class="form-control price">
                                                    @error('price')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label mb-3">Description (English)<span class="text-danger">*</span></label>
                                                    <textarea name="description_en" class="form-control" id="editor-en">{{ old('description_en') }}</textarea>
                                                    @error('description_en')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>

                                                <div class="form-group">
                                                    <label class="control-label mb-3">Description (Arabic)<span class="text-danger">*</span></label>
                                                    <textarea name="description_ar" class="form-control" id="editor-ar">{{ old('description_ar') }}</textarea>
                                                    @error('description_ar')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <br/>
                                                <br/>
                                                <div class="form-group">
                                                    <label class="control-label mb-3">Features (English)<span class="text-danger">*</span></label>
                                                    <textarea name="features_en" class="form-control" id="editor-en-3">{{ old('features_en') }}</textarea>
                                                    @error('features_en')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>

                                                <div class="form-group">
                                                    <label class="control-label mb-3">Features (Arabic)<span class="text-danger">*</span></label>
                                                    <textarea name="features_ar" class="form-control" id="editor-ar-3">{{ old('features_ar') }}</textarea>
                                                    @error('features_ar')
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
@section('scripts')
    <script type="text/javascript">
        function showTrailDay()
        {
            if($('#trial_period_select').prop('checked')) {
                $('#trial_period').css('display','block');
            } else {
                $('#trial_period').css('display','none');
            }
        }
        $(document).ready(function (){
            $('#duration_name').on('change',function (){
                var duration = $('#duration_name').find(":selected").text();
                if(duration != "Free")
                {
                    $("input.trail-check").prop("disabled", false)
                    $("input.price").prop("readonly", false)
                }else {
                    $("input.trail-check").prop("disabled", true)
                    $("input.price").prop("readonly", true)
                }
            })
            $('#trial_period').on('change',function (){
                var trial_period = $(this).val()
                // console.log(trial_period);
                if(trial_period < 1 || trial_period > 30)
                {
                    alert('Trial Period can be given between 1 to 30 days')
                    $("input.submit_btn").prop("disabled", true)
                }else{
                    $("input.submit_btn").prop("disabled", false)
                }
            })
        });
    </script>
@endsection
