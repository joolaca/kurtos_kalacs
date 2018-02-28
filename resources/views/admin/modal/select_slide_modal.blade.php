<div class="modal fade" id="selectSlideModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">New message</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" class="form-control" id="target_element_id">

                <div class="form-group">
                    <label for="recipient-name" class="form-control-label">Kategoria</label>
                    <select name="category_id" id="slide_category_id">
                        <option value=""></option>
                        @foreach(\App\Model\Category::where('type','slide')->get() as $category)
                            <option value={{$category->id}}
                                @if($category->id == session('slide_category_id_modal')) selected @endif
                            >
                                {{$category->title}}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="row">
                @php
                    if(session()->has('slide_category_id_modal') && !empty(session('slide_category_id_modal'))){
                        $slides = \App\Model\Slide::where('category_id', session('slide_category_id_modal'))->get();
                    }else{
                        $slides = \App\Model\Slide::all();
                    }
                @endphp
                    <div id="select_slide_modal_element_container">
                        @foreach($slides as $slide)
                            @include('admin/modal/select_slide_modal_element', compact('slide'))
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@push('scripts_code')
<script>

    // ahol megnyitják a modált oda tölti vissza a képet
    $('#selectSlideModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var target_element_id = button.data('element-id') // Extract info from data-* attributes
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this)
        modal.find('.modal-body #target_element_id').val(target_element_id)
    })

    $('#select_slide_modal_element_container').on('click', '.select_slide', function(){
        var id = $('#target_element_id').val();
        console.log(id);
        console.log('slide-id',$(this).data('slide-id'));
        console.log('src',  $(this).attr('src'));
        $('#slide_hidden_id_'+id).val($(this).data('slide-id'));
        $('#selected_slide_'+id).attr('src', $(this).attr('src'));
        $('#selectSlideModal').modal('toggle');
    });


    // Kategória szúrés a képekre
    $('#slide_category_id').on('change', function(){

        var send_data = {
            category_id:  $(this).val(),
        };
        $.ajax({
            method: "POST",
            url: '/ajax/get_modal_slides',
            data: send_data,
            //dataType: "json",
            success: function(data) {
                $('#select_slide_modal_element_container').html(data);

            },
            error: function(xhr, status, error) {
            }
        });
    });

    $('#test').on('click',function(){

    });


</script>
@endpush