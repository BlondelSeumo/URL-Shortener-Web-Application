<?php

namespace App\Http\Controllers;

use App\Cronjob;
use Illuminate\Support\Facades\Artisan;

class CronjobController extends Controller
{
    /**
     * Clear the app's cache.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function cache()
    {
        Artisan::call('view:clear');
        Artisan::call('cache:clear');

        $cronjob = new Cronjob;
        $cronjob->name = 'cache';
        $cronjob->save();

        return response()->json([
            'status' => 200
        ], 200);
    }
}
