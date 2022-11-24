<template>

    <div style="height: 100%; width: 100%">

     <!--    <div style="height: 200px; overflow: auto;">
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
        </div> -->

        <div class="map-container">
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
                    :key="semaforo.id" 
                    :item="semaforo"
                    :v-if="semaforo != null"
                    :lat-lng="calculateLatlng(semaforo.latitud, semaforo.longitud)" 
                    ref="marker"
                    @click="innerClick(semaforo)"
                    >
                    <l-icon :class="semaforo.id"
                            :icon-size="dynamicSize"
                            :icon-anchor="dynamicAnchor"
                            :icon-url="iconUrl"
                            
                        />
                        <l-tooltip :options="{ permanent: true, interactive: true }">
                            <div>
                                {{ semaforo.interseccion }}
                            </div>
                        </l-tooltip>

                </l-marker>
            </l-map>
        </div>
        

        <!-- Modal -->
        <div class="modal fade" id="modalSemaforoInfo" tabindex="-1" role="dialog" aria-labelledby="modalSemaforoInfoLabel" aria-hidden="true">
          <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="modalSemaforoInfoLabel">Semaforo {{ this.form.interseccion }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <div class="row">
                    <div class="form-group col-8">
                        <label for="interseccion" class="col-form-label">Nombre intersección:</label>
                        <input v-model="form.interseccion" type="text" class="form-control" id="interseccion">
                    </div>
                    <div class="form-group col-2">
                        <label for="latitud" class="col-form-label">Latitud:</label>
                        <input v-model="form.latitud" type="text" class="form-control" id="latitud">
                    </div>
                    <div class="form-group col-2">
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
                    <div class="form-group col">
                        <label for="observacion" class="col-form-label">Observación:</label>
                        <input v-model="form.observacion" type="text" class="form-control" id="observacion">
                    </div>
                </div>

                <hr>
                <h5>Cruces</h5>

                <div class="row">

                    <div class="form-group col">
                        <label class="mt-2">Sentido</label>
                        <v-select 
                            v-model="form_cruces.sentido" 
                            :options="sentidos"
                             >
                            <has-error :form="form" field="sentido"></has-error>    
                        </v-select>

                        <label for="sentido-nombre" class="col-form-label">Dirección :</label>
                        <input v-model="form_cruces.sentido_nombre" type="text" @input="toUpperCaseText()" class="form-control" id="sentido-nombre">

                        <button :disabled="disabledAñadir" @click="añadirPatron()" type="button" class="btn btn-outline-info mt-4 btn-lg btn-block" >Añadir patrón</button>
                    </div>

                    <div class="form-group col">
                        <label for="rojo" class="col-form-label">Rojo:</label>
                        <input v-model="form_cruces.rojo" type="number" class="form-control" id="rojo">

                        <label for="rojo-cruce-izq" class="col-form-label">Rojo cruce izq:</label>
                        <input v-model="form_cruces.rojo_cruce_izq" type="number" class="form-control" id="rojo-cruce-izq">

                        <label for="rojo-cruce-der" class="col-form-label">Rojo cruce der:</label>
                        <input v-model="form_cruces.rojo_cruce_der" type="number" class="form-control" id="rojo-cruce-der">
                    </div>

                    <div class="form-group col">
                        <label for="amarillo" class="col-form-label">Amarillo:</label>
                        <input v-model="form_cruces.amarillo" type="number" class="form-control" id="amarillo">

                        <label for="amarillo-cruce-izq" class="col-form-label">Amarillo cruce izq:</label>
                        <input v-model="form_cruces.amarillo_cruce_izq" type="number" class="form-control" id="amarillo-cruce-izq">

                        <label for="amarillo-cruce-der" class="col-form-label">Amarillo cruce der:</label>
                        <input v-model="form_cruces.amarillo_cruce_der" type="number" class="form-control" id="amarillo-cruce-der">
                    </div>

                    <div class="form-group col">
                        <label for="verde" class="col-form-label">Verde:</label>
                        <input v-model="form_cruces.verde" type="number" class="form-control" id="verde">

                        <label for="verde-cruce-izq" class="col-form-label">Verde cruce izq:</label>
                        <input v-model="form_cruces.verde_cruce_izq" type="number" class="form-control" id="verde-cruce-izq">

                        <label for="verde-cruce-der" class="col-form-label">Verde cruce der:</label>
                        <input v-model="form_cruces.verde_cruce_der" type="number" class="form-control" id="verde-cruce-der">
                    </div>
        
                </div>


                <table class="table table-striped">
                            <thead>
                              <tr>
                                <th scope="col">#</th>
                                <th scope="col">Dirección</th>
                                <th scope="col">Rojo</th>
                                <th scope="col">Rojo cruce izq</th>
                                <th scope="col">Rojo cruce der</th>
                                <th scope="col">Amarillo</th>
                                <th scope="col">Amarillo cruce izq</th>
                                <th scope="col">Amarillo cruce der</th>
                                <th scope="col">Verde</th>
                                <th scope="col">Verde cruce izq</th>
                                <th scope="col">Verde cruce der</th>
                                <th scope="col">Acciones</th>
                              </tr>
                            </thead>
                            <tbody>
                              <!-- <tr  v-for="s, index in form.sentidos" :key="index+1">
                                <td>{{ s.id }}</td>
                                <td>{{ s.direccion }}</td>
                                <td>{{ s.rojo }}</td>
                                <td>{{ s.rojo_cruce_izq }}</td>
                                <td>{{ s.rojo_cruce_der }}</td>
                                <td>{{ s.amarillo }}</td>
                                <td>{{ s.amarillo_cruce_izq }}</td>
                                <td>{{ s.amarillo_cruce_der }}</td>
                                <td>{{ s.verde }}</td>
                                <td>{{ s.verde_cruce_izq }}</td>
                                <td>{{ s.verde_cruce_der }}</td>
                                <td class="text-center">
                                  <a href="#" @click="deleteDireccionArr(index)">
                                    <i class="fa-solid fa-trash"></i>
                                  </a>
                                </td>
                              </tr> -->
                              <tr  v-for="d, index in direcciones_arr" :key="index+1">
                                <td>{{ index+1 }}</td>
                                <td>{{ d.direccion ?? d.sentido_nombre  }}</td>
                                <td>{{ d.sentido }}</td>
                                <td style="color: red;">{{ d.rojo }}</td>
                                <td style="color: red;">{{ d.rojo_cruce_izq }}</td>
                                <td style="color: red;">{{ d.rojo_cruce_der }}</td>
                                <td style="color: orange;">{{ d.amarillo }}</td>
                                <td style="color: orange;">{{ d.amarillo_cruce_izq }}</td>
                                <td style="color: orange;">{{ d.amarillo_cruce_der }}</td>
                                <td style="color: green;">{{ d.verde }}</td>
                                <td style="color: green;">{{ d.verde_cruce_izq }}</td>
                                <td style="color: green;">{{ d.verde_cruce_der }}</td>
                                <td class="text-center">
                                  <a href="#" @click="deleteDireccionArr(index)">
                                    <i class="fa-solid fa-trash red"></i>
                                  </a>
                                </td>
                              </tr>
                            </tbody>
                          </table>
                
                
                
                
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" @click="guardarInterseccion" class="btn btn-primary">Guardar intersección</button>
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
                semaforos: [],

                form: new Form({
                    id:"",
                    interseccion:'',
                    latitud:'',
                    longitud:'',
                    ip_equipo:'',
                    mac_equipo:'',
                    zoom:'',
                    observacion:'',
                    sentidos:[]
                }),

                form_cruces: new Form({
                    sentido:"",
                    sentido_nombre:'',
                    rojo:0,
                    rojo_cruce_izq:0,
                    rojo_cruce_der:0,
                    amarillo:0,
                    amarillo_cruce_izq:0,
                    amarillo_cruce_der:0,
                    verde:0,
                    verde_cruce_izq:0,
                    verde_cruce_der:0,
                }),

                form_patrones: new Form({
                    intersecciones:[],
                    intersecciones_id:''
                }),

                isReady : false,
                editMode : false,

                interseccion:{},

                sentidos:['NORTE','SUR','OESTE','ESTE'],
                // sentido:'',
                // sentido_nombre:'',

                direcciones_arr:[]
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
            },

            disabledAñadir(){
                if( this.form_cruces.sentido_nombre && this.form_cruces.sentido ){
                        return false;
                }

                return true;
            },
        },
        methods: {

            reloadPage() {
                 window.location.reload();
            },

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
                console.log('openModal')
                //this.form.reset();
                this.form.interseccion = ''
                this.form.latitud = ''
                this.form.longitud = ''
                this.form.ip_equipo =''
                this.form.mac_equipo = ''
                this.form.zoom = ''
                this.form.observacion = ''
                this.form.sentidos = []
                this.form.latitud = event.latlng.lat;
                this.form.longitud = event.latlng.lng;
                
                $('#modalSemaforoInfo').modal('show')
            },

            editModal(semaforo){

                console.log('editar');
                this.editMode = true;
                this.form.interseccion = ''
                this.form.latitud = ''
                this.form.longitud = ''
                this.form.ip_equipo =''
                this.form.mac_equipo = ''
                this.form.zoom = ''
                this.form.observacion = ''
                this.form.sentidos = []
                this.form.latitud = event.latlng.lat;
                this.form.longitud = event.latlng.lng;

                this.form = semaforo;
            
                semaforo.patrones.forEach( (el) => {

                if( el.id != null ){
                    console.log('id')
                    this.direcciones_arr.push(el)
                   // this.form.sentidos.push(el)

                }else{
                    console.log('!id')
                    this.direcciones_arr.push(el)

                }
             })

             $('#modalSemaforoInfo').modal('show')
          },

            // isHovering(id, accion){

            //     let icono = this.$refs['r'+id];

            //     if(accion != false){
            //       //  icono[0].$el.click();
            //         //icono[0].$el.style.display = 'block'
            //     }

            //     //else icono[0].$el.style.display = 'none'
            // },

            innerClick(semaforo) {
                //this.form.reset();
                console.log('innerClick')
                this.form = semaforo;
                this.form.sentidos = []; 
                this.direcciones_arr = [];
                this.form.sentidos = semaforo.patrones;

                semaforo.patrones.forEach( (el) => {

                    if( el.id != null ){
                        console.log('id')
                        this.direcciones_arr.push(el)
                        // this.form.sentidos.push(el)

                    }else{
                        console.log('!id')
                        this.direcciones_arr.push(el)
                    }
                })

                $('#modalSemaforoInfo').modal('show')
                
            },

            toUpperCaseText(){
                console.log('upper')
                this.form_cruces.sentido_nombre = this.form_cruces.sentido_nombre.toUpperCase(); 
            },

            patronExiste(sentido) {
                if( this.direcciones_arr.length > 0)
                    return this.direcciones_arr.some(el => el.sentido  === sentido);

                return false;
            },

            patronArrExiste(sentido) {
                return this.direcciones_arr.some(el => el.interseccion === interseccion);
            },

            deleteDireccionBD(id){
                this.form.sentidos = this.form.sentidos.filter(sentido => sentido.id != id);
            },

            deleteDireccionArr(index){
                console.log(index)

                Swal.fire({
                    title: 'Eliminar?',
                    text: "No podra revertir esta acción!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, eliminar!'
                }).then((result) => {
                    if (result.isConfirmed) {

                        this.direcciones_arr = this.direcciones_arr.filter( (direccion, i )=> i != index);

                        Swal.fire(
                            'Hecho!',
                            'Patron eliminado.',
                            'success'
                        )
                    }
                })
                
            },

            añadirPatron(){

                //console.log("añadir patron")
                if( !this.patronExiste(this.form_cruces.sentido) ){

                    //this.direcciones_arr.push(this.form_cruces);
                    this.direcciones_arr.push({ sentido: this.form_cruces.sentido, direccion: this.form_cruces.sentido_nombre, rojo: this.form_cruces.rojo,
                    rojo_cruce_izq: this.form_cruces.rojo_cruce_izq, rojo_cruce_der: this.form_cruces.rojo_cruce_der, amarillo: this.form_cruces.amarillo, amarillo_cruce_izq: this.form_cruces.amarillo_cruce_izq,
                    amarillo_cruce_der: this.form_cruces.amarillo_cruce_der, verde: this.form_cruces.verde, verde_cruce_izq: this.form_cruces.verde_cruce_izq, verde_cruce_der: this.form_cruces.verde_cruce_der });

                    this.form_cruces.sentido = "";
                    this.form_cruces.sentido_nombre = '';
                    this.form_cruces.rojo = 0;
                    this.form_cruces.rojo_cruce_izq = 0;
                    this.form_cruces.rojo_cruce_der = 0;
                    this.form_cruces.amarillo = 0;
                    this.form_cruces.amarillo_cruce_izq = 0;
                    this.form_cruces.amarillo_cruce_der = 0;
                    this.form_cruces.verde = 0;
                    this.form_cruces.verde_cruce_izq = 0;
                    this.form_cruces.verde_cruce_der = 0;
                    //this.form_cruces. = {}
                    //this.form.cantidad = ''
                    //this.form.precio_unitario = ''
                    //this.form.descuento = ''
                
                }else{

                    Swal.fire("Oh no!", "Ya se encuentra añadido un patron en ese sentido.", "warning")
                }
              
            },

            async loadIntersecciones(){
                await axios.get('api/intersecciones').then(({data}) => this.semaforos = data );
                console.log("listo");
                if( this.semaforos.length > 0) this.isReady = true;
            },

            async guardarInterseccion(){
                console.log(this.form)
                const response = axios.post('/api/intersecciones', this.form).then(({data})=>{
                //const response = await this.form.post('/api/intersecciones').then(({data}) => {
                   
                    if( data.exito ){
                        console.log(data)

                         Swal.fire({
                            title: 'Hecho!',
                            text: data.msg,
                            icon: 'success',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'Ok'

                        }).then((result) => {

                            $('#modalSemaforoInfo').modal('hide')
                            
                            if( this.direcciones_arr.length > 0 ){
                                this.guardarPatrones();
                            }

                            else{
                                this.reloadPage()
                            }
                                
                        
                        })
                    }

                });
      
            },

            async guardarPatrones(){

                this.form_patrones.intersecciones = this.direcciones_arr;
                this.form_patrones.intersecciones_id = this.form.id;
                this.direcciones_arr = [];

                const response = axios.post('api/intersecciones/setPatrones', this.form_patrones).then(({data})=>{
                //const response = await this.form_patrones.post('api/intersecciones/setPatrones').then(({data}) => {
                     
                     if( data.exito ){
                        Swal.fire({
                            icon  :'success',
                            title:'Success!',
                            text  : data.msg,
                        });

                        //this.reloadPage()
                     }
                })
            }

    
        }
}   
</script>
<style>

    .popup:hover{
        display: block;
    }
    .map-container{
        margin: auto;
        padding: 2px;
        height: 828px;
        width: 1333px;
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