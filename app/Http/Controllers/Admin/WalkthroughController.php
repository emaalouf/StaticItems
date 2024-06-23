<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyWalkthroughRequest;
use App\Http\Requests\StoreWalkthroughRequest;
use App\Http\Requests\UpdateWalkthroughRequest;
use App\Models\Walkthrough;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class WalkthroughController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('walkthrough_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $walkthroughs = Walkthrough::with(['media'])->get();

        return view('admin.walkthroughs.index', compact('walkthroughs'));
    }

    public function create()
    {
        abort_if(Gate::denies('walkthrough_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.walkthroughs.create');
    }

    public function store(StoreWalkthroughRequest $request)
    {
        $walkthrough = Walkthrough::create($request->all());

        if ($request->input('image', false)) {
            $walkthrough->addMedia(storage_path('tmp/uploads/' . basename($request->input('image'))))->toMediaCollection('image');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $walkthrough->id]);
        }

        return redirect()->route('admin.walkthroughs.index');
    }

    public function edit(Walkthrough $walkthrough)
    {
        abort_if(Gate::denies('walkthrough_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.walkthroughs.edit', compact('walkthrough'));
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

        return redirect()->route('admin.walkthroughs.index');
    }

    public function show(Walkthrough $walkthrough)
    {
        abort_if(Gate::denies('walkthrough_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.walkthroughs.show', compact('walkthrough'));
    }

    public function destroy(Walkthrough $walkthrough)
    {
        abort_if(Gate::denies('walkthrough_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $walkthrough->delete();

        return back();
    }

    public function massDestroy(MassDestroyWalkthroughRequest $request)
    {
        $walkthroughs = Walkthrough::find(request('ids'));

        foreach ($walkthroughs as $walkthrough) {
            $walkthrough->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('walkthrough_create') && Gate::denies('walkthrough_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Walkthrough();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
