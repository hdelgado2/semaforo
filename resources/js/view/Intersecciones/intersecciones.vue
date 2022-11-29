<template>
    <div class="cargando" v-if="carga === false" style="display:none">
    <img class="image" width="50" height="50" :src="imageCarga">
  </div>
<div v-else class="container">
    
    <div  class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Lista de Intersecciones</h3>
                <router-link to="/create/groles" class="btn btn-primary">Registrar</router-link>
                <div class="card-tools">
                 
                  <div class="input-group input-group-sm" style="width: 150px;">

                    <input type="text" v-model="search"  name="table_search" class="form-control float-right" placeholder="Search">

                    <div class="input-group-append">
                      <button type="submit" @click="searchRoles" class="btn btn-default">
                        <i class="fas fa-search"></i>
                      </button>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Intersección</th>
                      <th>Acciones</th>
                    </tr>
                    <tr v-for="interseccion in intersecciones.data" :key="interseccion.id">
                        <td>{{interseccion.id}}</td>
                        <td>{{interseccion.interseccion}}</td>
                        <td>
                            <button @click="editInterseccion" class="btn btn-outline-primary"><i class="fa-solid fa-pencil"></i></button>
                            <button @click="showInterseccion(interseccion)" class="btn btn-outline-info"><i class="fa-solid fa-magnifying-glass"></i></button>
                        </td>
                        
                    </tr>
                  </thead>
                </table>
                <div class="card-footer">
                     <pagination :data="intersecciones"
                        @pagination-change-page="getResults">
                    </pagination>
                </div>

                <div class="modal fade" id="showInterseccion" tabindex="-1" role="dialog" aria-labelledby=" showInterseccionInfoLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xl" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="showInterseccionInfoLabel">Semaforo {{ this.form.interseccion }}</h5>
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
                                        <th scope="col">Sentido</th>
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
                            <button type="button" @click="guardarInterseccion" class="btn btn-primary">{{ editMode ? 'Guardar cambios' : 'Guardar Interseccion' }} </button>
                        </div>
                    </div>
                </div>
            </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
</div> 
</template>
<script>

import Swal from 'sweetalert2/dist/sweetalert2.js'
import 'sweetalert2/src/sweetalert2.scss'

export default {
        mounted(){
            this.loadIntersecciones();
        },
        data(){
            return{
                intersecciones:[],
                paginate: ['intersecciones'],

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

                direcciones_arr:[],
                sentidos:['NORTE','SUR','OESTE','ESTE'],

            }
        },methods: {

            getResults(page = 1){
                axios.get('api/intersecciones/listado?page=' + page)
                    .then(response =>{
                        this.intersecciones = response.data;
                    });
            },

            toUpperCaseText(){
                console.log('upper')
                this.form_cruces.sentido_nombre = this.form_cruces.sentido_nombre.toUpperCase(); 
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

            editInterseccion(){

            },

            showInterseccion(){
                $('#showModal').modal('show')
            },

            showInterseccion(interseccion){

                console.log('open modal')
                this.editMode = true;
                this.form = interseccion;
                this.form.sentidos = []; 
                this.direcciones_arr = [];
                this.form.sentidos = interseccion.patrones;

                interseccion.patrones.forEach( (el) => {

                    if( el.id != null ){
                        console.log('id')
                        this.direcciones_arr.push(el)
                        // this.form.sentidos.push(el)

                    }else{
                        console.log('!id')
                        this.direcciones_arr.push(el)
                    }
                })

                $('#showInterseccion').modal('show')
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

            async loadIntersecciones(){
                await axios.get('api/intersecciones/listado').then(({data}) => this.intersecciones = data);
            },
            async getRoles(){
                await axios.get('api/listroles').then(({data}) => this.listaRoles = data.data);
            },
            async searchRoles(){
                await axios.get('api/searchroles/roles='+this.search).then(({data})=>this.listaRoles = data.data)
            },
            async deleteRoles({id}){
                await axios.get('api/deleteroles/'+id).then((result) => {
                  this.listaRoles = result['data']['data']
                  Swal.fire({
                    icon  :'success',
                    title:'Success!',
                    text  : "eliminado con exito",
                    toast : true
                  });
                });
            },
            async guardarInterseccion(){

                const response = axios.post('/api/intersecciones', this.form).then(({data})=>{
                //const response = await this.form.post('/api/intersecciones').then(({data}) => {
                   
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
        }
}   
</script>
