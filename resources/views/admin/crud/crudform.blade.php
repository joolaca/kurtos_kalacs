<?php $form = new Form();?>

@if(isset($item))

    {!! $form::model($item, ['method' => 'PATCH', 'route' => [$url.'.update', $item->id], 'role' => 'form', 'id'=>'crudform', 'files' => true]) !!}

    @if(isset($edit_actions_header) && $edit_actions_header === TRUE)
        @include("admin.crud.form_actions")
    @endif

@else

    {!! $form::open(['route' => $url.'.store', 'role' => 'form', 'id'=>'crudform', 'files' => true, 'method' => 'POST']) !!}
    <?php $item = null; ?>
    @if(isset($create_actions_header) && $create_actions_header === TRUE)
        @include("admin.crud.form_actions")
    @endif

@endif
<div class="form-body crud_form_container">

@foreach($panels as $panel)
    @if($panel->hasRows())
    <div class="cf_panel ">
        @if($panel->hasTitle())
        <div class="note note-info">{!! $panel->getTitle() !!}</div>
        @endif

        @foreach($panel->getRows() as $row)

            @if($row->hasFields())
            <div class="{{ (!$row->isHidden()) ? 'row cf_row ' . $row->getClass() : '' }}">
            @foreach($row->getFields() as $field)

                @if($field->isHideEdit()) @continue @endif


                <div id="form_group_{{$field->getName()}}" class="form-group cf_field {{ $errors->has($field->getName()) ? ' has-error' : '' }}">

                    {!! $field->getFormHtml($item) !!}
                    @if ($errors->has($field->getName()))
                        <span class="help-block">{{ $errors->first($field->getName()) }}</span>
                    @endif
                </div>

            @endforeach
            @endif
            </div> {{--end rows--}}

        @endforeach
    </div> {{--end panel--}}
    @endif
@endforeach


</div> {{--form-body"--}}

@yield('before_form_buttons')
@include("admin.crud.form_actions")

{!! Form::close() !!}