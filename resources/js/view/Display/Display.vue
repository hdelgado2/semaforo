<template>
    <div class="cargando" v-if="carga === false" style="display:none">
    <img class="image" width="50" height="50" :src="imageCarga">
  </div>
<div v-else class="container">
    
    <div  class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Lista de Displays</h3>
               <!--  <router-link to="/create/groles" class="btn btn-primary">Registrar</router-link> -->
                <div class="card-tools">
                 
                  <div class="input-group input-group-sm" style="width: 150px;">

                    <input type="text" v-model="search" @input="buscarInterseccion"  name="table_search" class="form-control float-right" placeholder="Search">

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
                      <th>Display</th>
                      <th>Acciones</th>
                    </tr>
                    <tr v-for="display in displays.data" :key="display.id">
                        <td>{{display.id}}</td>
                        <td>{{display.nombre_display}}</td>
                        <td>
                            <button @click="editInterseccion(display)" class="btn btn-outline-primary"><i class="fa-solid fa-pencil"></i></button>
                            <button @click="showInterseccion(display)" class="btn btn-outline-info"><i class="fa-solid fa-magnifying-glass"></i></button>
                        </td>
                        
                    </tr>
                  </thead>
                </table>
                <div class="card-footer">
                     <pagination :data="displays"
                        @pagination-change-page="getResults">
                    </pagination>
                </div>

                <div class="modal fade" id="showInterseccion" tabindex="-1" role="dialog" aria-labelledby=" showInterseccionInfoLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xl" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="showInterseccionInfoLabel">Display {{ this.form.nombre_display }}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="form-group col-8">
                                        <label for="interseccion" class="col-form-label">Nombre display:</label>
                                        <input :readonly="!editMode"  v-model="form.nombre_display" type="text" class="form-control" id="interseccion">
                                    </div>
                                    <div class="form-group col-2">
                                        <label for="latitud" class="col-form-label">Latitud:</label>
                                        <input :readonly="!editMode" v-model="form.latitud" type="text" class="form-control" id="latitud">
                                    </div>
                                    <div class="form-group col-2">
                                        <label for="longitud" class="col-form-label">Longitud:</label>
                                        <input :readonly="!editMode" v-model="form.longitud" type="text" class="form-control" id="longitud">
                                    </div>
                                </div>

                                <div class="row">
                    
                                    <div class="form-group col">
                                        <label for="ip-equipo" class="col-form-label">IP equipo:</label>
                                        <input :readonly="!editMode" v-model="form.ip_equipo" type="text" class="form-control" id="ip-equipo">
                                    </div>
                                    <div class="form-group col">
                                        <label for="mac-equipo" class="col-form-label">MAC equipo:</label>
                                        <input :readonly="!editMode" v-model="form.mac_equipo" type="text" class="form-control" id="mac-equipo">
                                    </div>
                                    <div class="form-group col">
                                        <label for="zoom" class="col-form-label">Zoom:</label>
                                        <input :readonly="!editMode" v-model="form.zoom" type="number" class="form-control" id="zoom">
                                    </div>
                                    <div class="form-group col">
                                        <label for="observacion" class="col-form-label">Observación:</label>
                                        <input :readonly="!editMode" v-model="form.observacion" type="text" class="form-control" id="observacion">
                                    </div>
                                </div>

                                <hr>


                            <table class="table table-striped">
                                <thead>tipo_mensaje','motivo_mensaje','mensaje','estado_mensaje'
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Tipo</th>
                                        <th scope="col">Motivo</th>
                                        <th scope="col">Mensaje</th>
                                        <th scope="col">Estado</th>
                                        <th v-if="editMode == true" scope="col">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr  v-for="mensaje, index in mensajes" :key="mensaje.id">
                                        <td>{{ mensaje.id}}</td>
                                        <td>{{ mensaje.tipo_mensaje }}</td>
                                        <td>{{ mensaje.motivo_mensaje }}</td>
                                        <td>{{ mensaje.mensaje }}</td>
                                        <td>{{ mensaje.estado_mensaje }}</td>
                                        <td class="text-center">
                                            <a v-if="editMode == true" href="#" @click="deleteDireccionArr(mensaje.id)">
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
            this.loadDisplays();
        },
        data(){
            return{
                displays:[],
                paginate: ['displays'],

                form: new Form({
                    id:"",
                    interseccion:'',
                    latitud:'',
                    longitud:'',
                    ip_equipo:'',
                    mac_equipo:'',
                    zoom:'',
                    observacion:'',
                    sentidos:[],
                    mensajes: []
                }),

                editMode : false,
                search: ''
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


            editDisplay(display){
                this.editMode = true;
                this.form = interseccion; 
                $('#showDisplay').modal('show')
            },


            async buscarDisplay(){
                await axios.get('api/intersecciones/listado/search/'+this.search).then(({ data }) => {
                        this.intersecciones = data
                    })
                // if(this.search != ''){
                //     await axios.get('api/intersecciones/listado/search/'+this.search).then(({ data }) => {
                //         this.intersecciones = data
                //     })
                // }
                
            },

            showDisplay(interseccion){

                console.log('open modal')
                this.editMode = false;
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

            DesactivarMensaje(index){
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

            async loadDisplays(){
                await axios.get('api/intersecciones/listado').then(({data}) => this.intersecciones = data);
            },
            async searchRoles(){
                await axios.get('api/searchroles/roles='+this.search).then(({data})=>this.listaRoles = data.data)
            },

            async guardarDisplay(){

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
