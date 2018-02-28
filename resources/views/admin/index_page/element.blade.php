<section id="mini_description_container">

    {!! Form::open(['method'=> 'POST', 'class'=> 'form-horizontal', 'id' => 'element_form_id_'.$item->id]) !!}

    <div class="form-body  col-lg-6">

        <div class="form-group">
            <label class="col-md-3 control-label">Cím</label>
            <div class="col-md-9">
                {!! Form::text(
                    'title',
                    isset($item->title) ? $item->title : '',
                    ['class' => 'form-control'])
                !!}
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-3 control-label">Link</label>
            <div class="col-md-9">
                {!! Form::text(
                    'href',
                    isset($item->href) ? $item->href : '',
                    ['class' => 'form-control'])
                !!}
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-3 control-label">Link2</label>
            <div class="col-md-9">
                {!! Form::text(
                    'href2',
                    isset($item->href2) ? $item->href2 : '',
                    ['class' => 'form-control'])
                !!}
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-3 control-label">Leírás</label>
            <div class="col-md-9">
                {!! Form::text(
                    'content',
                     isset($item->description) ? $item->description : '',
                     ['class' => 'form-control'])
                !!}
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-3 control-label">Tartalom</label>
            <div class="col-md-9">
                {!! Form::textarea(
                    'content',
                     isset($item->content) ? $item->content : '',
                     ['class' => 'form-control tinymce'])
                !!}
            </div>
        </div>



        <div class="form-group">
            <label class="col-md-3">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#selectSlideModal"
                data-element-id="{{$item->id}}">Kép</button>
            </label>

            <div class="col-md-9" >

                @if(isset($item->slide))
                    <img src="{{$item->slide->getImageThumbUrl('image', '400_200_')}}" alt=""
                         id="selected_slide_{{$item->id}}">
                @else
                    <img src="{{url('assets/img/default_image/400_200.jpg')}}" alt=""
                         id="selected_slide_{{$item->id}}">
                @endif
            </div>

        </div>

        {!! Form::hidden('type', $item->type) !!}
        {!! Form::hidden('slide_id', $item->slide_id , ['id' => 'slide_hidden_id_'.$item->id] ) !!}
        {!! Form::hidden('id', isset($item->id) ? $item->id : ''  ) !!}
        {!! Form::submit('ok',['class'=> 'btn blue btn-block' ]) !!}
    {!! Form::close() !!}


    {!! Form::open(['url'=> '/admin/delete_index_page_element', 'method'=> 'post']) !!}
    {!! Form::hidden('id', isset($item->id) ? $item->id : ''  ) !!}
    {!! Form::submit('Törlés', ['class' => 'btn red btn-block']) !!}
    {!! Form::close() !!}

    </div>
</section>