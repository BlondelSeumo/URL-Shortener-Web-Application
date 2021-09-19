<?php

namespace App\Http\Controllers;

use App\Domain;
use App\Plan;

class PricingController extends Controller
{
    /**
     * Show the Pricing page.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $plans = Plan::where('visibility', 1)->get();

        $domains = Domain::select('name')->where('user_id', '=', 0)->get()
            ->map(function ($item) {
                return $item->name;
            })
            ->toArray();

        return view('pricing.index', ['plans' => $plans, 'domains' => $domains]);
    }
}
