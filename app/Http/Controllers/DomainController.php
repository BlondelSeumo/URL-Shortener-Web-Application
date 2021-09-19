<?php

namespace App\Http\Controllers;

use App\Domain;
use App\Http\Requests\StoreDomainRequest;
use App\Http\Requests\UpdateDomainRequest;
use App\Traits\DomainTrait;
use Illuminate\Http\Request;

class DomainController extends Controller
{
    use DomainTrait;

    /**
     * List the Domains.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $sort = ($request->input('sort') == 'asc' ? 'asc' : 'desc');

        $domains = Domain::where('user_id', $request->user()->id)
            ->when($search, function($query) use ($search) {
                return $query->searchName($search);
            })
            ->orderBy('id', $sort)
            ->paginate(config('settings.paginate'))
            ->appends(['search' => $search, 'sort' => $sort]);

        return view('domains.content', ['view' => 'list', 'domains' => $domains]);
    }

    /**
     * Show the create Domain form.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('domains.content', ['view' => 'new']);
    }

    /**
     * Show the edit Domain form.
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Request $request, $id)
    {
        $domain = Domain::where([['id', '=', $id], ['user_id', '=', $request->user()->id]])->firstOrFail();

        return view('domains.content', ['view' => 'edit', 'domain' => $domain]);
    }

    /**
     * Store the Domain.
     *
     * @param StoreDomainRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreDomainRequest $request)
    {
        $this->domainStore($request);

        return redirect()->route('domains')->with('success', __(':name has been created.', ['name' => str_replace(['http://', 'https://'], '', $request->input('name'))]));
    }

    /**
     * Update the Domain.
     *
     * @param UpdateDomainRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateDomainRequest $request, $id)
    {
        $domain = Domain::where([['id', '=', $id], ['user_id', '=', $request->user()->id]])->firstOrFail();

        $this->domainUpdate($request, $domain);

        return back()->with('success', __('Settings saved.'));
    }

    /**
     * Delete the Domain.
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Request $request, $id)
    {
        $domain = Domain::where([['id', '=', $id], ['user_id', '=', $request->user()->id]])->firstOrFail();

        $domain->delete();

        return redirect()->route('domains')->with('success', __(':name has been deleted.', ['name' => $domain->name]));
    }
}
