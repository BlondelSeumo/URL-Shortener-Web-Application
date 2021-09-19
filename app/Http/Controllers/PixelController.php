<?php

namespace App\Http\Controllers;

use App\Pixel;
use App\Http\Requests\StorePixelRequest;
use App\Http\Requests\UpdatePixelRequest;
use App\Traits\PixelTrait;
use Illuminate\Http\Request;

class PixelController extends Controller
{
    use PixelTrait;

    /**
     * List the Pixels.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $type = $request->input('type');
        $sort = ($request->input('sort') == 'asc' ? 'asc' : 'desc');

        $pixels = Pixel::where('user_id', $request->user()->id)
            ->when($search, function($query) use ($search) {
                return $query->searchName($search);
            })->when($type, function($query) use ($type) {
                return $query->ofType($type);
            })
            ->orderBy('id', $sort)
            ->paginate(config('settings.paginate'))
            ->appends(['search' => $search, 'sort' => $sort]);

        return view('pixels.content', ['view' => 'list', 'pixels' => $pixels]);
    }

    /**
     * Show the create Pixel form.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('pixels.content', ['view' => 'new']);
    }

    /**
     * Show the edit Pixel form.
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Request $request, $id)
    {
        $pixel = Pixel::where([['id', '=', $id], ['user_id', '=', $request->user()->id]])->firstOrFail();

        return view('pixels.content', ['view' => 'edit', 'pixel' => $pixel]);
    }

    /**
     * Store the Pixel.
     *
     * @param StorePixelRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StorePixelRequest $request)
    {
        $this->pixelStore($request);

        return redirect()->route('pixels')->with('success', __(':name has been created.', ['name' => str_replace(['http://', 'https://'], '', $request->input('name'))]));
    }

    /**
     * Update the Pixel.
     *
     * @param UpdatePixelRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdatePixelRequest $request, $id)
    {
        $pixel = Pixel::where([['id', '=', $id], ['user_id', '=', $request->user()->id]])->firstOrFail();

        $this->pixelUpdate($request, $pixel);

        return back()->with('success', __('Settings saved.'));
    }

    /**
     * Delete the Pixel.
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Request $request, $id)
    {
        $pixel = Pixel::where([['id', '=', $id], ['user_id', '=', $request->user()->id]])->firstOrFail();

        $pixel->delete();

        return redirect()->route('pixels')->with('success', __(':name has been deleted.', ['name' => str_replace(['http://', 'https://'], '', $pixel->name)]));
    }
}
