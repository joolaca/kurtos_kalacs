@extends('admin.layouts.admin_layout')
@section('content')
    <h1 class="page-title">Index Oldalak szerkesztése
        {!! Form::open(['url' => '/admin/change_index_edit_lang', 'method'=> 'GET']) !!}
        {!! Form::select('lang',
            \App\Model\Lang::all()->pluck('lang','lang'),
            session('index_edit_lang'),
            [   'onchange' => "$(this).closest('form').trigger('submit')" ,
                'class' =>'',
            ] )
        !!}
        {!! Form::close() !!}
    </h1>

    <nav>

        <a href="#mini_description_container" class="col-md-4">
            mini_description <br>
            <img src="{{url('/assets/admin/index_page_menu/mini_description.jpg')}}" width="100%">
        </a>
        <a href="#image_list_little_container"  class="col-md-4">
            image_list_littlebr <br>
            <img src="{{url('/assets/admin/index_page_menu/image_list_little.jpg')}}" width="100%">
        </a>
        <a href="#mini_description_container" class="col-md-4">
            mini_description
            <img src="{{url('/assets/admin/index_page_menu/mini_description.jpg')}}" width="100%">
        </a>
        <a href="#long_description_content_right_container" class="col-md-4">
            long_description_content_right
            <img src="{{url('/assets/admin/index_page_menu/long_description_content_right.jpg')}}" width="100%">
        </a>
        <a href="#long_description_content_left_container" class="col-md-4">
            long_description_content_right
            <img src="{{url('/assets/admin/index_page_menu/long_description_content_left.jpg')}}" width="100%">
        </a>
        <a href="#2_button_container" class="col-md-4">
            2_button
            <img src="{{url('/assets/admin/index_page_menu/2_button.jpg')}}" width="100%">
        </a>
        <a href="#slogen_container" class="col-md-4">
            slogen
            <img src="{{url('/assets/admin/index_page_menu/slogen.jpg')}}" width="100%">
        </a>



    </nav>




    @include('admin/index_page/gallery_select_section',[
        'item' => isset($index_sections['slider_full_with'][0]) ? $index_sections['slider_full_with'][0] : [],
        'slug' => 'slider_full_with',
        'title' => ' Index oldal Slidere ',
    ])

    @include('admin/index_page/gallery_select_section',[
        'item' => isset($index_sections['bootstrap_gallery'][0]) ? $index_sections['bootstrap_gallery'][0] : [],
        'slug' => 'bootstrap_gallery',
        'title' => 'Bootstrap gallery',
    ])

    @include('admin/index_page/section_edit', [
        'index_section_elements' => isset($index_sections['mini_description']) ? $index_sections['mini_description'] : [],
        'title' => 'Kép Cím szöveg link',
        'slug' => 'mini_description'
    ])

    @include('admin/index_page/section_edit', [
        'index_section_elements' => isset($index_sections['image_list_little']) ? $index_sections['image_list_little'] : [],
        'title' => 'Kisképes lista',
        'slug' => 'image_list_little'
    ])

    @include('admin/index_page/section_edit', [
        'index_section_elements' => isset($index_sections['long_description_content_right']) ? $index_sections['long_description_content_right'] : [],
        'title' => 'Hosszú leírás tartalom JOBB oldalon',
        'slug' => 'long_description_content_right'
    ])


    @include('admin/index_page/section_edit', [
        'index_section_elements' => isset($index_sections['long_description_content_left']) ? $index_sections['long_description_content_left'] : [],
        'title' => 'Hosszú leírás tartalom BAL oldalon',
        'slug' => 'long_description_content_left'
    ])
    @include('admin/index_page/section_edit', [
        'index_section_elements' => isset($index_sections['2_button']) ? $index_sections['2_button'] : [],
        'title' => 'Két gombos leírás',
        'slug' => '2_button'
    ])
    @include('admin/index_page/section_edit', [
        'index_section_elements' => isset($index_sections['slogen']) ? $index_sections['slogen'] : [],
        'title' => 'Szlogen',
        'slug' => 'slogen'
    ])


    @include('admin/modal/select_slide_modal')

@endsection




