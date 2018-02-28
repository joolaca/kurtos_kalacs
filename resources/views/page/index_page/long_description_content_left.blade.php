@if(isset($item))
<section class="well2 bg-white center991" id="{{$slug or ''}}">
    <div class="container">
        <div class="row">
            <div class="col-md-5 col-sm-12 col-xs-12 wow fadeInLeft">
                @if(isset($item->slide)))
                <img src="{{$item->slide->getImageThumbUrl('image', '370_290_')}}" alt="{{$item->slide->titleLang()}}">
                @endif()
            </div>
            <div class="col-md-7 col-sm-12 col-xs-12">
                <h3>{{$item->title}}</h3>

                <p class="p_mod">{!! $item->content !!}</p>

                <a href="{{$item->href}}" class="btn btn-primary">{{__('page.click_here')}}</a>
            </div>
        </div>
    </div>
</section>
@endif