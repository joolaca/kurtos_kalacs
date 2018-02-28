@if(isset($item))
    <section class="parallax well3 text-center"
             data-url="{{isset($item->slide) ? $item->slide->getImageThumbUrl('image', '2050_550_'): ''}}"
             data-mobile="true">
        <div class="container">
            <h2 class="wow fadeIn"><strong>
                    <em>{!! $item->content !!}
                    </em>
                </strong></h2>
        </div>
    </section>
@endif