<?php


namespace App\Traits;

use App\Domain;
use Illuminate\Http\Request;

trait DomainTrait
{
    /**
     * Store a new domain
     *
     * @param Request $request
     * @param null $admin
     * @return Domain
     */
    protected function domainStore(Request $request, $admin = null)
    {
        $domain = new Domain;

        $domain->name = parse_url(str_replace('://www.', '://', $request->input('name')))['host'];
        $domain->user_id = (isset($admin) ? 0 : $request->user()->id);
        $domain->index_page = $request->input('index_page');
        $domain->not_found_page = $request->input('not_found_page');
        $domain->save();

        return $domain;
    }

    /**
     * Update the domain
     *
     * @param Request $request
     * @param Domain $domain
     * @return Domain
     */
    protected function domainUpdate(Request $request, Domain $domain)
    {
        if ($request->has('index_page')) {
            $domain->index_page = $request->input('index_page');
        }

        if ($request->has('not_found_page')) {
            $domain->not_found_page = $request->input('not_found_page');
        }

        $domain->save();

        return $domain;
    }
}