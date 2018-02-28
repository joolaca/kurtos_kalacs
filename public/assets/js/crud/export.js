$(document).ready(function() {
    $("#export_crud").click(function () {


        var url = updateQueryStringParameter(document.location.href, "export", true);


        document.location = url;
    });

    // hozzáad vagy lecserél egy url paramétert
    function updateQueryStringParameter(uri, key, value) {
        var re = new RegExp("([?&])" + key + "=.*?(&|$)", "i");
        var separator = uri.indexOf('?') !== -1 ? "&" : "?";
        if (uri.match(re)) {
            return uri.replace(re, '$1' + key + "=" + value + '$2');
        }
        else {
            return uri + separator + key + "=" + value;
        }
    }

});