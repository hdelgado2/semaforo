<template>
    <div class="cargando" v-if="carga === false" style="display:none">
    <img class="image" width="50" height="50" :src="imageCarga">
  </div>
<div v-else class="container">
    
    <div  class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Lista de Localizaciones Displays</h3>
               <!--  <router-link to="/create/groles" class="btn btn-primary">Registrar</router-link> -->
                <div class="card-tools">
                 
                  <div class="input-group input-group-md" style="width: 250px;">

                    <div class="col">
                      <button type="submit" @click="crearlocalizacion" class="btn btn-primary">
                            <i class="fa-solid fa-plus"></i> Crear
                        </button>
                    </div>

                    <div class="col">
                         <input type="text" v-model="search" @input="BuscarDisplay"  name="table_search" class="form-control float-right" placeholder="Search">
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
                      <th>Localizacion</th>
                      <th>Acciones</th>
                    </tr>
                    <tr v-for="interseccion in intersecciones" :key="interseccion.id">
                        <td>{{interseccion.id}}</td>
                        <td>{{interseccion.nombre_display}}</td>
                        <td>
                            <button @click="cargaredit(interseccion)" class="btn btn-outline-primary"><i class="fa-solid fa-pencil"></i></button>
                            <button @click="showdatosdisplay(interseccion)" class="btn btn-outline-info"><i class="fa-solid fa-magnifying-glass"></i></button>
                            <button @click="deletedisplay(interseccion)" class="btn btn-outline-info"><i class="fa-sharp fa-solid fa-trash-can" style="color:red;"></i></button>
                        </td>
                        
                    </tr>
                  </thead>
                </table>
                <div class="card-footer">
                     <pagination :data="intersecciones"
                        @pagination-change-page="getResults">
                    </pagination>
                </div>

                <!-- -->

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
                               

                               

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                           
                            <div v-if="!modoeditar1">
                                 <button v-if="modoeditar" type="button" @click="guardarInterseccion" class="btn btn-primary">Guardar</button>
                            <button v-if="!modoeditar" type="button" @click="editDisplay" class="btn btn-primary"> Guardar Cambios</button>
                            </div>
                           
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

                intersecciones:{},
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
                   // sentidos:[]
                }),


                editMode : false,
                modoeditar: false,
                modoeditar1:false,
                search: ''
            }
        },methods: {

            getResults(page = 1){
                axios.get('api/intersecciones/listado?page=' + page)
                    .then(response =>{
                        this.intersecciones = response.data;
                    });
            },

            crearlocalizacion(interseccion){
                this.modoeditar1= false;
                this.modoeditar = true;
                this.editMode = true;
                this.form = interseccion;

                $('#showInterseccion').modal('show')
            },

           async deletedisplay(interseccion){

            this.form = interseccion;
             const response = axios.post('/api/deletedisplay/', this.form).then(({data}) => {

                console.log(data.exito);
                if(data.exito){
                  Swal.fire({
                title: 'Hecho!',
                        text: data.msg,
                        icon: 'success',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Ok'
              }).then((data)=>{

                this.loadIntersecciones();

                 })

                 } else{

                         Swal.fire({
                            title: 'Oops!',
                            text: data.msg,
                            icon: 'warning',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'Ok'

                        })
                    }
            });

            },


            async cargaredit(interseccion){
                 console.log('open modal') 

                this.form = interseccion;
                this.modoeditar1=false;
                 this.modoeditar = false;
                 this.editMode=true;
                $('#showInterseccion').modal('show')
            },

            editDisplay(){
                this.modoeditar=true;
                this.modoeditar1= false;
                const response = axios.post('/api/botoneditardisplay', this.form).then(({data})=>{
                   
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

                            $('#showInterseccion').modal('hide')
                            this.loadIntersecciones();
                        
                        })
                    }

                });

                console.log('editar')
            },

            async BuscarDisplay(){
            console.log('trying angel', this.search);
               let query= this.search;
                await axios.get('api/displaysearch?q='+query).then(({ data }) => {
                    console.log('probando datos retornados: ', data.data);
                        this.intersecciones = data.data;
                    })

            },

            showdatosdisplay(interseccion){

                console.log('open modal')
                this.modoeditar1 =true;
                this.editMode = false;
                this.form = interseccion;
                
                $('#showInterseccion').modal('show')
            },

            async loadIntersecciones(){
               await axios.post('api/loadDisplays/listado').then(({data}) => this.intersecciones = data);
               console.log('es esta',this.intersecciones);
            },
           
         
            async guardarInterseccion(){

                const response = axios.post('/api/guardarlacalizacionesdisplays', this.form).then(({data})=>{
               

                         Swal.fire({
                            title: 'Hecho!',
                            text: data.msg,
                            icon: 'success',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'Ok'

                        }).then((result) => {

                            $('#showInterseccion').modal('hide')
                            this.loadIntersecciones();
                           
                                
                        
                        })
                    

                });
      
            },
        }
}   
</script>
