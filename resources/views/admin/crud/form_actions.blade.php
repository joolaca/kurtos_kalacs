<div class="form-actions">
    @if(!empty($edit_crud_buttons))
        @foreach($edit_crud_buttons as $button)
            <a href="{{ url($button['url']) }}" class="{{ $button['class'] }}">{{ $button['title'] }}</a>
        @endforeach
    @else
        {{ Form::button('<i class="fa fa-check"></i> ' . trans('global.save'), array('class'=>'loadingButton btn btn-success', 'type'=>'submit', 'data-loading-text'=>trans('global.button_loading_text'))) }}
        <!--<a href="{ URL::previous() }}" class="btn btn-default pull-right">-->
        <a href="{{  url()->previous() }}" class="btn btn-default pull-right">
            <i class="fa fa-times"></i>
            {{trans('global.exit')}}
        </a>
    @endif
</div>

