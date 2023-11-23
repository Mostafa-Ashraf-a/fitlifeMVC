<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function index()
    {
        $subscriptions = Subscription::query()
            ->with(['user','plan'])
            ->latest()
            ->get();
        return view('admin.Subscriptions.index', compact('subscriptions'));
    }
    public function show()
    {

    }
}
