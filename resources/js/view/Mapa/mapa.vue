<template>
    <div style="height: 800px; width: 100%">
        <div style="height: 200px; overflow: auto;">
            <p>First marker is placed at {{ withPopup.lat }}, {{ withPopup.lng }}</p>
            <p>Center is at {{ currentCenter }} and the zoom is: {{ currentZoom }}</p>
            <button @click="showLongText">
                Toggle long popup
            </button>
            <button @click="showMap = !showMap">
                Toggle map
            </button>
        </div>
        <div class="info" style="height: 15%">
            <span>Center: {{ center }}</span>
            <span>Zoom: {{ zoom }}</span>
            <span>Bounds: {{ bounds }}</span>
        </div>
        <l-map ref="myMap" @ready="doSomethingOnReady()"
            v-if="showMap"
            :zoom="zoom"
            :center="center"
            :options="mapOptions"
            style="height: 80%;width: 100%"
            @update:zoom="zoomUpdated"
            @update:center="centerUpdated"
            @update:bounds="boundsUpdated"
            @click="addMarker"
        >
            <l-tile-layer :url="url" :attribution="attribution">
            </l-tile-layer>
                <l-marker v-for="marker,index in markers" 
                        :key="index" 
                        :lat-lng="marker" 
                        ref="marker"
                        @click="removeMarker(index)">
                    <l-popup>
                        <div @click="innerClick">
                            I am a popup
                            <p v-show="showParagraph">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque
                                sed pretium nisl, ut sagittis sapien. Sed vel sollicitudin nisi.
                                Donec finibus semper metus id malesuada.
                            </p>
                        </div>
                    </l-popup>
                </l-marker>
        </l-map>
    </div>
</template>


<script>

import { latLng, Icon } from "leaflet";

export default {

        mounted() {
            console.log(this.$refs.myMap)
            console.log(this.$refs.myMap.mapObject)
             this.$nextTick(() => {
                console.log('ss')
                //this.$refs.myMap.mapObject.ANY_LEAFLET_MAP_METHOD();
            });

            delete Icon.Default.prototype._getIconUrl;
            Icon.Default.mergeOptions({
                iconRetinaUrl: require('leaflet/dist/images/marker-icon-2x.png'),
                iconUrl: require('leaflet/dist/images/marker-icon.png'),
                shadowUrl: require('leaflet/dist/images/marker-shadow.png'),
            });

            console.log('montado');
        },
        data(){
            return {
                url: 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
                attribution:'&copy; <a target="_blank" href="http://osm.org/copyright">OpenStreetMap</a> contributors',
                zoom: 13,
                center: [11.7102521, -70.1838664],
                bounds: null,
                withPopup: latLng(11.7102521, -70.4838664),
                withTooltip: latLng(47.41422, -1.250482),
                currentZoom: 11.5,
                currentCenter: latLng(47.41322, -1.219482),
                showParagraph: false,
                mapOptions: {
                    zoomSnap: 0.5
                },
                showMap: true,

                markers: [
                    latLng(11.7102521, -70.4838664),
                    latLng(11.7102521, -70.4838662),
                    latLng(11.7102521, -70.4838661),
                ]
            };

            },methods: {
                doSomethingOnReady() {
                    this.map = this.$refs.myMap.mapObject
                },
                zoomUpdated (zoom) {
                    this.zoom = zoom;
                },
                centerUpdated (center) {
                    this.center = center;
                },
                boundsUpdated (bounds) {
                    this.bounds = bounds;
                },
                removeMarker(index) {
                    this.markers.splice(index, 1);
                },
                addMarker(event) {
                    console.log(event)
                    console.log('evento');
                    this.markers.push(event.latlng);
                    

                }
    
            }
}   
</script>
