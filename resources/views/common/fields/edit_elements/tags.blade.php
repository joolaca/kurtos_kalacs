<label class="control-label"> {{$field->getLabel()}} </label><br/>

<select multiple="" class="tagsinput" data-role="" style="display: none; " name="{{$field->getName()}}[]" id="{{$field->getName()}}">

    @foreach($options as $option)
        {!! $option !!}
    @endforeach

</select>

@push('extend_scripts')
$("#{{$field->getName()}}").inputtags({!! $field->showInputOptions()  !!});
@endpush
