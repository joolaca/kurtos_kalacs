var UINestable = function () {

    var updateOutput = function (e) {
        var list = e.length ? e : $(e.target),
            output = list.data('output');
        if (window.JSON) {
            $('#nestable_list_1_output').val(window.JSON.stringify(list.nestable('serialize'))); //, null, 2));
            console.log($('#nestable_list_1').data('type'));
            var formData = {
                menus: window.JSON.stringify(list.nestable('serialize')),
                type: $('#nestable_list_1').data('type')
            }
            $.ajax({
                method: "POST",
                data: formData,
                url: "/saveMenu",
                dataType: "json",
				success: function(data) {
					if(data) {
						$.each(data, function(i, val) {
							$("#span_url_" + i).html(val);
						});
					}
                }
            });
        } else {
            output.val('JSON browser support required for this demo.');
        }
    };


    return {
        //main function to initiate the module
        init: function () {

            // activate Nestable for list 1
            $('#nestable_list_1').nestable({
                group: 2
            })
                .on('change', updateOutput);


            // output initial serialised data
            //updateOutput($('#nestable_list_1').data('output', $('#nestable_list_1_output')));

            $('#nestable_list_menu').on('click', function (e) {
                var target = $(e.target),
                    action = target.data('action');
                if (action === 'expand-all') {
                    $('.dd').nestable('expandAll');
                }
                if (action === 'collapse-all') {
                    $('.dd').nestable('collapseAll');
                }
            });


        }

    };

}();

jQuery(document).ready(function() {
   UINestable.init();


    $('#nestable_list_1').on('click', 'button', function(e) {
        var target = $(e.currentTarget);
        action = target.data('action');
        item = target.parent();
        console.log(item.data('id'));

        if (action === 'collapse') {
            //console.log('collapse');
            changeState(item.data('id'), 'collapse')
        }
        if (action === 'expand') {
            //console.log('expand');
            changeState(item.data('id'), 'expand')
        }
    });
});

function changeState(id, action)
{
    var formData = {
        id: id,
        action: action,
    };

    $.ajax({
        method: "POST",
        data: formData,
        url: url_prefix+"/ajax/frontendMenuItem/changeState",
        //dataType: "json",
        success: function(data) {

        },
        error: function(xhr, status, error) {
        }

    });
}