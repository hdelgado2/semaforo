<template>
    <div>
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
        <l-map  @ready="doSomethingOnReady()"
            v-if="showMap"
            ref="map"
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
                <l-marker v-for="semaforo,index in semaforos"
                        :key="index+1" 
                        :item="semaforo"
                        :lat-lng="calculateLatlng(semaforo.lat, semaforo.lng)" 
                        ref="marker">
                         <l-icon
                            :icon-size="dynamicSize"
                            :icon-anchor="dynamicAnchor"
                            :icon-url="iconUrl"
                        />
                </l-marker>
        </l-map>
    </div>
    </div>
</template>


<script>

import { latLng, Icon } from "leaflet";

export default {

        props:{
            semaforicos: Array,
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
                iconSize: 50,
                popupAnchor: [0, -40],
                iconUrl: require('leaflet/dist/images/marker-icon.png'),
                //markers: [],
                semaforos: [
                     latLng(11.7102521, -70.4838664),
                     latLng(11.7102521, -70.1838662),
                     latLng(11.7102521, -40.4838661),
                 ],

                intersecciones: [],
            };

        },

         mounted() {

            console.log(this.$refs.map)


            this.$nextTick(() => {
                console.log('ss')
                //this.$refs.map.mapObject._onResize();
                //this.$refs.map.mapObject.ANY_LEAFLET_MAP_METHOD();
                
            });

            delete Icon.Default.prototype._getIconUrl;
            Icon.Default.mergeOptions({
                iconRetinaUrl: require('leaflet/dist/images/marker-icon-2x.png'),
                iconUrl: require('leaflet/dist/images/marker-icon.png'),
                shadowUrl: require('leaflet/dist/images/marker-shadow.png'),
            });

            
        },

        computed: {
            dynamicSize() {
                return [this.iconSize, this.iconSize * 1];
            },
            dynamicAnchor() {
                return [this.iconSize / 2, this.iconSize * 1];
            },
        },
        methods: {

            calculateLatlng(lat, lng){
               return latLng(lat,lng);
            },

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

                let newSemaforo = {
                    lat : event.latlng.lat,
                    lng : event.latlng.lng
                }

                this.intersecciones.push(newSemaforo)

                //this.semaforos.length = 0;

                this.$refs.map.mapObject.addMarker(newSemaforo)

                //this.semaforos = this.intersecciones



                //console.log('as')
                //this.semaforos.push(event.latlng)
                  

            },

            trafficlightLocation(location) {
                return location;
                //const trafficlightOnTheMap = [].concat(location).reverse();
                //return latLng(trafficlightOnTheMap);
            },

            trafficlightIcon(status) {

                if (status === 1) {
                    return 'locationFree';
                } else if (status === 2) {
                    return 'locationBusy';
                } else {
                    return 'locationUse';
                }
            },

    
            }
}   
</script>
