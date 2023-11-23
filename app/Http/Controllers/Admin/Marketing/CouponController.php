<?php

namespace App\Http\Controllers\Admin\Marketing;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Marketing\Coupon\StoreRequest;
use App\Http\Requests\Dashboard\Marketing\Coupon\UpdateRequest;
use App\Models\Coupon;
use Illuminate\Validation\Rule;

class CouponController extends Controller
{

    public function index()
    {
        $coupons = Coupon::query()
            ->orderBy('id', 'DESC')
            ->get();
        return view('admin.Marketing.Coupons.index', compact('coupons'));
    }

    public function create()
    {
        return view('admin.Marketing.Coupons.store');
    }

    public function store(StoreRequest $request)
    {
        Coupon::create($request->validated());
        $notification = array('message' => "Coupon Added Successfully!",'alert-type' => 'info');
        return redirect()->to('/manager/marketing/coupons')->with($notification);
    }

    public function edit(Coupon $coupon)
    {
        return view('admin.Marketing.Coupons.edit', compact('coupon'));
    }

    public function update(UpdateRequest $request, Coupon $coupon)
    {
        $request->validate([
            'code' => ['required', 'max:6', 'min:6',
                Rule::unique('coupons')->ignore($coupon->id)
            ],
        ]);
        $coupon->update($request->validated());
        $notification = array('message' => "Coupon Updated Successfully!",'alert-type' => 'info');
        return redirect()->to('/manager/marketing/coupons')->with($notification);
    }

    public function changeStatus($couponId)
    {
        $coupon = Coupon::findOrFail($couponId);
        if($coupon->status != 1)
        {
            $coupon->update(['status'=> 1]);
        }else{
            $coupon->update(['status'=> 0]);
        }
        return response()->json([],200);
    }

    public function destroy($id)
    {
        $coupon = Coupon::findOrFail($id);
        $coupon->delete();
        return response()->json(['message' => "Coupon Has been Deleted Successfully!"],200);
    }
}
