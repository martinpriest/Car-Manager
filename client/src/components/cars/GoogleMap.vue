<template>
    <div id="map" class="car-profile-box"></div>
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
    height: 90%;  /* The height is 400 pixels */
    border-radius: 5px;
    margin: 10px;
}
</style>