<label class=" control-label"> {{$field->getLabel()}} </label>

@if($required)
    <span class="required">*</span>
@endif

<fieldset class="sco_container row" >
    <div class="col-md-5">
        <input class="search_from col-md-12" type="text" placeholder="{{ trans('global.search') }}" >

        {!! Form::select('select_from', $options['option_from'], null,
            ['multiple'=>'multiple','class' => 'form-control select_from'])
        !!}
    </div>

    <div class="col-md-2">
        <a href="JavaScript:void(0);"  class="btn_add">Add &raquo;</a> <br><br>
        <a href="JavaScript:void(0);"  class="btn_remove">&laquo; Remove</a>
    </div>

    <div class="col-md-4">
        {!! Form::select('select_to', $options['option_to'], null,
            ['multiple'=>'multiple','class' => 'form-control select_to' , 'id' => $field->getName()])
        !!}
    </div>

    <div class="col-md-1">
        <a href="JavaScript:void(0);"  class="btn_up">Up</a><br><br>
        <a href="JavaScript:void(0);" class="btn_down">Down</a>
    </div>
</fieldset>

@push('include_scripts')
    <script src="{{ URL::asset('/assets/js/crud/multiple_order.js') }}" type="text/javascript"></script>
@endpush
