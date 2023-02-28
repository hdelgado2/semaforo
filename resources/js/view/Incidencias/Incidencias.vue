<template>
  <div class="container">  
        <div  class="row">
          <div class="col-12">
            <div class="card">

              <div class="card-header">
                <h3 class="card-title">Lista de Incidencias</h3>
                <div class="card-tools">
                    <div class="row" style="width: 630px;">
                        <div class="form-group col">
                            <v-select 
                                v-model="search1" 
                                :options="tipos"
                                :reduce="tipo => tipo.id"
                                placeholder="SELECCIONE TIPO"
                                label="tipo"
                                @input="buscarIncidencia"
                            >
                            <has-error :form="form" field="Tipo"></has-error>    
                            </v-select>
                        </div>
                        <div class="form-group col">
                            <div class="input-group input-group-md">
                            <input type="text" v-model="search2" @input="buscarIncidencia"  name="table_search" class="form-control float-right" placeholder="Search">
                            <button class="btn btn-outline-info" @click="openModal">Crear</button>
                        </div>
                        </div>
                        
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
                             <button @click="editIncidencia(incidencia)" class="btn btn-outline-info"><i class="fa-solid fa-pencil"></i></button> /
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

                <div class="modal fade" id="showIncidencia" tabindex="-1" role="dialog" aria-labelledby=" showIncidenciaInfoLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xl" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="showIncidenciaInfoLabel">Incidencia</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="form-group col">
                                        <label class="mt-2">Intersección</label>
                                        <v-select 
                                            v-model="form.intersecciones_id" 
                                            :options="intersecciones"
                                            :reduce="interseccion => interseccion.id"
                                            placeholder="SELECCIONE INTERSECCION"
                                            label="interseccion"
                                            :readonly="!editMode"
                                        >
                                            <has-error :form="form" field="Interseccion"></has-error>    
                                        </v-select>
                                    </div>
                                    <div class="form-group col">
                                        <label class="mt-2">Tipo</label>
                                        <v-select 
                                            v-model="form.tipo_incidencias_id" 
                                            :options="tipos"
                                            :reduce="tipo => tipo.id"
                                            placeholder="SELECCIONE TIPO"
                                            label="tipo"
                                            :readonly="!editMode"
                                        >
                                            <has-error :form="form" field="Tipo"></has-error>    
                                        </v-select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col">
                                        <label for="latitud" class="col-form-label">Acción</label>
                                        <input :readonly="!editMode" v-model="form.accion" type="text" class="form-control" id="accion">
                                    </div>
                                    <div class="form-group col">
                                        <label for="descripcion" class="col-form-label">Descripción</label>
                                        <input :readonly="!editMode" v-model="form.descripcion" type="text" class="form-control" id="descripcion">
                                    </div>
                                </div>
                                <div class="row">
                                     <div class="form-group col">
                                        <label for="solucion" class="col-form-label">Solución</label>
                                        <input :readonly="!editMode" v-model="form.solucion" type="text" class="form-control" id="accion">
                                    </div>
                                    <div class="form-group col">
                                        <label for="observacion" class="col-form-label">Observación</label>
                                        <input :readonly="!editMode" v-model="form.observacion" type="text" class="form-control" id="observacion">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-6">
                                        <label class="mt-2">Guardia</label>
                                        <v-select 
                                            v-model="form.guardias_id" 
                                            :options="guardias"
                                            :reduce="guardia => guardia.id"
                                            placeholder="SELECCIONE GUARDIA"
                                            label="horario"
                                            :readonly="!editMode"
                                        >
                                            <has-error :form="form" field="Guardia"></has-error>    
                                        </v-select>
                                    </div>
                                </div>
                            </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            <button type="button" @click="guardarIncidencia" class="btn btn-primary">{{ editMode ? 'Guardar cambios' : 'Guardar Incidencia' }} </button>
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
            this.loadIncidencias();
            this.loadTipos();
            this.loadGuardias();
            this.loadIntersecciones();
        },
        data(){
            return{
                incidencias:[],
                tipos: [],
                guardias: [],
                intersecciones: [],
                paginate: ['incidencias'],
                editMode : false,

                search1: null,
                search2: '', 

                form: new Form({
                    tipo_incidencias_id: null,
                    guardias_id: null,
                    intersecciones_id: null,
                    descripcion: '',
                    accion: '',
                    solucion: '',
                    observacion: '',
                    usuario_id: ''
                })
            }
        },methods: {

            getResults(page = 1){
                axios.get('api/incidencias/?page=' + page)
                    .then(response =>{
                        this.incidencias = response.data;
                    });
            },

            editIncidencia(incidencia){
                this.editMode = true;
                this.openModal(incidencia);
            },

            showIncidencia(incidencia){
                this.editMode = false;
                this.openModal(incidencia);
            },

            openModal(incidencia = null){
                if(incidencia) this.form = incidencia;
                $('#showIncidencia').modal('show')
            },

            closeModal(){
                this.resetForm();
                $('#showIncidencia').modal('hide')
            },

            resetForm(){
                this.form.tipo_incidencias_id = null;
                this.form.guardias_id = null;
                this.form.intersecciones_id = null;
                this.form.descripcion = '';
                this.form.accion = '';
                this.form.solucion = '';
                this.form.observacion = '';
                this.form.usuario_id = '';
            },

            async buscarIncidencia(){
                if(this.search1){
                    await axios.get('api/incidencias/search/'+this.search1).then(({ data }) => {
                        this.incidencias = data
                    })
                }else if(this.search2 != ''){
                    await axios.get('api/incidencias/search/'+this.search2).then(({ data }) => {
                        this.incidencias = data
                    })
                }
                
            },

            async loadIncidencias(){
                await axios.get('api/incidencias').then(({data}) => this.incidencias = data);
            },

            async loadTipos(){
                await axios.get('api/incidencias-tipos').then( ({data}) => this.tipos = data );
            },

            async loadGuardias(){
                await axios.get('api/guardias-all').then( ({data}) => this.guardias = data )
            },

            async loadIntersecciones(){
                await axios.get('api/intersecciones').then(({data}) => this.intersecciones = data);
            },

            async guardarIncidencia(){

                const response = axios.post('/api/incidencias', this.form).then(({data})=>{
                    if( data.exito ){
                         Swal.fire({
                            title: 'Hecho!',
                            text: data.msg,
                            icon: 'success',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'Ok'

                        }).then((result) => {

                            this.closeModal();
                            this.loadIncidencias();
                        
                        })
                    }
                    else Swal.fire('Oops there has been an error');
                });
            },
        }
}   
</script>
