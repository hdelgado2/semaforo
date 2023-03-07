<template>
    <div class="cargando" v-if="carga === false" style="display:none">
    <img class="image" width="50" height="50" :src="imageCarga">
  </div>
<div v-else class="container">
    
    <div  class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Lista de Mensajes</h3>
               <!--  <router-link to="/create/groles" class="btn btn-primary">Registrar</router-link> -->
                <div class="card-tools">
                 
                  <div class="input-group input-group-md" style="width: 250px;">
                    <div class="col">
                        <button type="submit" @click="openModal" class="btn btn-primary">
                            <i class="fa-solid fa-plus"></i> Crear
                        </button>
                    </div>
                    <div class="col">
                        <input type="text" v-model="search" @input="buscarMensaje"  name="table_search" class="form-control float-right" placeholder="Search">
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
                      <th>Tipo de mensaje</th>
                      <th>Motivo mensaje</th>
                      <th>Mensaje</th>
                      <th>Acciones</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="mensaje in mensajes.data" :key="mensaje.id">
                        <td>{{ mensaje.id }}</td>
                        <td>{{ mensaje.tipo_mensaje  }}</td>
                        <td>{{ mensaje.motivo_mensaje }}</td>
                        <td>{{ mensaje.mensaje  }}</td>
                        <td>
                            <button @click="cargamensaje(mensaje)" class="btn btn-outline-primary"><i class="fa-solid fa-pencil"></i></button>
                            <button @click="deletemensaje(mensaje)" class="btn btn-outline-info"><i class="fa-sharp fa-solid fa-trash-can"></i>

</button>
                        </td>
                        
                    </tr>
                  </tbody>
                </table>
                <div class="card-footer">
                     <pagination :data="mensajes"
                        @pagination-change-page="getResults">
                    </pagination>
                </div>

                <div class="modal fade" id="modalMensaje" tabindex="-1" role="dialog" aria-labelledby="modalMensajeInfoLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xl" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 v-if="accioneditar !=false" class="modal-title" id="modalMensajeInfoLabel">Crear Mensaje</h5>
                                <h5 v-if="accioneditar !=true" class="modal-title" id="modalMensajeInfoLabel">Editar Mensaje</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="form-group col-4">
                                        <label for="tipo_mensaje" class="col-form-label">Tipo de mensaje:</label>
                                        <input v-model="form.tipo_mensaje" type="text" class="form-control" id="tipo_mensaje">
                                    </div>
                                    <div class="form-group col-4">
                                        <label for="mensaje" class="col-form-label">Mensaje:</label>
                                        <input  v-model="form.mensaje" type="text" class="form-control" id="mensaje">
                                    </div>
                                    <div class="form-group col-4">
                                        <label for="motivo_mensaje" class="col-form-label">Motivo de Mensaje:</label>
                                        <input  v-model="form.motivo_mensaje" type="text" class="form-control" id="motivo_mensaje">
                                    </div>
                                </div>


                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            <button v-if="accioneditar!= false" type="button" @click="guardarMensaje" class="btn btn-primary"> Guardar Mensaje  </button>
                            <button v-if="accioneditar != true" type="button" @click="editMensaje" class="btn btn-primary">Guardar cambios </button>
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
            this.loadMensajes();
        },
        data(){
            return{
                mensajes:{},
                paginate: ['mensajes'],

                form: new Form({
                    id:"",
                    tipo_mensaje:"",
                    mensaje:"",
                    motivo_mensaje:""
                }),

                direcciones_arr:[],
                sentidos:['NORTE','SUR','OESTE','ESTE'],
                editMode : false,
                search: '',
                accioneditar:true,
            }
        },methods: {

            getResults(page = 1){
                axios.get('api/mensajes/listado?page=' + page)
                    .then(response =>{
                        this.mensajes = response.data;
                    });
            },

             async buscarMensaje(){
                console.log('trying angel', this.search);
                let query= this.search;
                await axios.get('api/mensajesearch?q='+query).then(({ data }) => {
                    console.log('probando datos retornados: ', data);
                        this.mensajes = data
                    })
            },

            //cargar mensaje

            async cargamensaje(mensaje_id){
                console.log('here i go', mensaje_id.id)
                 this.form.id = mensaje_id;
              
               await this.form.post('/api/cargarmensaje/'+mensaje_id).then(({data}) => {

                 console.log('ver que hay aqui', data);
                this.form.tipo_mensaje = data.tipo_mensaje;
                this.form.mensaje = data.mensaje;
                this.form.motivo_mensaje = data.motivo_mensaje; 
                //this.form.id = mensaje_id;
                if(data.exito === 200){
                    Swal.fire({
                    icon  :'success',
                    title:'Success!',
                    text  : data.msg
                  });
                }
                
               
            })
                 this.accioneditar= false;
           
                 this.editMode = false;
                $('#modalMensaje').modal('show')
                
          
            
        },

        async deletemensaje(id){
            this.form.id = id;

            await this.form.post('/api/deletemensaje/'+id).then(({data}) => {
                
         
                console.log(data.exito);
                 if(data.exito){
                      Swal.fire({
                    title: 'Hecho!',
                            text: data.msg,
                            icon: 'success',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'Ok'
                  }).then((result)=>{

                            this.loadMensajes();

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


          async  editMensaje(){

            const response = axios.post('/api/botoneditar', this.form).then(({data})=>{
                   
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

                            $('#modalMensaje').modal('hide')
                            this.loadMensajes();
                        
                        })
                    }

                });



                console.log('editar')
            },

            async loadMensajes(){
                await axios.get('api/mensajes').then(({data}) => this.mensajes = data);
            },

            async openModal(){
                this.form.mensaje='';
                this.form.tipo_mensaje='';
                this.form.motivo_mensaje='';
                this.accioneditar= true;
                this.editMode = false;
                $('#modalMensaje').modal('show')
            },  

            async guardarMensaje(){

                const response = axios.post('/api/mensajes', this.form).then(({data})=>{
                   
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

                            $('#modalMensaje').modal('hide')
                            this.loadMensajes();
                        
                        })
                    }

                });
      
            },
        }
}   
</script>