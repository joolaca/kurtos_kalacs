

<style>
    #map {
        height: 400px;
        width: 100%;
    }
</style>
<script>
    function initMap() {
        var uluru = {lat: 47.5790193, lng: 19.048907};
        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 15,
            center: uluru
        });
        var marker = new google.maps.Marker({
            position: uluru,
            map: map
        });
    }
</script>


<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDVpv-AS8Rosj_BLEKzVqszDXI7Y7httug&callback=initMap">
</script>

<section class="well4 text-center">
    <div class="container">
        <div class="row col-12_mod">
            <div id="map"></div>
        </div>
    </div>
</section>

@push('script_src')

@endpush