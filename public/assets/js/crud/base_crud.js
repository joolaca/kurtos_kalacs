$(document).ready(function() {

    //Bootstrap switch
    $("input[type='checkbox']").bootstrapSwitch({
        onText: "Igen",
        offText: "Nem",
    });
    $("input[type='checkbox']").on('switchChange.bootstrapSwitch', function (e, data) {

        if($(this).val() == 1){
            $(this).val(0);
        }else{
            $(this).val(1);
        }
    });


    //Select2
    $(".select_").select2({ width: 'auto' });


    //TinyMCE
    if($('.tinymce').length) {
        tinymce.init({
            selector: 'textarea.tinymce',
			entity_encoding : "raw",
			relative_urls: false,
			remove_script_host : true,
			verify_html: false,
			plugins : 'link lists advlist code media image table paste',
            toolbar: [
                'undo redo | styleselect | bold italic | bullist numlist | image media link  | slide video gallery document_href | alignleft aligncenter alignright | code'
            ],
			fix_list_elements : true,
            paste_as_text: true,
            extended_valid_elements : "gallery",
            custom_elements: "gallery",
            content_css: "/css/editor.css, /assets/metronic/global/plugins/font-awesome/css/font-awesome.min.css",
            image_class_list: [
                {title: 'Formázatlan', value: ''},
                {title: 'img-inlineblock-rightm', value: 'img-inlineblock-rightm'},
                {title: 'img-inlineblock-leftm', value: 'img-inlineblock-leftm'},
                {title: 'img-fleft', value: 'img-fleft'},
                {title: 'img-fright', value: 'img-fright'}
            ],
            setup: function(editor){

                editor.addButton('slide', {
                    title: 'Kép beszúrása',
                    icon: 'editimage',
                    onclick: function () {

                        var modalframe = $("#modalframe");

                        modalframe.html('');
                        modalframe.attr({'src':'/slides/modal'});
                        modalframe.attr({'data-callback': 'insertSlideToEditor'});

                        $("#edit_modal").modal('show');

                    }
                });

                editor.addButton('video', {
                    title: 'Videó beszúrása',
                    icon: 'upload',
                    onclick: function () {

                        var modalframe = $("#modalframe");

                        modalframe.html('');
                        modalframe.attr({'src':'/videos/modal'});
                        modalframe.attr({'data-callback': 'insertVideoToEditor'});

                        $("#edit_modal").modal('show');

                    }
                });

                editor.addButton('gallery', {
                    title: 'Képgaléria beszúrása',
                    icon: 'sun',
                    onclick: function () {

                        var modalframe = $("#modalframe");

                        modalframe.html('');
                        modalframe.attr({'src':'/galleries/modal'});
                        modalframe.attr({'data-callback': 'insertGalleriesToEditor'});

                        $("#edit_modal").modal('show');

                    }
                });

                editor.addButton('document_href', {
                    title: 'Dokumentum beszúrása hivatkozásként',
                    icon: 'newdocument',
                    onclick: function () {

                        var modalframe = $("#modalframe");

                        modalframe.html('');
                        modalframe.attr({'src':'/documents/modal'});
                        modalframe.attr({'data-callback': 'insertDocumentsToEditor'});

                        $("#edit_modal").modal('show');

                    }
                });


            }
        });
    }

    $('input.datetimepicker').datetimepicker({
        timeFormat: 'HH:mm:ss' ,
        dateFormat: 'yy-mm-dd'
    });

    $('input.datepicker').datepicker({
        dateFormat: 'yy-mm-dd'
    });

    //Sortable table
	if($("tbody.sortable")) {
		$("tbody.sortable").sortable({
			axis: "y",

			update: function (event, ui) {
				var formData = {
					data: $(this).sortable('toArray', {attribute: 'data-id'}),
					type: $(this).data('type')
				};
				// POST to server using $.post or $.ajax
				$.ajax({
					data: formData,
					type: 'POST',
					url: url_prefix+'/ajax/saveOrder'
				});
			}
		});
	}

    //daterangepicker
    var date = new Date();
    $('input.daterange').daterangepicker({
        timePicker: true,
        timePickerIncrement: 15,
        timePicker24Hour: true,
        locale: {
            format: 'YYYY-MM-DD H:mm'
        },
        // startDate: new Date(date.getFullYear(), date.getMonth(), 1 , 0 ,0)
    });

    $('[data-toggle="tooltip"]').tooltip();
    $(".input_info_popover").popover();



    $(".editable-text").each(function(){

		setUpEditable($(this));

    });

    //törlés gomb /formokra/
    $(".notification_delete").submit(function(e){
        e.preventDefault();
        var form = $(this);
        swal({
            title: "Biztosan törli?",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Igen!",
            cancelButtonText: "Mégsem!",
            closeOnConfirm: true,
            closeOnCancel: true
        },
        function(isConfirm){
            if (isConfirm) {

                form[0].submit();

            }
        });

    });

    $('body').delegate('#edit_modal', 'click', function(){

        $(this).on('hidden.bs.modal', function () {

            $(this).find('iframe').attr({'src':''});

        });

    });

    if($(".clipboard").length > 0){

        var clipboard = new Clipboard('.clipboard');

        clipboard.on('success', function(e) {
            notification("Vágólapra másolva!");
        });

    }

    $("body").delegate('a.delete_file', 'click', function(event){
        event.preventDefault();

        var element = $(this);

        swal({
                title: "Biztosan törli?",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Igen!",
                cancelButtonText: "Mégsem!",
                closeOnConfirm: true,
                closeOnCancel: true
            },
            function(isConfirm){
                if (isConfirm) {
                    //ajax
                    $.ajax({
                        method: "POST",
                        url: element.data('href'),
                        data: {model: element.data('model')},
                        dataType: "json",
                        success: function(data) {
                            element.parents(element.data("parent_container")).remove();
                            //az input[file]-t aktiváljuk.
                            $('.image_upload_container').find('input').prop('disabled', false).prop('readonly', false);
                            notification(data.message);
                        },
                        error:function(xhr, status, error){
                            var data = $.parseJSON(xhr.responseText);
                            notification(data.message, 'error');
                        }

                    });

                }
            });
    });

});


