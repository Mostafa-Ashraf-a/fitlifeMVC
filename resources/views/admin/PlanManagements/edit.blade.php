@extends('admin.master')
@section('dashboard')
    <div class="page-content-wrapper">
        <!--Main Content-->
        <div class="content sm-gutter">
            <div class="container-fluid padding-25 sm-padding-10">
            <div class="card card-default mt-3">
                    <div class="card-header">
                        <h3 class="card-title">Edit Plan</h3>
                    </div>
                    <form action="{{ url('manager/plan-managements/' . $plan->id) }}" method="post">
                                    @csrf
                                    @method('put')
                        <div class="card-body">
                        <div class="row">

                                <div class="col-md-6">
                                <div class="form-group">
                                                    <label class="control-label">Plan Name (English)<span class="text-danger">*</span></label>
                                                    <input type="text" maxlength="80" placeholder="Title" value="{{ $planEn->plan_name }}" name="plan_name_en" class="form-control">
                                                    @error('plan_name_en')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                </div>
                                <div class="col-md-6">
                                <div class="form-group">
                                                    <label class="control-label">Plan Name (Arabic)<span class="text-danger">*</span></label>
                                                    <input type="text" maxlength="80" placeholder="Title" value="{{ $planAr->plan_name }}" name="plan_name_ar" class="form-control">
                                                    @error('plan_name_ar')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                </div>
                                <div class="col-md-6">
                                <div class="form-group">
                                                    <label class="control-label mb-2"> Plan Duration <span class="text-danger">*</span></label>
                                                    <select class="form-control" name="plan_duration_id" id="duration_name" disabled>
                                                        <option readonly>Choose Plan</option>
                                                        @foreach($planDurations as $planDuration)
                                                            <option value="{{ $planDuration->id }}" {{ $plan->plan_duration_id == $planDuration->id ? 'selected' : '' }}>{{ $planDuration->duration_name }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('plan_duration_id')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                </div>
                                @if($plan->plan_duration_id != 1)
                                <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Trial available (Days) </label>
                                                    <input type="text" maxlength="80" value="{{ $plan->trail_period }}" name="trail_period" class="form-control">
                                                    @error('trail_period')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                </div>
                                <div class="col-md-6">
                                <div class="form-group">
                                                    <label class="control-label">Plan Price </label>
                                                    <input type="text" maxlength="80" value="{{ $plan->price }}" name="price" class="form-control">
                                                    @error('price')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>                                            
                                </div>
                                @endif
                                <div class="col-md-6">
                                <div class="form-group">
                                                    <label class="control-label mb-3">Description (English)<span class="text-danger">*</span></label>
                                                    <textarea name="description_en" class="form-control" id="editor-en">{{ $planEn->description }}</textarea>
                                                    @error('description_en')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                </div>
                                <div class="col-md-6">
                                <div class="form-group">
                                                    <label class="control-label mb-3">Description (Arabic)<span class="text-danger">*</span></label>
                                                    <textarea name="description_ar" class="form-control" id="editor-ar">{{ $planAr->description }}</textarea>
                                                    @error('description_ar')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                </div>


                                <div class="col-md-6">
                                        <div class="form-group">
                                                    <label class="control-label mb-3">Features (English)<span class="text-danger">*</span></label>
                                                    <textarea name="features_en" class="form-control" id="editor-en-3">{{ $planEn->features }}</textarea>
                                                    @error('features_en')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                        </div>
                                </div>
                                <div class="col-md-6">
                                <div class="form-group">
                                                    <label class="control-label mb-3">Features (Arabic)<span class="text-danger">*</span></label>
                                                    <textarea name="features_ar" class="form-control" id="editor-ar-3">{{ $planAr->features }}</textarea>
                                                    @error('features_ar')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                </div>

                        </div>
                        <!-- end-row -->
                        <div class="d-grid gap-10 col-1 mx-auto">
                                <button type="submit" class="btn btn-success" style="padding: 5px 52px; border-radius: 15px;">Update</button>
                        </div>
                    </div>
                    </form>
                </div>
                <!-- <div class="row">
                    <div class="col-12">
                        <div class="section-title">
                            <h5>Edit Plan</h5>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="block table-block mb-4" style="margin-top: 20px;">
                            <div class="row">
                                <form action="{{ url('manager/plan-managements/' . $plan->id) }}" method="post">
                                    @csrf
                                    @method('put')
                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <div class="block col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label">Plan Name (English)<span class="text-danger">*</span></label>
                                                    <input type="text" maxlength="80" placeholder="Title" value="{{ $planEn->plan_name }}" name="plan_name_en" class="form-control">
                                                    @error('plan_name_en')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <br/>

                                                <div class="form-group">
                                                    <label class="control-label">Plan Name (Arabic)<span class="text-danger">*</span></label>
                                                    <input type="text" maxlength="80" placeholder="Title" value="{{ $planAr->plan_name }}" name="plan_name_ar" class="form-control">
                                                    @error('plan_name_ar')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <br/>

                                                <div class="form-group">
                                                    <label class="control-label mb-2"> Plan Duration <span class="text-danger">*</span></label>
                                                    <select class="form-control" name="plan_duration_id" id="duration_name" disabled>
                                                        <option readonly>Choose Plan</option>
                                                        @foreach($planDurations as $planDuration)
                                                            <option value="{{ $planDuration->id }}" {{ $plan->plan_duration_id == $planDuration->id ? 'selected' : '' }}>{{ $planDuration->duration_name }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('plan_duration_id')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                @if($plan->plan_duration_id != 1)
                                                <div class="form-group">
                                                    <label class="control-label">Trial available (Days) </label>
                                                    <input type="text" maxlength="80" value="{{ $plan->trail_period }}" name="trail_period" class="form-control">
                                                    @error('trail_period')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <br/>

                                                <div class="form-group">
                                                    <label class="control-label">Plan Price </label>
                                                    <input type="text" maxlength="80" value="{{ $plan->price }}" name="price" class="form-control">
                                                    @error('price')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <br/>
                                                @endif

                                                <div class="form-group">
                                                    <label class="control-label mb-3">Description (English)<span class="text-danger">*</span></label>
                                                    <textarea name="description_en" class="form-control" id="editor-en">{{ $planEn->description }}</textarea>
                                                    @error('description_en')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>

                                                <div class="form-group">
                                                    <label class="control-label mb-3">Description (Arabic)<span class="text-danger">*</span></label>
                                                    <textarea name="description_ar" class="form-control" id="editor-ar">{{ $planAr->description }}</textarea>
                                                    @error('description_ar')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <br/>
                                                <br/>
                                                <div class="form-group">
                                                    <label class="control-label mb-3">Features (English)<span class="text-danger">*</span></label>
                                                    <textarea name="features_en" class="form-control" id="editor-en-3">{{ $planEn->features }}</textarea>
                                                    @error('features_en')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>

                                                <div class="form-group">
                                                    <label class="control-label mb-3">Features (Arabic)<span class="text-danger">*</span></label>
                                                    <textarea name="features_ar" class="form-control" id="editor-ar-3">{{ $planAr->features }}</textarea>
                                                    @error('features_ar')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>

                                                <br/>
                                                <br/>
                                                <div class="d-grid gap-10 col-1 mx-auto">
                                                    <button type="submit" class="btn btn-success" >Update</button>
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
