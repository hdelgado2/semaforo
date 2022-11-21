<template>

    <div style="height: 800px; width: 100%">

        <div style="height: 200px; overflow: auto;">
            <p>First marker is placed at {{ withPopup.lat }}, {{ withPopup.lng }}</p>
            <p>Center is at {{ currentCenter }} and the zoom is: {{ currentZoom }}</p>
         
            <button @click="showMap = !showMap">
                Toggle map
            </button>
        </div>

        <div class="info" style="height: 5%">
            <span>Center: {{ center }}</span>
            <span>Zoom: {{ zoom }}</span>
            <span>Bounds: {{ bounds }}</span>
        </div>

        <div class="map-container" >
            <l-map  @ready="doSomethingOnReady()"
                v-if="isReady"
                ref="map"
                :zoom="zoom"
                :center="center"
                :options="mapOptions"
                style="height: 80%;width: 100%"
                @update:zoom="zoomUpdated"
                @update:center="centerUpdated"
                @update:bounds="boundsUpdated"
                @click="openModal"
            >
                <l-tile-layer :url="url" :attribution="attribution">
                </l-tile-layer>
                <l-marker v-for="semaforo,index in semaforos"
                    :key="index+1" 
                    :item="semaforo"
                    :lat-lng="calculateLatlng(semaforo.latitud, semaforo.longitud)" 
                    ref="marker"
                    @click="innerClick(semaforo)">
                    <l-icon
                            :icon-size="dynamicSize"
                            :icon-anchor="dynamicAnchor"
                            :icon-url="iconUrl"
                        />
                    <l-popup>
                        <div>
                            {{ semaforo.interseccion }}
                        </div>
                    </l-popup>
                </l-marker>
            </l-map>
        </div>
        

        <!-- Modal -->
        <div class="modal fade" id="modalSemaforoInfo" tabindex="-1" role="dialog" aria-labelledby="modalSemaforoInfoLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="modalSemaforoInfoLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <div class="row">
                    <div class="form-group col">
                        <label for="interseccion" class="col-form-label">Nombre intersección:</label>
                        <input v-model="form.interseccion" type="text" class="form-control" id="interseccion">
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col">
                        <label for="latitud" class="col-form-label">Latitud:</label>
                        <input v-model="form.latitud" type="text" class="form-control" id="latitud">
                    </div>
                    <div class="form-group col">
                        <label for="longitud" class="col-form-label">Longitud:</label>
                        <input v-model="form.longitud" type="text" class="form-control" id="longitud">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col">
                        <label for="ip-equipo" class="col-form-label">IP equipo:</label>
                        <input v-model="form.ip_equipo" type="text" class="form-control" id="ip-equipo">
                    </div>
                    <div class="form-group col">
                        <label for="mac-equipo" class="col-form-label">MAC equipo:</label>
                        <input v-model="form.mac_equipo" type="text" class="form-control" id="mac-equipo">
                    </div>
                    <div class="form-group col">
                        <label for="zoom" class="col-form-label">Zoom:</label>
                        <input v-model="form.zoom" type="number" class="form-control" id="zoom">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col">
                        <label for="observacion" class="col-form-label">Observación:</label>
                        <input v-model="form.observacion" type="text" class="form-control" id="observacion">
                    </div>
                </div>

                <hr/>

                <h5>Cruces</h5>

                <div class="row">
                    <div class="form-group col">
                        <label for="rojo" class="col-form-label">Rojo:</label>
                        <input v-model="form.rojo" type="number" class="form-control" id="rojo">
                    </div>
                    <div class="form-group col">
                        <label for="rojo-cruce-izq" class="col-form-label">Rojo cruce izq:</label>
                        <input v-model="form.rojo_cruce_izq" type="number" class="form-control" id="rojo-cruce-izq">
                    </div>
                    <div class="form-group col">
                        <label for="rojo-cruce-der" class="col-form-label">Rojo cruce der:</label>
                        <input v-model="form.rojo_cruce_der" type="number" class="form-control" id="rojo-cruce-der">
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col">
                        <label for="amarillo" class="col-form-label">Amarillo:</label>
                        <input v-model="form.amarillo" type="number" class="form-control" id="amarillo">
                    </div>
                    <div class="form-group col">
                        <label for="amarillo-cruce-izq" class="col-form-label">Amarillo cruce izq:</label>
                        <input v-model="form.amarillo_cruce_izq" type="number" class="form-control" id="amarillo-cruce-izq">
                    </div>
                    <div class="form-group col">
                        <label for="amarillo-cruce-der" class="col-form-label">Amarillo cruce der:</label>
                        <input v-model="form.amarillo_cruce_der" type="number" class="form-control" id="amarillo-cruce-der">
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col">
                        <label for="verde" class="col-form-label">Verde:</label>
                        <input v-model="form.verde" type="number" class="form-control" id="verde">
                    </div>
                    <div class="form-group col">
                        <label for="verde-cruce-izq" class="col-form-label">Verde cruce izq:</label>
                        <input v-model="form.verde_cruce_izq" type="number" class="form-control" id="verde-cruce-izq">
                    </div>
                    <div class="form-group col">
                        <label for="verde-cruce-der" class="col-form-label">Rojo cruce der:</label>
                        <input v-model="form.verde_cruce_der" type="number" class="form-control" id="verde-cruce-der">
                    </div>
                </div>
                
                
                
                
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
              </div>
            </div>
          </div>
        </div>

    </div>
