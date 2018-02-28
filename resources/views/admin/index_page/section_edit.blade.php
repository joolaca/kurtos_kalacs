<section class="row" id="{{$slug}}_container">
    <div class="col-md-12">

        <div class="portlet box blue-hoki">
            <div class="portlet-title">
                <div class="caption">
                    {{$title}}
                </div>
            </div>


            <div class="portlet-body form">

                @if(isset($index_section_elements) )
                    @foreach($index_section_elements as $item)
                        @include('admin/index_page/element', $item)
                    @endforeach
                @endif
                @include('admin/index_page/new_element', ['type' => $slug])
            </div> {{--portlet-body--}}
        </div> {{--portlet box blue-hoki--}}

    </div>
</section>