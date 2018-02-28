@extends('admin.layouts.admin_layout')
@section('content')

    <div class="portlet light">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject font-green bold uppercase">{{ $item->title }} kép thumbnail szerkesztése</span>
            </div>

            {!! Form::open(['url' => '/generate_thumbnail_sizes', 'style="float:right"']) !!}

                {{ Form::hidden('path', $item->getPrefixFilePath($path, '')) }}
                {!! Form::submit('Thumbnail generálás', ['class' => 'btn btn-primary']) !!}

            {!! Form::close() !!}

        </div>

        <div class="portlet-body">



        </div>
    </div>

    @foreach($item->getThumbnailSizes() as $size)

        <div class="row">

            <div class="col-md-4">
                <div class="row">
                    <div class="col-md-2"> {{ trans('global.name') }}: </div>
                    <div class="col-md-10">
                        {{$size->name}}
                        ( {{$size->width}} * {{$size->height }} )

                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2"> {{ trans('global.prefix') }}: </div>
                    <div class="col-md-10"> <span class="badge badge-info">{{$size->prefix}}</span> </div>
                </div>
                <div class="row">
                    <div class="col-md-2"> {{ trans('global.description') }}: </div>
                    <div class="col-md-10"> {{$size->description}} </div>
                </div>

            </div>

            <div class="col-md-8">
                <img src="{!! url($item->getPrefixFilePath($path, $size->prefix)).'?'.rand(1,4000) !!}"
                     data-href="{!!
                     url('/admin/crop_modal/'
                     .$item->id
                     .'/'. $field
                     .'/'.$size->prefix
                     .'/'. encrypt(get_class($item))) !!}"
                     class="crop_image img-thumbnail" title="{{ trans('global.editing') }}">
            </div>
        </div>

        <hr />

    @endforeach

    <div class="row">

        <div class="col-xs-12 col-sm-3 col-md-4 margin-bottom-10">
            Eredeti kép
        </div>
        <div class="col-xs-12 col-sm-9 col-md-8">
            <img src="{!! url($path) !!}" class="img-thumbnail" >
        </div>

    </div>

@endsection

@push('scripts_code')
    <script>

        $('.crop_image').click(function(e) {
            e.preventDefault();
            var url = $(this).attr('data-href');
            $.get(url, function(data) {
                $(data).modal();
                // $(data).appendTo('body').modal();
            });
        });

    </script>
@endpush