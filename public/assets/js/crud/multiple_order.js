$(document).ready(function() {

    $( "#crudform" ).submit(function( event ) {

        $('#crudform .select_to').each( function() {

            var name = $(this).attr('id');
            $(this).find('option').each(function(){
                $( "#crudform" ).append('<input type="hidden" name="'+name+'[]" value="'+$(this).val()+'">')
            })

        });

    });

    $('.btn_add').click(function(){
        var btn = $(this);
        $(this).parents('.sco_container').find('.select_from option').filter(':selected').each( function() {
            btn.parents('.sco_container').find('.select_to')
                .append("<option value='"+$(this).val()+" '>"+$(this).text()+"</option>");
            $(this).remove();
        });

    });

    $('.btn_remove').click(function(){
        var btn = $(this);
        $(this).parents('.sco_container').find('.select_to option').filter(':selected').each( function() {
            btn.parents('.sco_container').find('.select_from')
                .append("<option value='"+$(this).val()+" '>"+$(this).text()+"</option>");
            $(this).remove();
        });

    });
    $('.btn_up').bind('click', function() {

        var select_to_option = $(this).parents('.sco_container').find('.select_to option');
        select_to_option.filter(':selected').each( function() {
            var newPos = select_to_option.index(this) - 1;
            if (newPos > -1) {
                select_to_option.eq(newPos).before("<option value='"+$(this).val()+"' selected='selected'>"+$(this).text()+"</option>");
                $(this).remove();
            }
        });
    });
    $('.btn_down').bind('click', function() {
        var select_to_option = $(this).parents('.sco_container').find('.select_to option');
        var countOptions = select_to_option.size();
        select_to_option.filter(':selected').each( function() {
            var newPos = select_to_option.index(this) + 1;
            if (newPos < countOptions) {
                select_to_option.eq(newPos).after("<option value='"+$(this).val()+"' selected='selected'>"+$(this).text()+"</option>");
                $(this).remove();
            }
        });
    });

    $('.search_from').bind('change keyup', function() {
        var search = $.trim($(this).val());
        var regex = new RegExp(search,'gi');

        var select_from_option = $(this).parents('.sco_container').find('.select_from option');

        select_from_option.each(function($i){
                $(this).css('opacity' , 1);
                $(this).css('position' , 'initial');
                $(this).css('z-index' , 'initial');

        });


        select_from_option.each(function($i){
            if($(this).text().match(regex) == null){
                $(this).css('opacity' , 0);
                $(this).css('position' , 'absolute');
                $(this).css('z-index' , -1);
            }
        });

    });

});