<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\StoreLinkRequest;
use App\Http\Requests\API\UpdateLinkRequest;
use App\Http\Resources\LinkResource;
use App\Link;
use App\LinkPixel;
use App\Traits\LinkTrait;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LinkController extends Controller
{
    use LinkTrait;

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $space = $request->input('space');
        $domain = $request->input('domain');
        $pixel = $request->input('pixel');
        $status = $request->input('status');
        $by = $request->input('by');
        $perPage = (($request->input('per_page') >= 10 && $request->input('per_page') <= 100) ? $request->input('per_page') : config('settings.paginate'));

        if ($request->input('sort') == 'min') {
            $sort = ['clicks', 'asc'];
        } elseif ($request->input('sort') == 'max') {
            $sort = ['clicks', 'desc'];
        } elseif ($request->input('sort') == 'asc') {
            $sort = ['id', 'asc'];
        } else {
            $sort = ['id', 'desc'];
        }

        return LinkResource::collection(Link::with('domain', 'space')->where('user_id', $request->user()->id)
            ->when($domain, function($query) use ($domain) {
                return $query->ofDomain($domain);
            })
            ->when($space, function($query) use ($space) {
                return $query->ofSpace($space);
            })
            ->when($pixel, function($query) use ($pixel) {
                return $query->whereIn('id', LinkPixel::select('link_id')->where('pixel_id', '=', $pixel)->get());
            })
            ->when($status, function($query) use ($status) {
                if($status == 1) {
                    return $query->active();
                } elseif($status == 2) {
                    return $query->expired();
                } else {
                    return $query->disabled();
                }
            })
            ->when($search, function($query) use ($search, $by) {
                if($by == 'url') {
                    return $query->searchUrl($search);

                } elseif ($by == 'alias') {
                    return $query->searchAlias($search);
                }
                return $query->searchTitle($search);
            })
            ->orderBy($sort[0], $sort[1])
            ->paginate($perPage)
            ->appends(['search' => $search, 'domain' => $domain, 'space' => $space, 'pixel' => $pixel, 'by' => $by, 'sort' => $sort[2], 'per_page' => $perPage]))
            ->additional(['status' => 200]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreLinkRequest $request
     * @return LinkResource|\Illuminate\Http\JsonResponse
     */
    public function store(StoreLinkRequest $request)
    {
        if (!$request->input('multi_link')) {
            $created = $this->linkStore($request);

            if ($created) {
                return LinkResource::make($created);
            }
        }

        return response()->json([
            'message' => 'Resource not found.',
            'status' => 404
        ], 404);
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param int $id
     * @return LinkResource|\Illuminate\Http\JsonResponse
     */
    public function show(Request $request, $id)
    {
        $link = Link::where([['id', '=', $id], ['user_id', $request->user()->id]])->first();

        if ($link) {
            return LinkResource::make($link);
        }

        return response()->json([
            'message' => 'Resource not found.',
            'status' => 404
        ], 404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateLinkRequest $request
     * @param $id
     * @return LinkResource
     */
    public function update(UpdateLinkRequest $request, $id)
    {
        $link = Link::where([['id', '=', $id], ['user_id', '=', $request->user()->id]])->firstOrFail();

        $updated = $this->linkUpdate($request, $link);

        if ($updated) {
            return LinkResource::make($updated);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Request $request, $id)
    {
        $link = Link::where([['id', '=', $id], ['user_id', '=', $request->user()->id]])->first();

        if ($link) {
            $link->delete();

            return response()->json([
                'id' => $link->id,
                'object' => 'link',
                'deleted' => true,
                'status' => 200
            ], 200);
        }

        return response()->json([
            'message' => 'Resource not found.',
            'status' => 404
        ], 404);
    }
}
