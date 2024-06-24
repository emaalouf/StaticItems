<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreWalkthroughRequest;
use App\Http\Requests\UpdateWalkthroughRequest;
use App\Http\Resources\Admin\WalkthroughResource;
use App\Models\Walkthrough;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class WalkthroughApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('walkthrough_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new WalkthroughResource(Walkthrough::all());
    }

    public function store(StoreWalkthroughRequest $request)
    {
        $walkthrough = Walkthrough::create($request->all());

        if ($request->input('image', false)) {
            $walkthrough->addMedia(storage_path('tmp/uploads/' . basename($request->input('image'))))->toMediaCollection('image');
        }

        return (new WalkthroughResource($walkthrough))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Walkthrough $walkthrough)
    {
        abort_if(Gate::denies('walkthrough_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new WalkthroughResource($walkthrough);
    }

    public function update(UpdateWalkthroughRequest $request, Walkthrough $walkthrough)
    {
        $walkthrough->update($request->all());

        if ($request->input('image', false)) {
            if (! $walkthrough->image || $request->input('image') !== $walkthrough->image->file_name) {
                if ($walkthrough->image) {
                    $walkthrough->image->delete();
                }
                $walkthrough->addMedia(storage_path('tmp/uploads/' . basename($request->input('image'))))->toMediaCollection('image');
            }
        } elseif ($walkthrough->image) {
            $walkthrough->image->delete();
        }

        return (new WalkthroughResource($walkthrough))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Walkthrough $walkthrough)
    {
        abort_if(Gate::denies('walkthrough_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $walkthrough->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
