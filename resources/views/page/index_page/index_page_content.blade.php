@extends('layouts.web_layout')
@section('content')

    @if(isset($index_sections['slider_full_with']))
        @include('page/gallery/slider_full_with', [
            'item' => $index_sections['slider_full_with'][0],
            'slug' => 'slider_full_with',
        ])
    @endif
    @if(isset($index_sections['mini_description']))
        @include('page/index_page/mini_description', [
            'items' => $index_sections['mini_description'],
            'slug' => 'mini_description',
        ])
    @endif
    @if(isset($index_sections['image_list_little']))
        @include('page/index_page/image_list_little', [
            'items' => $index_sections['image_list_little'],
            'slug' => 'image_list_little',
        ])
    @endif
    @if(isset($index_sections['long_description_content_right']))
        @include('page/index_page/long_description_content_right', [
            'item' => $index_sections['long_description_content_right'][0],
            'slug' => 'long_description_content_right',
        ])
    @endif
    @if(isset($index_sections['long_description_content_left']))
        @include('page/index_page/long_description_content_left', [
            'item' => $index_sections['long_description_content_left'][0],
            'slug' => 'long_description_content_left',
        ])
    @endif

    @if(isset($index_sections['bootstrap_gallery']))
        @include('page/gallery/bootstrap_gallery', [
            'item' => $index_sections['bootstrap_gallery'][0],
            'slug' => 'bootstrap_gallery',
        ])
    @endif
    @if(isset($index_sections['2_button']))
        @include('page/index_page/2_button', [
            'item' => $index_sections['2_button'][0],
            'slug' => '2_button',
        ])
    @endif
    @if(isset($index_sections['2_button']))
        @include('page/index_page/slogen', [
            'item' => $index_sections['slogen'][0],
            'slug' => 'slogen',
        ])
    @endif



@endsection