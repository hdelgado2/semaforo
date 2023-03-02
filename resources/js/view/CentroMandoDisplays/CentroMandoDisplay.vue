<template>

    <div style="height: 100%; width: 100%">
        <div class="row">
            <div class="col-7 form-group ml-4">
                <div class="row">
                    <p>Se encuentran seleccionadas {{ rutaLength }} intersecciones</p>
                    <button @click="resetRutas" :disabled="!isRuta" class="btn btn-outline-primary ml-2">Reiniciar</button>
                </div>
                
            </div>
            <div class="col-4 form-group ml-5 filtro">
                <v-select 
                    v-model="filtro" 
                    :options="semaforos"
                    placeholder="SELECCIONE INTERSECCIÓN"
                    label="nombre_display"
                    @input="selectLocationFilter()"
                >
                    <has-error :form="form" field="filtro"></has-error>    
                </v-select>
            </div>
        </div>
        

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
                    @click="showOptions(semaforo)"
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
                <l-polyline :lat-lngs="polyline.latlngs" :color="polyline.color"></l-polyline>
            </l-map>
        </div>
        

        <!-- Modal -->
        <div class="modal fade" id="modalSemaforoInfo" tabindex="-1" role="dialog" aria-labelledby="modalSemaforoInfoLabel" aria-hidden="true">
          <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="modalSemaforoInfoLabel">Display {{ this.form.interseccion }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <div class="row">
                    <div class="form-group col-8">
                        <label for="interseccion" class="col-form-label">Nombre intersección:</label>
                        <input :readonly="editarenviarinstruccion" v-model="form.interseccion" type="text" class="form-control" id="interseccion">
                    </div>
                    <div class="form-group col-2">
                        <label for="latitud" class="col-form-label">Latitud:</label>
                        <input :readonly="editarenviarinstruccion" v-model="form.latitud" type="text" class="form-control" id="latitud">
                    </div>
                    <div class="form-group col-2">
                        <label for="longitud" class="col-form-label">Longitud:</label>
                        <input :readonly="editarenviarinstruccion" v-model="form.longitud" type="text" class="form-control" id="longitud">
                    </div>
                </div>

                <div class="row">
                    
                    <div class="form-group col">
                        <label for="ip-equipo" class="col-form-label">IP equipo:</label>
                        <input :readonly="editarenviarinstruccion" v-model="form.ip_equipo" type="text" class="form-control" id="ip-equipo">
                    </div>
                    <div class="form-group col">
                        <label for="mac-equipo" class="col-form-label">MAC equipo:</label>
                        <input :readonly="editarenviarinstruccion" v-model="form.mac_equipo" type="text" class="form-control" id="mac-equipo">
                    </div>
                    <div class="form-group col">
                        <label for="zoom" class="col-form-label">Zoom:</label>
                        <input :readonly="editarenviarinstruccion"  v-model="form.zoom" type="number" class="form-control" id="zoom">
                    </div>
                    <div class="form-group col">
                        <label for="observacion" class="col-form-label">Observación:</label>
                        <input :readonly="editarenviarinstruccion"  v-model="form.observacion" type="text" class="form-control" id="observacion">
                    </div>
                </div>

                <hr>
                <h5>Programacion del display</h5>

                
                <div class="row">

                    <div v-if="modevista" class="form-group col">
                        <label class="mt-2">Mensaje a Desplegar :</label>
                        <v-select 
                            v-model="form_mensajes.mensaje" 
                            :options="mensajes"
                            placeholder="SELECCIONE INTERSECCIÓN"
                           label="mensaje"
                             >
                            <has-error :form="form" field="sentido"></has-error>    
                        </v-select>

                        <label for="sentido-nombre" class="col-form-label">Tiempo del Mensaje :</label>
                        <input v-model="form_mensajes.tiempo" type="text" @input="toUpperCaseText()" class="form-control" id="sentido-nombre">

                        <button v-if="editar"  @click="AñadirMensaje()" type="button" class="btn btn-outline-info mt-4 btn-lg btn-block" >Agregar</button>
                    </div>

                    
                </div>
<!-- :disabled="disabledAñadir" po si acaso-->
              <!--  -->

                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Mensaje </th>
                            <th scope="col">Motivo del mensaje</th>
                            <th scope="col">Estatus</th>
                            <th scope="col">Tiempo</th>
                            <th scope="col">Acciones</th>
                         
                        </tr>
                    </thead>
                    <tbody>

                         <tr  v-for="d, index in DatosTable" :key="index+1">
                            <td>{{ index+1 }}</td>
                            <td>{{ d.mensaje[0].mensaje }}</td>
                            <td>{{ d.mensaje[0].motivo_mensaje }}</td>
                            <td>Activo</td>
                            <td>{{ d.tiempo }}</td>
                           
                           
                            <td class="text-center">
                                <a href="#" @click="deleteMensajeDisplay(d)">
                                    <i class="fa-solid fa-trash red"></i>
                                </a>
                            </td>
                        </tr>
                        <!-- <tr  v-for="d in DatosTable">
                        
                            <td>{{ d }}</td>
                           
                            
                           
                            <td class="text-center">
                                <a href="#" @click="deleteDireccionArr(index)">
                                    <i class="fa-solid fa-trash red"></i>
                                </a>
                            </td>
                        </tr> -->
                    </tbody>
                </table>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cerrar</button>
                <button v-if="!editar" type="button" @click="guardarDisplaymassages" class="btn btn-outline-primary"><strong></strong>Guardar</button>
                <button v-if="editar" type="button" @click="guardarDisplaymassages" class="btn btn-outline-primary"><strong></strong>Editar</button>
                <button v-if="editar" type="button" @click="guardarDisplaymassages" class="btn btn-outline-primary"><strong></strong>Enviar instrucccion</button>
              </div>
            </div>
          </div>
        </div>

        <!-- -->

      

    </div>
</template>


<script>

import { latLng, Icon } from "leaflet";
import Swal from 'sweetalert2/dist/sweetalert2.js'
import Ruta from './Ruta.vue'
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
                mensajes:[],
                filtro: '',
                polyline: {
                    latlngs: [],
                    color: 'green'
                },

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

                form_mensajes: new Form({
                    mensaje:'',
                    tiempo:'',
                    idDisplay:'',
                    idMensaje:'',


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

                form_instrucciones: new Form({
                    sentido:'',
                    color:'',
                    tiempo:0,
                    ip_equipo: '',
                    intervalo_entre_interseccion: 0,
                    rutas: {
                        semaforos:[]
                    }
                }),

                isReady : false,
                editMode : false,
                editar: false,
                editarenviarinstruccion: false,
                modevista:false,

                interseccion:{},

                sentidos:['NORTE','SUR','OESTE','ESTE'],
                sentidosEmergencia:['NORTE-SUR','ESTE-OESTE','ROJOS','AMARILLOS','VERDES','CRUCE-1','CRUCE-2','ALTO'],
                colores:['ROJO','VERDE','AMARILLO','ROJO CRUCE IZQ','ROJO CRUCE DER','AMARILLO CRUCE IZQ','AMARILLO CRUCE DER','VERDE CRUCE IZQ','VERDE CRUCE DER'],
                
                direcciones_arr:[],
                rutas:[],
                DatosTable:{},
                dataclicked:{},
                
            };

        },

         mounted() {

            //this.loadIntersecciones();
            this.loadLocationDisplay();
            this.loadMensajesDisplay();


            
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
            disableTiempo(){
                if( this.form_instrucciones.sentido && this.form_instrucciones.sentido != 'ALTO' ){
                        return false;
                }
                return true;
            },
            isRuta(){
                return this.polyline.latlngs.length > 0;
            },
            rutaLength(){
                return this.form_instrucciones.rutas.semaforos.length
            }
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

            addRuta(semaforo){
                this.polyline.latlngs.push([semaforo.latitud, semaforo.longitud])
                this.form_instrucciones.rutas.semaforos.push({ ip_equipo: semaforo.ip_equipo, nombre: semaforo.interseccion, tiempo: 0, sentido:'', color:'' })
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
                this.editarenviarinstruccion=false;
                this.modevista = true;
            
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
                this.DatosTable = {};
                this.editar= false;
                
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
            //por eliminar
             //    semaforo.patrones.forEach( (el) => {

             //    if( el.id != null ){
             //        console.log('id')
             //        this.direcciones_arr.push(el)

             //    }else{
             //        console.log('!id')
             //        this.direcciones_arr.push(el)

             //    }
             // })

             $('#modalSemaforoInfo').modal('show')
          },

            innerClick(semaforo) {
                //  this.form_mensajes.tiempo='';
                // this.form_mensajes.mensaje='';

                this.editarenviarinstruccion = false;
                this.modevista = true;
                
             //   console.log('innerClick',semaforo)
                this.editMode = true;
                this.editar = true;
                this.form = semaforo;
                this.form.interseccion = semaforo.nombre_display;
                this.form.sentidos = []; 
                this.direcciones_arr = [];
                //this.form.sentidos = semaforo.patrones;
                this.dataclicked = semaforo; 
               this.loadMensajesDisplayTable(semaforo);

                $('#modalSemaforoInfo').modal('show')
                
            },

            showOptions(semaforo){

                let sem = semaforo
//console.log('esto es sem:',sem);
                Swal.fire({
                    title: 'Seleccione una acción',
                    showDenyButton: true,
                    showCancelButton: true,
                    confirmButtonText: '<strong>Editar</strong>',
                    cancelButtonText: 'Añadir a ruta',
                    denyButtonText: `<strong>Enviar instrucción</strong>`,
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        this.innerClick(sem)
                        //Swal.fire('Saved!', '', 'success')
                    } 
                    else if (result.isDenied) {
                        this.openInstructionModal(sem)
                    }
                    else if( result.dismiss === Swal.DismissReason.cancel){
                        this.addRuta(sem)
                    }
                })
            },

            openInstructionModal(semaforo) {
                this.modevista = false;
                this.loadMensajesDisplayTable;
                console.log('intructionModal')
                this.editarenviarinstruccion = true;
                this.editMode = true;
                this.form = semaforo;
                this.form.sentidos = []; 
                this.direcciones_arr = [];
                this.loadMensajesDisplayTable(semaforo);
              //  this.form.sentidos = semaforo.patrones;

                // semaforo.patrones.forEach( (el) => {

                //     if( el.id != null ){
                //         console.log('id')
                //         this.direcciones_arr.push(el)

                //     }else{
                //         console.log('!id')
                //         this.direcciones_arr.push(el)
                //     }
                // })
                $('#modalSemaforoInfo').modal('show')
            },


            toUpperCaseText(){
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

             deleteMensajeDisplay(d){


                console.log(d);


            //this.form = interseccion;
             const response = axios.post('/api/deleteDisplayMensaje/', d).then((result) => {
                
            //  this.Lista = result['data']
              Swal.fire({
                    icon  :'success',
                    title:'Success!',
                    text  : "eliminado con exito",
                    toast : true
                  });



                            this.loadMensajesDisplayTable(this.dataclicked);
            });
            },

            añadirPatron(){

                if( !this.patronExiste(this.form_cruces.sentido) ){

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
                
                }else{

                    Swal.fire("Oh no!", "Ya se encuentra añadido un patron en ese sentido.", "warning")
                }
              
            },

            selectLocationFilter(){
                if( this.filtro.latitud ){
                    this.currentZoom = 16;
                    this.zoom = 16;
                    this.currentCenter = latLng(this.filtro.latitud, this.filtro.longitud);
                    this.center = latLng(this.filtro.latitud, this.filtro.longitud);
                }

                return;
            },
            // here the new change.


             async publishMessage(){
                console.log('hey bro : ', this.form);
                //this.form_instrucciones.ip_equipo = this.form.ip_equipo;
                
                await axios.post("/api/publishMessages", this.form_instrucciones).then(({data})=>{

                    if( data.exito  ){

                         Swal.fire({
                            title: 'Hecho!',
                            text: data.msg,
                            icon: 'success',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'Ok'

                        }).then((result)=>{

                            $('#modalInstruccion').modal('hide');

                            this.form_instrucciones.sentido = '';
                            this.form_instrucciones.color = '';
                            this.form_instrucciones.tiempo = 0;

                            this.resetRutas()

                        })
                    }
                    else{

                         Swal.fire({
                            title: 'Oops!',
                            text: data.msg,
                            icon: 'warning',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'Ok'

                        })
                    }
                })
            },

            // async publishMessage(){

            //     this.form_instrucciones.ip_equipo = this.form.ip_equipo;
                
            //     await axios.post("/api/mqtt/publish", this.form_instrucciones).then(({data})=>{

            //         if( data.exito  ){

            //              Swal.fire({
            //                 title: 'Hecho!',
            //                 text: data.msg,
            //                 icon: 'success',
            //                 showCancelButton: false,
            //                 confirmButtonColor: '#3085d6',
            //                 confirmButtonText: 'Ok'

            //             }).then((result)=>{

            //                 $('#modalInstruccion').modal('hide');

            //                 this.form_instrucciones.sentido = '';
            //                 this.form_instrucciones.color = '';
            //                 this.form_instrucciones.tiempo = 0;

            //                 this.resetRutas()

            //             })
            //         }
            //         else{

            //              Swal.fire({
            //                 title: 'Oops!',
            //                 text: data.msg,
            //                 icon: 'warning',
            //                 showCancelButton: false,
            //                 confirmButtonColor: '#3085d6',
            //                 confirmButtonText: 'Ok'

            //             })
            //         }
            //     })
            // },

            // async loadIntersecciones(){
            //     await axios.get('api/intersecciones').then(({data}) => this.semaforos = data );
            //     console.log("listo");
            //     if( this.semaforos.length > 0) this.isReady = true;
            // },


            //here i start to work

            async loadLocationDisplay(){
                await axios.get('api/displaysonline').then(({data}) => this.semaforos = data );
                // console.log("listo");
                // console.log('estos son los datos', this.semaforos);
                if( this.semaforos.length > 0) this.isReady = true;
            },

            //end

            //function to load the information of the select
            async loadMensajesDisplay(){
                await axios.get('api/mensajeselect').then(({data}) => this.mensajes = data );
                console.log("listo");
                console.log('estos son los datos', this.mensajes);
                if( this.mensajes.length > 0) this.isReady = true;
            },

            //

            //function to save the information and create a new massage in a display.


            async guardarDisplaymassages(){
                console.log('probando', this.mensajes);
                   this.form_mensajes.tiempo='';
                this.form_mensajes.mensaje='';


                const response = axios.post('/api/LocationDisplay', this.form).then(({data})=>{
                console.log('este es el id que estoy buscando :', data.id);   
                this.form_mensajes.idDisplay =  data.id;
                this.form_mensajes.idMensaje = this.mensajes.id;   
                this.guardarMensajeDisplay();
                $('#modalSemaforoInfo').modal('hide');
                   this.loadLocationDisplay();
            this.loadMensajesDisplay();            

                    if( data.exito ){

                        if( data.id )
                            this.form.id = data.id;

                         Swal.fire({
                            title: 'Hecho!',
                            text: data.msg,
                            icon: 'success',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'Ok'

                        }).then((result) => {

                           // $('#modalSemaforoInfo').modal('hide')
                            
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
            //function to load the table messages and displays


            loadMensajesDisplayTable(semaforo){
                //console.log('this is the data bro :',semaforo);
                 const response = axios.post('/api/loadtabla', semaforo).then(({data})=>{
                 //
                 //
                  console.log('this is the data clicked',this.dataclicked.id);

                 this.form_mensajes.idDisplay=this.dataclicked.id;

                this.DatosTable = data.data;
                console.log('ESTOS SON LOS DATOS :', this.DatosTable);           

                    if( data.exito ){

                        if( data.id )
                          //  this.form.id = data.id;

                         Swal.fire({
                            title: 'Hecho!',
                            text: data.msg,
                            icon: 'success',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'Ok'

                        }).then((result) => {

                            // $('#modalSemaforoInfo').modal('hide')
                            // this.guardarMensajeDisplay();
                            // if( this.direcciones_arr.length > 0 ){
                            //     this.guardarPatrones();
                            // }

                            // else{
                            //     this.reloadPage()
                            // }
                                
                        
                        })
                    }

                });

            },
            //end

            async guardarMensajeDisplay(){

                //console.log('probando', this.form_mensajes.mensaje.id);
                console.log('vanessa',this.form_mensajes);
                const response = axios.post('/api/saveMassageDisplay', this.form_mensajes).then(({data})=>{
                console.log('guardo con exito :', data);   
                this.idDisplay = this.form_mensajes.mensaje.id;
                this.idMensaje =  data.id;               

                    if( data.exito ){

                        if( data.id )
                            this.form.id = data.id;

                         Swal.fire({
                            title: 'Hecho!',
                            text: data.msg,
                            icon: 'success',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'Ok'

                        }).then((result) => {

                            $('#modalSemaforoInfo').modal('hide')
                            this.guardarMensajeDisplay();
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
            //

            // async guardarInterseccion(){

            //     const response = axios.post('/api/intersecciones', this.form).then(({data})=>{

            //         if( data.exito ){

            //             if( data.id )
            //                 this.form.id = data.id;

            //              Swal.fire({
            //                 title: 'Hecho!',
            //                 text: data.msg,
            //                 icon: 'success',
            //                 showCancelButton: false,
            //                 confirmButtonColor: '#3085d6',
            //                 confirmButtonText: 'Ok'

            //             }).then((result) => {

            //                 $('#modalSemaforoInfo').modal('hide')
                            
            //                 if( this.direcciones_arr.length > 0 ){
            //                     this.guardarPatrones();
            //                 }

            //                 else{
            //                     this.reloadPage()
            //                 }
                                
                        
            //             })
            //         }

            //     });
      
            // },

            AñadirMensaje(){

                 //console.log('añadir mensaje');
                console.log('esta es la form',this.form_mensajes);
                // this.form_mensajes.tiempo='';
                // this.form_mensajes.mensaje='';


                const response = axios.post('/api/saveMassageDisplay', this.form_mensajes).then(({data})=>{  
                    this.loadMensajesDisplayTable(this.dataclicked);
                console.log('guardo con exito :', data);   
                // this.idDisplay = this.form_mensajes.mensaje.id;
                // this.idMensaje =  data.id;               

                    if( data.exito ){

                        if( data.id )
                            // this.form.id = data.id;

                         Swal.fire({
                            title: 'Hecho!',
                            text: data.msg,
                            icon: 'success',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'Ok'

                        }).then((result) => {

                            //$('#modalSemaforoInfo').modal('hide')
                           
                              
                            
                                
                        
                        })
                    }

                });

            },

            async guardarPatrones(){

                this.form_patrones.intersecciones = this.direcciones_arr;
                this.form_patrones.intersecciones_id = this.form.id;
                this.direcciones_arr = [];

                const response = axios.post('api/intersecciones/setPatrones', this.form_patrones).then(({data})=>{
                     
                     if( data.exito ){
                        Swal.fire({
                            icon  :'success',
                            title :'Hecho!',
                            text  : data.msg,
                        });

                        this.reloadPage()
                     }
                })
            },

            resetRutas(){
                console.log('ay')
                this.form_instrucciones.rutas.semaforos = []
                this.polyline.latlngs = []
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

    .filtro{
        float: right;
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