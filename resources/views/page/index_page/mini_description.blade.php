@if(isset($items))
<section class="well center991" id="{{$slug or ''}}">
    <div class="container">
        <div class="row">

            @foreach($items as $key => $item)
            @php
                $fade_class = '';
                switch ($key % 2) {
                    case 0:
                    $fade_class = 'fadeInDown';
                        break;
                    case 1:
                    $fade_class = 'fadeInUp';
                        break;
                    /*case 2:
                    $fade_class = 'fadeInRight col-md-offset-0 col-sm-offset-3';
                        break;
                    */
                }
            @endphp




            <div class="col-md-4 col-sm-6 col-xs-12 wow {{$fade_class}} {{$slug}}_box">
                @if(isset($item->slide))
                    <img src="{{$item->slide->getImageThumbUrl('image', '370_290_')}}" alt="{{$item->slide->titleLang()}}">
                @endif

                <h4><strong><a href="{{$item->href}}">{{$item->title}}</a></strong></h4>

                <p>{!! $item->content !!} </p>

                <br>
                <a href="{{$item->href}}" class="btn-link">{{__('page.read_more')}} >></a>



            </div>
            @endforeach


        </div>
    </div>
</section>

@endif

