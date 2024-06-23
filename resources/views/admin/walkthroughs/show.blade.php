@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.walkthrough.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.walkthroughs.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.walkthrough.fields.id') }}
                        </th>
                        <td>
                            {{ $walkthrough->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.walkthrough.fields.page') }}
                        </th>
                        <td>
                            {{ $walkthrough->page }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.walkthrough.fields.title') }}
                        </th>
                        <td>
                            {{ $walkthrough->title }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.walkthrough.fields.description') }}
                        </th>
                        <td>
                            {{ $walkthrough->description }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.walkthrough.fields.image') }}
                        </th>
                        <td>
                            @if($walkthrough->image)
                                <a href="{{ $walkthrough->image->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $walkthrough->image->getUrl('thumb') }}">
                                </a>
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.walkthroughs.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection