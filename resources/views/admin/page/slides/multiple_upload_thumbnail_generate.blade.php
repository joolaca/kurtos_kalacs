@extends('admin.layouts.admin_layout')

@section('content')

    <h1>Thumbnail generálás</h1>
    <h3>Kérem ne zárja be az ablakot amíg nem készül el mindegyik</h3>
    <div class="row">
    @foreach($slides as $slide)
        <div class="row">

            <div class="col-md-4">
                <a href="{{url('/admin/slides/'.$slide->id.'/edit')}}"
                   target="_blank">
                    Edit:   {{$slide->image}}
                </a>

            </div>
            <div class="col-md-5">

                <a href="{{url('/admin/crop_image/'.$slide->id.'/image/'.encrypt('\App\Model\Slide'))}}"
                   target="_blank">
                    crop:  {{$slide->file_dir . $slide->image}}
                </a>
            </div>
            <div class="col-md-1">
                <i class="fa fa-spinner fa-pulse fa-3x fa-fw" id="spinner_{{$slide->id}}"></i>
                <span class="sr-only">Loading...</span>

                {{--<i class="fa fa-check fa-3x " aria-hidden="true"></i>--}}
            </div>

        </div>

    @endforeach
    </div>


@endsection




@push('scripts_code')
<script>

    $(document).ready(function() {
        generateSlideThumbnail();
    });

    var check_slide = 0;  // ahogy megy végig a slide okon ezt növeli
    var sum_slide = {!! count($slides) !!};
    var slides = {!! json_encode($slides) !!};

    //Végigmegy a slides tömben lévő képeken egymás után legenerálja a thumbnaileket
    function generateSlideThumbnail() {
    if (check_slide >= sum_slide) { return }

    $.ajax({
        method: "POST",
        data: slides[check_slide],
        async: true,
        url: url_prefix+"/admin/slides/generate_slide_thumbnail",
        dataType: "json",
        success: function(data) {
            if (check_slide < sum_slide) {
                $('#spinner_'+slides[check_slide]['id']).attr('class', 'fa fa-check fa-3x ');
                ++check_slide;
                generateSlideThumbnail();
            }
        },
        error: function(xhr, status, error) {
            console.log("error");
        }
    });

    }

</script>
@endpush