<?php


namespace App\Filters\UserBodyTrackers\Weight;

use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class WeightFilters extends QueryFilters
{
    protected $request;
    public function __construct(Request $request)
    {
        $this->request = $request;
        parent::__construct($request);
    }
    public function filter($type = null)
    {
        if ($this->request->filter == 'daily') {
            return $this->builder->where('date', '>', Carbon::today('Asia/Riyadh')->subDays(7)->format('Y-m-d'));
        } elseif ($this->request->filter == 'weekly') {
            return $this->builder->where('date', '>', Carbon::today('Asia/Riyadh')->subDays(30)->format('Y-m-d'));
        }elseif($this->request->filter == 'monthly'){
            return $this->builder->where('date', '>', Carbon::today('Asia/Riyadh')->subDays(365)->format('Y-m-d'));
        }
    }
}
