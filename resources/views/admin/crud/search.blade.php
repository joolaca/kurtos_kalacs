@if($search)
    <div class="row">
        <div class="col-md-12">

            <div class="portlet light">
                <div class="portlet-title">
                    <div class="caption">
                        <span class="caption-subject font-green bold uppercase">{{ trans('global.search') }}</span>
                    </div>
                </div>
                <div class="portlet-body form">
                    {!! Form::model($search['value'], ['method' => 'GET', 'class' => 'form-horizontal', 'id' => 'form_search' ]) !!}
                    <div class="form-body">
                        @foreach($search['view'] as $view_key=>$view_value)
                            <div class="form-group">
                                <label class="col-md-3 control-label">
                                    {{$view_value['label']}}

                                </label>
                                <div class="col-md-9">

                                    @if($view_value['type'] == 'select')
                                        @if($view_value['disabled'])
                                            {!! Form::select($view_key, ['' => $view_value['empty']] + (array)$view_value['options'], null, ['class' => 'form-control2', 'disabled'=> true]) !!}
                                            {{ Form::hidden($view_key) }}
                                        @else
                                            {!! Form::select($view_key, ['' => $view_value['empty']] + (array)$view_value['options'], null, ['class' => 'form-control']) !!}
                                        @endif
                                    @endif
                                    @if($view_value['type'] == 'select2')
                                        {!! Form::select($view_key, $view_value['options']->prepend(trans('global.all'),''), null, ['class' => 'form-control select2']) !!}
                                    @endif
                                    @if($view_value['type'] == 'autocomplete')
                                        @if($view_value['disabled'])
                                            {!! Form::select($view_key, ['' => $view_value['empty']] + (array)$view_value['options'], null, ['class' => 'form-control2', 'disabled'=> true]) !!}
                                            {{ Form::hidden($view_key) }}
                                        @else
                                            {{ Form::text($view_value['ajax_id'], $view_value['autocomplete_text_value'], ['class' => 'form-control ajax_select', 'data-target' => 'hidden_'.$view_key]) }}
                                            {{ Form::hidden($view_key, null, ['id' => 'hidden_'.$view_key ]) }}


                                            @push('scripts_code')
                                            <script>
                                                $( function() {
                                                    $(".ajax_select").autocomplete({
                                                        source: "{{ $view_value['source'] }}",
                                                        minLength: 3,
                                                        autoFocus: true,
                                                        select: function( event, ui ) {

                                                            var target = $(this).data('target');
                                                            $('#'+target).val(ui.item.id);
                                                        }
                                                    });
                                                });
                                            </script>
                                            @endpush

                                        @endif


                                    @endif
                                    @if($view_value['type'] == 'daterangepicker')
                                        @include('common/crud/daterangepicker')
                                    @endif
                                    @if($view_value['type'] == 'text')
                                        {!! Form::text($view_key, null, ['class' => 'form-control']) !!}
                                    @elseif($view_value['type'] == 'boolean')
                                        {!! Form::select($view_key, ['' => $view_value['empty'],'0' => trans('global.no'), '1' => trans('global.yes')], null, ['class' => 'form-control']) !!}
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-offset-3 col-md-9">
                                <button type="submit" class="btn btn-primary">{{ trans('global.search') }}</button>
                                <a class="btn btn-default" href="/{{$crud_data['url']}}">{{ trans('global.searchform_reset') }}</a>
                            </div>
                        </div>
                    </div>
                    {{--index tábla rendezéséhez--}}
                    @if(\Illuminate\Support\Facades\Input::has('sort'))
                        {!! Form::hidden('sort', \Illuminate\Support\Facades\Input::get('sort')) !!}
                        {!! Form::hidden('direction', \Illuminate\Support\Facades\Input::get('direction')) !!}
                    @endif
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endif
