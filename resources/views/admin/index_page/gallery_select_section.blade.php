<section class="row" id="{{$slug}}_container">
    <div class="col-md-12">
        <div class="portlet box blue-hoki">
            <div class="portlet-title"> <div class="caption">{{$title}}</div> </div>

            <div class="portlet-body form">
                @php $element_form_id = !empty($item) ? $item->id : '' @endphp
                {!! Form::open(['method'=> 'POST', 'class'=> 'form-horizontal','id' => 'element_form_id_'.$element_form_id ]) !!}
                <div class="form-body">
                    <div class="form-group">
                        <label class="col-md-3 control-label">Galéria</label>
                        <div class="col-md-9">
                            {!! Form::select('gallery_id',
                                \App\Model\Gallery::all()->pluck('title', 'id'),
                                isset($item['gallery_id']) ? $item['gallery_id'] : '',
                                ['class' =>'form-control']
                                )
                            !!}
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label">Galéria link</label>
                        <div class="col-md-9">
                            {!! Form::text('href',
                                isset($item['href']) ? $item['href'] : '',
                                 ['class' =>'form-control']
                            ) !!}
                        </div>
                    </div>
                    {!! Form::hidden('type', $slug) !!}
                    {!! Form::hidden('id', isset($item->id) ? $item->id : ''  ) !!}
                    {!! Form::submit('ok',['class'=> 'btn blue btn-block']) !!}
                    {!! Form::close() !!}
                </div>
            </div> {{--portlet-body--}}
        </div> {{--portlet box blue-hoki--}}

    </div>
</section>