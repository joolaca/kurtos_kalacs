{{--a hozzá tartozó js a /public/assets/js/admin/edit_menu_item.js található--}}
<div class="row">
<div class="col-md-12">
    <div class="col-md-6">
        <h3>Hozzárendelhető modulok</h3>


        @foreach($items_from as $item)

            <form class="attach_content_container"
                  id="attach_{{$item->slug.'###'.$item->id}}"
                  method="post"
                  action="/admin/attach_content"
            >
                <label >{{$item->title}}</label>
                <select name="type" id="">
                    @foreach($item->getAttachType() as $key=>$label)
                        <option value="{{$key}}">{{$label}}</option>
                    @endforeach
                </select>
               @include('admin/crud/menu/edit/attach_hidden_input', array_merge($item->toArray(), ['html_id_prefix' => 'attach']))
                <button class="attach_content_btn">+</button>
            </form>
        @endforeach

    </div>

    <div class="col-md-6" id="belongs_to_container">
        <h3>Hozzárendelt</h3>

        @foreach($items_to as $item)
            <form class="detach_content_container"
                  id="detach_{{$item->slug.'###'.$item->id}}"
                  method="post"
                  action="/admin/detach_content"

            >
                <label>{{$item->title}}</label>
                @include('admin/crud/menu/edit/attach_hidden_input', array_merge($item->toArray(), ['html_id_prefix' => 'detach']))
                <button class="detach_content_btn">-</button>
            </form>
        @endforeach

    </div>
</div>
</div>



