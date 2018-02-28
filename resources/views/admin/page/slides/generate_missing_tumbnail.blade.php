
<button class="btn btn-outline sbold blue pull-right" id="generate_missing_thumbnail">
    Hiányzó thumbnail generálás
</button>

@push('scripts_code')
<script>

    $( "#generate_missing_thumbnail" ).on( "click", function() {
        $.blockUI({ message: '<h1>Folyamatban!<br> Kérem ne zárja be az ablakot! <br></h1>' });
        $.ajax({
            method: "POST",
            data: {},
            url: url_prefix+"/ajax/generate_missing_thumbnail",
            dataType: "json",
            success: function(data) {
                $.unblockUI();
                notification("Kész");
            },
            error: function(xhr, status, error) {
                var data = $.parseJSON(xhr.responseText);
                notification(data.message, 'error');
            }
        });
    });
</script>
@endpush