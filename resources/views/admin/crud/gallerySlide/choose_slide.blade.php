@extends('admin.layouts.admin_layout')

@section('content')


    <div class="row">
        <div class="col-md-12">
            <div class="portlet light">
                <div class="portlet-title">
                    <div class="caption">
                        <span class="caption-subject font-green bold uppercase">{{ trans('global.search') }}</span>
                    </div>
                </div>
                <div class="portlet-body form">
                    {!! Form::model($request->all(), ['method' => 'GET', 'class' => 'form-horizontal', 'id' => 'form_search' ]) !!}
                    {!! Form::select('category_id', $categories, null, ['class' => 'form-control'] ) !!}
                    {!! Form::submit('ok', ['class' => 'btn blue btn-block']) !!}
                    {!! Form::close() !!}
                </div>

            </div>
        </div>
    </div>


    <table class="table table-hover sort_table">
        <thead>
        <th>Néve</th>
        <th></th>
        <th></th>

        </thead>
        <tbody>
        @foreach($slides as $slide)
            <tr>
                <td>{{$slide->title}}</td>
                <td>
                    @if($slide->adminIndexImageUrl('image', '100_50_') == '' )
                        File elérési hiba ( {{$slide->file_dir . $slide->image}} )
                    @else
                        <img class="ctud_table_img" src="{{url($slide->adminIndexImageUrl('image', '100_50_'))}}" alt="">
                    @endif
                </td>
                <td>
                    <button type="button"
                            class="btn btn_action @if(in_array($slide->id, $my_slide->toArray()))red-sunglo  @else green-meadow @endif"
                            id="slide_{{$slide->id}}"
                            data-gallery-id="{{$gallery_id}}"
                            data-slide-id="{{$slide->id}}"
                    >
                        @if(in_array($slide->id, $my_slide->toArray()))Eltávolít @else Hozzáad @endif

                    </button>
                </td>

            </tr>
        @endforeach

        </tbody>
    </table>

    {{$slides->render()}}
@endsection

@push('scripts_code')
<script>
    $('.btn_action').click(function(){
        //
        var action = 'attach';
        if($(this).hasClass('red-sunglo')){
            action = 'detach';
        }

        var formData = {
            gallery_id: $(this).attr('data-gallery-id'),
            slide_id: $(this).attr('data-slide-id'),
            action : action,
        };

        $.ajax({
            method: "POST",
            data: formData,
            url: "{{url('/admin/add_slide_to_gallery')}}",
            success: function(response, status, xhr) {
                var btn = $('#slide_'+formData['slide_id']);
                if(btn.hasClass("green-meadow")){
                    btn.removeClass("green-meadow");
                    btn.addClass("red-sunglo")
                    btn.html("Eltávolít");
                    notification('Hozzáadtad' );
                }else{
                    btn.removeClass("red-sunglo");
                    btn.addClass("green-meadow")
                    btn.html("Hozzáad");
                    notification('Sikeres törlés' );
                }
            },
            error: function(xhr, status, error) {
                notification('Hiba', 'warning');
            }
        });

    });
</script>
@endpush