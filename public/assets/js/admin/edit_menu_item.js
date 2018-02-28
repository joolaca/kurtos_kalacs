
$(document).ready(function(){
    // attach_content_porlet.blade.php

    //Ezt majd folytatni kell ha ajaxosan szeretnék majd menteni.
    $( ".attach_content_btn" ).on( "click", function() {
        return '';

        var send_data = $(this).closest('.attach_content_container').serializeArray();

        $.ajax({
            method: "POST",
            url: '/admin/attach_content',
            data: send_data,
            dataType: "json",
            success: function(data) {
                // element.parents(element.data("parent_container")).remove();
                //az input[file]-t aktiváljuk.
                // $('.image_upload_container').find('input').prop('disabled', false).prop('readonly', false);
                // notification(data.message);

                // Beszúrjuk a hozzárendeltekhez
                var form = $('#clone_attach_form').last();
                var clone_form = cloneForm(form, send_data, 'attach');
                $( "#belongs_to_container" ).append( clone_form );

                //Töröljük a hozzárendelhető modulok közül
                var html_id = getSerializeValue('html_id',send_data);
                html_id.remove();

                notification(data);
            },
            error:function(xhr, status, error){
                var data = $.parseJSON(xhr.responseText);

                notification(data.message, 'error');
            }

        });


    });

    // Menu.php renderOtherMenuButtons() állítja elő
    $(".menu_change_sequence").on( "click", function() {

        var send_data = {
            "id" : $(this).data('menu-id'),
            "sequence" : $(this).data('menu-sequence'),
            "action" : $(this).data('action'),
        };
        console.log(send_data);
        $.ajax({
            method: "POST",
            url: '/ajax/change_menu_sequence',
            data: send_data,
            dataType: "json",
            success: function(data) {

                /*var row = $(this).parents("tr:first");
                if (data.action == "lift_up") {
                    row.insertBefore(row.prev());
                } else {
                    row.insertAfter(row.next());
                }*/

                location.reload();
                //notification(data.action);
            },
            error:function(xhr, status, error){
                var data = $.parseJSON(xhr.responseText);

                notification(data.message, 'error');
            }

        });
    });

    $( ".detach_content_btn" ).on( "click", function() {

        var send_data = $(this).closest('.detach_content_container').serialize();

        $.ajax({
            method: "POST",
            url: '/admin/detach_content',
            data: send_data,
            dataType: "json",
            success: function(data) {
                /*element.parents(element.data("parent_container")).remove();
                //az input[file]-t aktiváljuk.
                $('.image_upload_container').find('input').prop('disabled', false).prop('readonly', false);
                notification(data.message);*/


                notification(data);
            },
            error:function(xhr, status, error){
                var data = $.parseJSON(xhr.responseText);
                notification(data.message, 'error');
            }

        });


    });


    function getSerializeValue(key, serializeArray){
        var out = '';
        jQuery.each( serializeArray, function( i, field ) {
            if(field.name == key){
                out = field.value;
            }
        });
        return out;
    }

    function cloneForm(form,send_data, id_prefix) {
        var clone_form = form.clone(true);
        var id = id_prefix +'_' + getSerializeValue('slug', send_data)+ '###' + getSerializeValue('related_id', send_data);
        clone_form.attr('id', id);
        clone_form.find('label').first().html(getSerializeValue('title', send_data));
        clone_form.find('[name = related_id]').attr('value', getSerializeValue('related_id', send_data));
        clone_form.find('[name = menu_id]').attr('value', getSerializeValue('menu_id', send_data));
        clone_form.find('[name = html_id]').attr('value', getSerializeValue('html_id', send_data));
        clone_form.find('[name = model_class]').attr('value', getSerializeValue('model_class', send_data));
        return clone_form;
    }

});

