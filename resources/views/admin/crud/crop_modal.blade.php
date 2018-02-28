<div class="modal fade" >
    <div class="modal-dialog modal-lg" role="document">

        <form action="{!! $route !!}" method="POST">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title" id="myModalLabel">{{$crud_data['create_title'] or ""}}</h4>
            </div>
            <div class="modal-body row">

                <div class="col-md-6">
                    <img  src="{!! url($path) !!}" alt="" class="crop_main_image">
                </div>
                <div class="col-md-6">

                    <div class="row">
                        <div class="col-md-2"> Elérés </div>
                        <div class="col-md-10"> {!! $path !!}</div>
                    </div>
                    <div class="row">
                        <div class="col-md-2"> Prefix </div>
                        <div class="col-md-10"> {!! $size->prefix !!} </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2"> Méret </div>
                        <div class="col-md-10"> {!! $size->width !!} x  {!! $size->height !!}  </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-default" >OK</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Mégsem</button>
            </div>
        </div>

            <input type="hidden" size="4" class="x1" name="x1" />
            <input type="hidden" size="4" class="y1" name="y1" />
            <input type="hidden" size="4" class="w" name="w" />
            <input type="hidden" size="4" class="h" name="h" />
            <input type="hidden" name="path" value="{!! $path !!}">
            <input type="hidden" name="prefix" value="{!! $size->prefix !!}">
            <input type="hidden" name="_token" value="{!! csrf_token() !!}">

        </form>
    </div>



    <script>



        $('.crop_main_image').Jcrop({
            onChange:   showCoords,
            onSelect:   showCoords,
            boxWidth: 400,   //Maximum width you want for your bigger images
            boxHeight: 400,  //Maximum Height for your bigger images

            aspectRatio: {{ $size->width or 0 }}/ {{ $size->height or 0 }}
        });


        function showCoords(c)
        {

            $('.x1').val(c.x);
            $('.y1').val(c.y);
//            $('.x2').val(c.x2); // Nekünk nem kell
//            $('.y2').val(c.y2); //Nem kell
            $('.w').val(c.w);
            $('.h').val(c.h);
        };

    </script>

</div>