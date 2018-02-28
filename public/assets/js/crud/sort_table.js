/* -----------------------------------------
 *  crudoknál az index résznél rendezhető táblák generálásához
 ------------------------------------------*/

$(document).ready(function() {

    /**
     * Keresési paraméterekkel kiegészíti az url-t és újratölti az oldalt
     */
    $( ".sorting" ).click(function() {
        var sort = $(this).attr('data-sort-field')
        var direction = 'asc';
        if($(this).hasClass('asc')){
            direction = 'desc';
        }

        var url = updateQueryStringParameter(document.location.href,"sort",sort);
        url = updateQueryStringParameter(url,"direction",direction);

        document.location = url;
    });

    //Visszaad egy url paramétert
    $.urlParam = function(name){
        var results = new RegExp('[\\?&]' + name + '=([^&#]*)').exec(window.location.href);
        if(results == null){
            return 0
        }else{
            return results[1]
        }
    }

    //direction paraméter alapján hozzáad egy classt - átkerült Field szintre
    /*if ($.urlParam('sort') != null) {
        var direction = 'asc';
        if($.urlParam('direction') == 'desc'){
            direction = 'desc';
        }

        $('[data-sort-field = "'+$.urlParam('sort')+'"]').addClass(direction)
    }*/

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
