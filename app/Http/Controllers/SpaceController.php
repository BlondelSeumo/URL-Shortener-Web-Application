<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSpaceRequest;
use App\Http\Requests\UpdateSpaceRequest;
use App\Space;
use App\Traits\SpaceTrait;
use Illuminate\Http\Request;

class SpaceController extends Controller
{
    use SpaceTrait;

    /**
     * List the Spaces.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $sort = ($request->input('sort') == 'asc' ? 'asc' : 'desc');

        $spaces = Space::where('user_id', $request->user()->id)
            ->when($search, function($query) use ($search) {
                return $query->searchName($search);
            })
            ->orderBy('id', $sort)
            ->paginate(config('settings.paginate'))
            ->appends(['search' => $search, 'sort' => $sort]);

        return view('spaces.content', ['view' => 'list', 'spaces' => $spaces]);
    }

    /**
     * Show the create Space form.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('spaces.content', ['view' => 'new']);
    }

    /**
     * Show the edit Space form.
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Request $request, $id)
    {
        $space = Space::where([['id', '=', $id], ['user_id', '=', $request->user()->id]])->firstOrFail();

        return view('spaces.content', ['view' => 'edit', 'space' => $space]);
    }

    /**
     * Store the Space.
     *
     * @param StoreSpaceRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreSpaceRequest $request)
    {
        $this->spaceStore($request);

        return redirect()->route('spaces')->with('success', __(':name has been created.', ['name' => $request->input('name')]));
    }

    /**
     * Update the Space.
     *
     * @param UpdateSpaceRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateSpaceRequest $request, $id)
    {
        $space = Space::where([['id', '=', $id], ['user_id', '=', $request->user()->id]])->firstOrFail();

        $this->spaceUpdate($request, $space);

        return back()->with('success', __('Settings saved.'));
    }

    /**
     * Delete the Space.
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Request $request, $id)
    {
        $space = Space::where([['id', '=', $id], ['user_id', '=', $request->user()->id]])->firstOrFail();

        $space->delete();

        return redirect()->route('spaces')->with('success', __(':name has been deleted.', ['name' => $space->name]));
    }
}
