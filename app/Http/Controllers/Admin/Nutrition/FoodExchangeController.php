<?php

namespace App\Http\Controllers\Admin\Nutrition;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddFoodExchangeRequest;
use App\Models\FoodExchange;
use App\Models\FoodExchangeMeasurement;
use App\Models\FoodExchangeTranslation;
use App\Models\FoodType;
use App\Models\MeasurementUnit;
use App\Services\Dashboard\Nutrition\FoodExchangeService;
use App\Traits\Photoable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class FoodExchangeController extends Controller
{
    use Photoable;
    private $service;

    public function __construct(FoodExchangeService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return view('admin.Nutrition.FoodExchange.index');
    }

    public function dataTable()
    {
        return datatables(FoodExchange::query()
            ->with(['foodType','mUnits'])
            ->orderBy('id', 'DESC'))
            ->editColumn('action', function($row) {
                $button  = '<div class="row">';
                $button .= '<div class="col-md-12 col-sm-6">';
                $button .= '<a class="btn btn-sm btn-info" style="margin-right: 5px;margin-bottom: 5px !important;" href="' . url('manager/nutrition/food-exchanges/' .$row->id) . '"><i class="fa fa-edit"></i></a>';
                $button .= '<button class="btn btn-sm btn-danger" style="margin-right: 5px;margin-bottom: 5px !important;" value="' . $row->id . '" id="delete-model" ><i class="fa fa-trash"></i></button>';
                $button .= '</div></div>';
                return $button;
            })
            ->editColumn('image', function($row) {
                if($row->image != null)
                {
                    $url = Storage::url("files/foodExchanges/images/" . $row->id . "/thumb-" . $row->image);
                    return '<img src="'.$url.'" style="width: 50px; height: 50px; padding: 2px;">';
                }
            })
            ->editColumn('food_type', function($row) {
               return $row->foodType->title;
            })
            ->addColumn('m_unit', function($row) {
                if($row->mUnits != null)
                {
                    return implode('</br>', $row->mUnits->pluck('name')->toArray());
                }
            })
            ->editColumn('quantity', function($row) {
                if($row->mUnits != null)
                {
                    return implode('</br>', $row->mUnits->pluck('pivot.quantity')->toArray());
                }
            })

            ->rawColumns(['image','food_type','m_unit','quantity' ,'action'])
            ->toJson();
    }

    public function show($id)
    {
        $foodExchange = FoodExchange::find($id);
        $foodTypes = FoodType::get();
        $measurementUnits = MeasurementUnit::get();
        $foodExchangeEn = FoodExchangeTranslation::where('food_exchange_id',$id)->where('locale','=','en')->select('title as title_en')->first();
        $foodExchangeAr = FoodExchangeTranslation::where('food_exchange_id',$id)->where('locale','=','ar')->select('title as title_ar')->first();

        $foodExchangeMeasurements = FoodExchangeMeasurement::join('measurement_units','measurement_units.id','=','food_exchange_measurements.measurement_unit_id')
            ->join('measurement_unit_translations','measurement_unit_translations.measurement_unit_id','=','measurement_units.id')
            ->where('food_exchange_id',$id)
            ->where('measurement_unit_translations.locale','=','en')
            ->select('measurement_units.id as m_id','food_exchange_measurements.measurement_unit_id','measurement_unit_translations.name as m_name','food_exchange_measurements.quantity')
            ->get();
        $output = '';
        foreach ($measurementUnits as $measurementUnit)
        {
            $output .= '<option value="'.$measurementUnit["id"].'">'.$measurementUnit["name"].'</option>';
        }
        return view('admin.Nutrition.FoodExchange.edit',compact('output','foodExchange','foodTypes','measurementUnits','foodExchangeMeasurements','foodExchangeAr','foodExchangeEn'));
    }
    public function create()
    {
        $foodTypes = FoodType::get();
        $measurementUnits = MeasurementUnit::get();
        $output = '';
        foreach ($measurementUnits as $measurementUnit){
            $output .= '<option value="'.$measurementUnit["id"].'">'.$measurementUnit["name"].'</option>';
        }
        return view('admin.Nutrition.FoodExchange.add',compact('foodTypes','output'));
    }
    public function store(AddFoodExchangeRequest $request)
    {
        $this->service->store($request);
        $notification = array('message' => "Food Exchange Added Successfully!",'alert-type' => 'success');
        return redirect()->to('/manager/nutrition/food-exchanges')->with($notification);
    }

    public function update(AddFoodExchangeRequest $request, FoodExchange $foodExchange)
    {
        $this->service->update($request, $foodExchange);
        $notification = array('message' => "Food Exchange Updated Successfully!",'alert-type' => 'info');
        return redirect()->to('/manager/nutrition/food-exchanges')->with($notification);
    }

    public function deleteMeasurementUnit($measurementUnitId, $foodExchangeId)
    {
        FoodExchangeMeasurement::where('food_exchange_id',$foodExchangeId)
            ->where('measurement_unit_id',$measurementUnitId)
            ->delete();
        return response()->json(['message' => "Measurement Unit Has Been Deleted Successfully!"],200);
    }

    public function destroy($id)
    {
        $foodExchange = FoodExchange::findOrFail($id);
        $checkCustomPlan = DB::table('user_meals_plans')->where('food_exchange_id', $id)->first();
        $recipe = DB::table('recipe_food_exchanges')->where('food_exchange_id', $id)->first();
        if($checkCustomPlan || $recipe)
        {
            return response()->json(['message' => "You can`t delete the Food Exchange, it has a plan"],400);
        }else{
            if($foodExchange->image != null)
            {
                $this->deleteFile($foodExchange->image,$foodExchange->id, 'foodExchanges/images/');
            }
            FoodExchangeTranslation::where('food_exchange_id', $id)->delete();
            FoodExchangeMeasurement::where('food_exchange_id', $id)->delete();
            $foodExchange->delete();
            return response()->json(['message' => "Food Exchange Deleted Successfully!"],200);
        }
    }
}