//=========== FUNCTIONS ===========================
//=================================================
$.fn.inputtags = function (options) {

    var defaults = $.extend({}, {
        //ajax_url: set in field php
        minLength: 3,
        highlight: true,
        displayKey: 'name',
        valueKey: 'name',
    }, options);

    var main_element = $(this).parent();

    var tags = new Bloodhound({
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        datumTokenizer: Bloodhound.tokenizers.whitespace,
        prefetch: {
            url: defaults.ajax_url,
            cache: false
        },
        remote: {
            url: defaults.ajax_url,
            prepare: function (query, settings) {
                settings.type = "GET";
                settings.data = {keyword: main_element.find('.tt-input').val()};
                return settings;
            },
            filter: function (data) {
                return data.keywords;
            }
        }
    });

    $(this).tagsinput({
        typeaheadjs: [{
            minLength: defaults.minLength,
            highlight: defaults.highlight
        },
            {
                displayKey: defaults.displayKey,
                valueKey: defaults.valueKey,
                source: tags.ttAdapter()
            }]
    });

};

function notification(message, message_type, title, params){

    switch (message_type){

        case "success":
        case "info":
        case "warning":
        case "error":
            break;
        default:
            message_type = "success";

    }

    var options = $.extend(params,{
        "debug": false,
        "newestOnTop": false,
        "progressBar": true,
        "positionClass": "toast-top-full-width",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "7000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    });

    toastr[message_type](title, message, options);

}

function setUpEditable(field) {
	$(field).editable({
		validate: function(value) {
			if($.trim(value) == '') {
				return 'Kötelező mező';
			}
		},
		emptytext: $(field).data("placeholder") + " mező"
	});
}
