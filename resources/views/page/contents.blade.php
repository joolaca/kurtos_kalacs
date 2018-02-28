@extends('layouts.web_layout')
@section('content')
    <section class="well well__ins center_xs">
    <div class="container content_contanier">
        @foreach($contents as $content)
            <section>
                {!! $content !!}
            </section>
        @endforeach
    </div>
    </section>
@endsection
