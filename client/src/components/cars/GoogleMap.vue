<template>
<div>

    <div id="map"></div>
</div>
</template>
<script>
import {Loader} from 'google-maps';

export default {
    name: 'GoogleMap',
    created: function () {
        const options = {/* todo */};
        const loader = new Loader(`${process.env.VUE_APP_GOOGLE_API_KEY}`, options);
        var uluru = {lat: -25.344, lng: 131.036};
        loader.load().then(function (google) {
            const map = new google.maps.Map(document.getElementById('map'), {
                center: uluru,
                zoom: 8,
            });
            var marker = new google.maps.Marker({position: uluru, map: map});
            console.log(marker);
        });
    }
}
</script>

<style>
 #map {
        height: 350px;  /* The height is 400 pixels */
        width: 100%;  /* The width is the width of the web page */
       }
</style>