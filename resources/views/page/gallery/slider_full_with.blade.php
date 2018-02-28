@if(isset($item->gallery_id))


<div class="camera_container">
    <div id="camera" class="camera_wrap">

        @php
        $gallery = \App\Model\Gallery::find($item->gallery_id)
        @endphp
        @if(!empty($gallery))
        @foreach($gallery->slides as $slide)

            <div data-src="{{$slide->getImageThumbUrl('image', '2050_550_')}}">
                <div class="camera_caption fadeIn">
                    <h2>{!!  $slide->contentLang() !!} </h2>
                </div>
            </div>
        @endforeach
        @endif


    </div>
</div>
@endif