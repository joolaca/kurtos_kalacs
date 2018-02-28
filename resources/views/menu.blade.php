<div id="stuck_container" class="stuck_container">
    <div class="container">

        <nav class="navbar navbar-default navbar-static-top ">

            <ul class="navbar-nav sf-menu navbar-left" data-type="navbar">
                <li>
                    <a href="/">
                        <img style="max-width: 100px;" src="{{url('/images/logo.png')}}" alt="">
                    </a>
                </li>
                @foreach($menus as $menu)
                    @php $active = strpos($menu->slug, $full_url) !== false ? 'active' : ''; @endphp
                    <li ><a href="{{$menu->slug}}" class="{{$active}}">{{$menu->title}}</a></li>
                @endforeach

                <div class="change_lang_container">
                    {!! Form::open(['url' => '/change_lang', 'method'=> 'GET']) !!}
                    {!! Form::select('lang',
                        \App\Model\Lang::all()->pluck('lang','lang'),
                        session('lang'),
                        ['onchange' => "$(this).closest('form').trigger('submit')",
                        'class'=> 'select_brown',
                        ] )
                    !!}
                    {!! Form::close() !!}
                </div>

            </ul>


        </nav>

    </div>
</div>