<template>
    <div>
        <div>
            <button @click="openModalRuta">Programar ruta</button>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="modalRuta" tabindex="-1" role="dialog" aria-labelledby="modalRutaLabel" aria-hidden="true">
          <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="modalRuta">Ruta</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                 <div class="map-container">
                    <l-map  @ready="doSomethingOnReady2()"
                        v-if="isReady2"
                        ref="map"
                        :zoom="zoom2"
                        :center="center2"
                        :options="mapOptions2"
                        style="height: 80%;width: 100%"
                        @update:zoom="zoomUpdated2"
                        @update:center="centerUpdated2"
                        @update:bounds="boundsUpdated2"
                        
                    >
                        <l-tile-layer :url="url2" :attribution="attribution2">
                        </l-tile-layer>

                        <l-marker v-for="semaforo,index in semaforos"
                            :key="semaforo.id" 
                            :item="semaforo"
                            :v-if="semaforo != null"
                            :lat-lng="calculateLatlng2(semaforo.latitud, semaforo.longitud)" 
                            ref="marker"
                            @click="addRuta(semaforo)"
                        >
                            <l-icon :class="semaforo.id"
                            :icon-size="dynamicSize2"
                            :icon-anchor="dynamicAnchor2"
                            :icon-url="iconUrl2"
                            
                            />
                            <l-tooltip :options="{ permanent: true, interactive: true }">
                                <div>
                                    {{ semaforo.interseccion }}
                                </div>
                            </l-tooltip>
                        </l-marker>
                    </l-map>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-outline-primary"><strong>Enviar</strong></button>
              </div>
            </div>
          </div>
        </div>
    </div>
</template>


<script>

import { latLng, Icon } from "leaflet";
import Swal from 'sweetalert2/dist/sweetalert2.js'

import 'sweetalert2/src/sweetalert2.scss'

export default {
        props:['semaforos'],
        data(){
            return {
                url2: 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
                attribution2:'&copy; <a target="_blank" href="http://osm.org/copyright">OpenStreetMap</a> contributors',
                zoom2: 13,
                center2: [11.7102521, -70.1838664],
                bounds2: null,
                withPopup2: latLng(11.7102521, -70.4838664),
                withTooltip2: latLng(47.41422, -1.250482),
                currentZoom2: 11.5,
                currentCenter2: latLng(47.41322, -1.219482),
                showParagraph2: false,
                mapOptions2: {
                    zoomSnap: 0.5
                },
                showMap2: false,
                iconSize2: 50,
                popupAnchor2: [0, -40],
                iconUrl2: require('leaflet/dist/images/marker-icon.png'),
                semaforos2: [],
                filtro2: '',

                isReady2 : false,
                editMode2 : false,

            };

        },

         mounted() {
            
            this.$nextTick(() => {
                console.log('ann')
                //this.$refs.map.mapObject._onResize();
                //this.$refs.map.mapObject.ANY_LEAFLET_MAP_METHOD();
                
            });

            delete Icon.Default.prototype._getIconUrl;
            Icon.Default.mergeOptions({
                iconRetinaUrl: require('leaflet/dist/images/marker-icon-2x.png'),
                iconUrl: require('leaflet/dist/images/marker-icon.png'),
                shadowUrl: require('leaflet/dist/images/marker-shadow.png'),
            });

            console.log(this.$refs.map)
            
        },

        computed: {

            dynamicSize2() {
                return [this.iconSize, this.iconSize * 1];
            },

            dynamicAnchor2() {
                return [this.iconSize / 2, this.iconSize * 1];
            },

            isReady2(){
                return this.semaforos.length > 0;
            },

        },
        methods: {

            reloadPage() {
                 window.location.reload();
            },

            calculateLatlng2(lat, lng){
               return latLng(lat,lng);
            },

            doSomethingOnReady2() {
                this.map = this.$refs.map.mapObject
            },
            zoomUpdated2 (zoom) {
                this.zoom = zoom;
            },
            centerUpdated2 (center) {
                this.center = center;
            },
            boundsUpdated2 (bounds) {
                this.bounds = bounds;
            },
            removeMarker2(index) {
                this.markers.splice(index, 1);
            },

            openModalRuta(event){
                $('#modalRuta').modal('show')
            },


            addRuta(semaforo){
                console.log(semaforo)
            },

            async enviarInstruccion(){
                console.log('enviar')
                // const response = axios.post('/api/intersecciones', this.form).then(({data})=>{  
                //     if( data.exito ){

                //         if( data.id )
                //             this.form.id = data.id;

                //          Swal.fire({
                //             title: 'Hecho!',
                //             text: data.msg,
                //             icon: 'success',
                //             showCancelButton: false,
                //             confirmButtonColor: '#3085d6',
                //             confirmButtonText: 'Ok'

                //         }).then((result) => {

                //             $('#modalSemaforoInfo').modal('hide')
                            
                //             if( this.direcciones_arr.length > 0 ){
                //                 this.guardarPatrones();
                //             }

                //             else{
                //                 this.reloadPage()
                //             }
                                
                        
                //         })
                //     }

                // });
      
            },
        }
}   
</script>
<style>
    .map-container{
        margin: auto;
        padding: 2px;
        height: 828px;
        width: 1333px;
    }
</style>