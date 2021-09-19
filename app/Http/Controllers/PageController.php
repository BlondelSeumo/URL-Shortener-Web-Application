<?php

namespace App\Http\Controllers;

use App\Page;

class PageController extends Controller
{
    /**
     * Show the page.
     *
     * @param $url
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index($url)
    {
        $page = Page::where('slug', $url)->firstOrFail();

        return view('page.page', ['page' => $page]);
    }
}
