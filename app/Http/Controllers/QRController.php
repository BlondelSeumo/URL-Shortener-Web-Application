<?php

namespace App\Http\Controllers;

use App\Link;
use Illuminate\Http\Request;

class QRController extends Controller
{
    /**
     * Show the QR code.
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request, $id)
    {
        $link = Link::findOrFail($id);

        return view('qr/content', ['link' => $link]);
    }
}