</template>


<script>

import { latLng, Icon } from "leaflet";

export default {

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
                showMap: false,
                iconSize: 50,
                popupAnchor: [0, -40],
                iconUrl: require('leaflet/dist/images/marker-icon.png'),
                //markers: [],
                semaforos: [],
                semaforos2: [
                      latLng(11.7102521, -70.4838664),
                      latLng(11.7102521, -70.1838662),
                      latLng(11.7102521, -40.4838661),
                ],

                form: new Form({
                    id:"",
                    interseccion:'',
                    latitud:'',
                    longitud:'',
                    ip_equipo:'',
                    mac_equipo:'',
                    zoom:'',
                    observacion:'',
                }),

                

                interseccion:{},

            };

        },

         mounted() {

            this.loadIntersecciones();

            
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

            console.log(this.$refs.map)
            
        },

        computed: {
            dynamicSize() {
                return [this.iconSize, this.iconSize * 1];
            },
            dynamicAnchor() {
                return [this.iconSize / 2, this.iconSize * 1];
            },
            isReady(){
                return this.semaforos.length > 0;
            }
        },
        methods: {

            calculateLatlng(lat, lng){
               return latLng(lat,lng);
            },

            doSomethingOnReady() {
                this.map = this.$refs.map.mapObject
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

                let newSemaforo = {
                    lat : event.latlng.lat,
                    lng : event.latlng.lng
                }

                this.intersecciones.push(newSemaforo)


                this.$refs.map.mapObject.addMarker(newSemaforo)

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

            openModal(event){
                console.log("abrir")

                this.form.reset();

                this.form.latitud = event.latlng.lat;
                this.form.longitud = event.latlng.lng;
                
                $('#modalSemaforoInfo').modal('show')
            },


            innerClick(semaforo) {
                //this.form.reset();
                this.form = semaforo;
                $('#modalSemaforoInfo').modal('show')
                
            },

            async loadIntersecciones(){
                await axios.get('api/intersecciones').then(({data}) => this.semaforos = data );
                console.log("listo");
            },

            async guardarInterseccion(){
           
                const response = await this.form.post('/api/createUser').then(({data}) => {
                    Swal.fire({
                    icon  :'success',
                    title:'Success!',
                    text  : data.msg,
                  });

                  router.push('/guser')

                });
      
            }

    
        }
}   
</script>
<style>
    .map-container{
        margin: auto;
        padding: 2px;
        height: 600px;
        width: 980px;
    }

    @media (max-width: 400px) {
        .map-container{
            margin: auto;
            padding: 2px;
            height: 600px;
            width: 700px;
         }
    }
    @media (max-width: 700px) {
        .map-container{
            margin: auto;
            padding: 2px;
            height: 600px;
            width: 980px;
        }
    }
</style>