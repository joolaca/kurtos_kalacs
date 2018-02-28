@if(isset($items))
    <section class="well center767" id="{{$slug or ''}}">
        <div class="container">
            <div class="row">
                @foreach($items as $key=>$item)

                    <div class="col-md-2 col-sm-4 col-xs-6 wow fadeInUp"  data-wow-delay="0.{{$key}}s">
                        @if(isset($item->slide))
                        <img src="{{$item->slide->getImageThumbUrl('image', '370_290_')}}" alt="">
                        @endif
                            <h6><a href="{{url($item->href or '')}}">{{$item->title or ''}}</a></h6>
                            <p class="l-height">{!! $item->content or ''!!}</p>

                    </div>
                @endforeach

            </div>
        </div>
    </section>

@endif
