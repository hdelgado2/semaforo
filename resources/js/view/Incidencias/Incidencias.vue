<template>
  <div class="container">  
        <div  class="row">
          <div class="col-12">
            <div class="card">

              <div class="card-header">
                <h3 class="card-title">Lista de Incidencias</h3>
                <div class="card-tools">
                  <div class="input-group input-group-sm" style="width: 150px;">
                    <input type="text" v-model="search" @input="buscarIncidencia"  name="table_search" class="form-control float-right" placeholder="Search">
                  </div>
                </div>
              </div>

              <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                        <th>Tipo</th>
                        <th>Acción</th>
                        <th>Descripción</th>
                        <th>Guardia</th>
                        <th>Acciones</th>
                    </tr>
                    <tr v-for="incidencia in incidencias.data" :key="incidencia.id">
                        <td>{{incidencia.tipo.tipo}}</td>
                        <td>{{incidencia.accion}}</td>
                        <td>{{incidencia.descripcion}}</td>
                        <td>{{incidencia.guardia ? incidencia.guardia.usuario.nombre_completo : ''}}</td>
                        <td>
                            <button @click="editIncidencia(incidencia)" class="btn btn-outline-primary"><i class="fa-solid fa-pencil"></i></button>
                            <button @click="showIncidencia(incidencia)" class="btn btn-outline-info"><i class="fa-solid fa-magnifying-glass"></i></button>
                        </td>
                    </tr>
                  </thead>
                </table>
                <div class="card-footer">
                     <pagination :data="incidencias"
                        @pagination-change-page="getResults">
                    </pagination>
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
            this.loadIncidencias();
        },
        data(){
            return{
                incidencias:[],
                paginate: ['incidencias'],
                editMode : false,
                search: ''
            }
        },methods: {

            getResults(page = 1){
                axios.get('api/incidencias/?page=' + page)
                    .then(response =>{
                        this.incidencias = response.data;
                    });
            },


            editIncidencia(interseccion){
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


            async buscarIncidencia(){
                await axios.get('api/incidencias/search/'+this.search).then(({ data }) => {
                        this.incidencias = data
                    })
            },

            showIncidencia(interseccion){

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

            async loadIncidencias(){
                await axios.get('api/incidencias').then(({data}) => this.incidencias = data);
            },

            async guardarInterseccion(){

                const response = axios.post('/api/intersecciones', this.form).then(({data})=>{

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
