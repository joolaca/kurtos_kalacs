<div class="table-scrollable">
    <table class="table table-hover sort_table" >
        <thead>

        @foreach($index_fields as $field)

            {!! $field->showTableHeadCell($sort, $direction) !!}

        @endforeach

        @if(isset($crud_data['table_crud_btn']))
            <th class="actions">{{ trans('global.actions') }}</th>
        @endif
        </thead>

        @if (count($items) > 0)
            <tbody>
            @foreach ($items as $item)
                <tr>

                    @foreach($index_fields as $field)

                        {!! $field->showTableCell($item) !!}

                    @endforeach



                    @if(isset($crud_data['table_crud_btn']))
                        <td class="actions">
                            {{ Form::open(array('url' => 'admin/'.$crud_data['url'].'/' . $item->id, 'class' => 'notification_delete')) }}
                            @foreach($crud_data['table_crud_btn'] as $btn)
                                @if($btn == 'edit')
                                    <a class="btn btn-primary" href="{{ url('admin/'.$crud_data['url'].'/'.$item->id.'/edit') }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @elseif($btn == 'show')
                                    <a class="btn btn-sm btn-success" href="{{ url($crud_data['url'].'/'.$item->id) }}">
                                        <i class="fa fa-edit"></i>
                                        {{ trans('global.details') }}
                                    </a>
                                @elseif($btn == 'delete')
                                    {{ Form::hidden('_method', 'DELETE') }}
                                    {{ Form::submit(trans('global.delete'), array('class' => 'btn btn-danger')) }}

                                @elseif($btn == 'clone')
                                    <a class="btn btn-sm btn-warning" target="_blank"
                                       href="{{ url('/'.$crud_data['url'].'/'.$item->id.'/clone') }}">
                                        <i class="fa fa-copy"></i>
                                        {{ trans('global.copy') }}
                                    </a>
                                @elseif($btn == 'preview')
                                    <a class="btn btn-sm btn-success" target="_blank"
                                       href="{{ $content_package['frontend_url'].'/'.$crud_data['url'].'/show/'.$item->id.'?preview='.base64_encode(env('PREVIEW_KEY','PREVIEW_KEY').date('Y-m-d H'))  }}">
                                        <i class="fa fa-eye"></i>
                                        {{ trans('global.preview') }}
                                    </a>

                                @elseif($btn == 'offer_preview')
                                    <a class="btn btn-warning show_offer_preview"
                                       title="{{ trans('global.preview') }}"
                                       data-target="#offer_modal"
                                       data-offer-id="{{ $item->id }}"
                                       data-ajax-url="{{ url("/ajax/".$crud_data['url']."/modal_content/".$item->id) }}">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                @else
                                    @if($btn['type'] == 'link_with_id')
                                        <?php $controller = isset($btn['controller']) ? $btn['controller'] : $crud_data['url']; ?>
                                        <a class="btn {{ $btn['class'] }}" href="{{ url('/'.$controller.'/'.$item->id.'/'.$btn['method']) }}">
                                            {{ $btn['label'] }}
                                        </a>
                                    @elseif($btn['type'] == 'render')
                                        {!! $item->{$btn['method']}() !!}
                                    @endif
                                @endif
                            @endforeach
                            {{ Form::close() }}
                        </td>
                    @endif

                </tr>
            @endforeach
            </tbody>
        @endif
    </table>

    @if(class_basename($items) == 'LengthAwarePaginator')
            <!--<div class="row">
			<div class="col-md-12 col-sm-12"> -->
    <div class="dataTables_paginate paging_bootstrap_number">
        {{$items->links() }}
    </div>
    <!--</div>
</div> -->

    @endif
</div>
{{-- ha van offer_preview akkor kell ez a modal --}}
@if(in_array('offer_preview', $crud_data['table_crud_btn']))

    {{-- CSS --}}
    @push('include_css')
    <link href="{{ URL::asset('/assets/css/frontend.css') }}" rel="stylesheet" type="text/css" />
    @endpush

    @push('scripts_code')
    <script>
        $(function() {

            $("body").delegate('.show_offer_preview', 'click', function(event){
                event.preventDefault();
                var element = $(this);
                var target_offer = element.data('ajax-url');
                var target_modal = element.data('target');
                $.ajax({
                    method: "GET",
                    url: target_offer,
                    //dataType: "json",
                    success: function(data) {
                        $(target_modal).on('show.bs.modal', function (e) {
                            var modal = $(this)
                            modal.find('.modal-content').replaceWith(data.html);
                        });

                        $(target_modal).modal();

                    },
                    error: function(xhr, status, error) {
                    }
                });

            });

        });
    </script>
    @endpush

    {{-- MODAL --}}
@section('include_modals')
    <div class="modal fade" id="offer_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('global.close') }}</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@endif