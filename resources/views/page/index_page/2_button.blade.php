@if(isset($item))
<section class="well1 bg-white center479">

    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-7 col-sm-12 col-xs-12 wow fadeInLeft">
                <h3>{{$item->title}}</h3>

                <p class="p_mod">{!! $item->content !!}</p>
            </div>
            <div class="col-lg-4 col-md-5 col-sm-6 col-xs-12 mg_add">
                <div class="row">
                    <div class="col-md-6 col-sm-6 col-xs-6 wow fadeInRight" data-wow-delay="0.2s">
                        <a href="{{$item->href}}" class="btn btn-default">{{__('page.about_us')}}</a>
                    </div>

                    <div class="col-md-6 col-sm-6 col-xs-6 off8 wow fadeInRight" data-wow-delay="0.4s">
                        <a href="{{$item->href2}}" class="btn btn-primary">{{__('page.click_here')}}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif