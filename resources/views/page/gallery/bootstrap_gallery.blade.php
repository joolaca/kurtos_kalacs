@if(isset($item->gallery_id))
    @php $gallery= \App\Model\Gallery::find($item->gallery_id);  @endphp
<section class="well4 text-center">
    <div class="container">
        <h3 class="clr-default text-center">{{$gallery->title}}</h3>
        <div class="row col-4_mod">

            @foreach($gallery->slides as $slide)
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <a class="thumb" href="{{$slide->getImageThumbUrl('image', '')}}">
                        <img src="{{$slide->getImageThumbUrl('image', '370_290_')}}" alt=""/>
                        <span class="thumb_overlay"></span>
                    </a>
                </div>
            @endforeach

        </div>

        <a href="{{url('/'.$item->href)}}" class="btn btn-primary off2">{{__('page.click_here')}}</a>
    </div>
</section>
@endif