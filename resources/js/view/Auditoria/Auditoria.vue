<template>
  <div class="container">  
        <div  class="row">
          <div class="col-12">
            <div class="card">

              <div class="card-header">
                <h3 class="card-title">Lista de Auditoria</h3>
                <div class="card-tools">
                    <div class="row" style="width: 630px;">
                        <div class="form-group col">
                            <v-select 
                                v-model="search1" 
                                :options="tipos"
                                :reduce="tipo => tipo.id"
                                placeholder="SELECCIONE TIPO"
                                label="tipo"
                                @input="buscarAuditoria"
                            >
                            <has-error :form="form" field="Tipo"></has-error>    
                            </v-select>
                        </div>
                        <div class="form-group col">
                            <div class="input-group input-group-md">
                            <input type="text" v-model="search2" @input="buscarAuditoria"  name="table_search" class="form-control float-right" placeholder="Buscar">
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
                        <th>IP</th>
                        <th>Descripción</th>
                        <th>Usuario</th>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Evento</th>
                    </tr>
                    <tr v-for="auditoria in auditorias.data" :key="auditoria.id">
                        <td>{{auditoria.ip_origen}}</td>
                        <td>{{auditoria.descripcion}}</td>
                        <td>{{auditoria.usuario.nombre}}</td>
                        <td>{{auditoria.fecha}}</td>
                        <td>{{auditoria.hora}}</td>
                        <td>{{auditoria.evento}}</td>
                    </tr>
                  </thead>
                </table>
                <div class="card-footer">
                     <pagination :data="auditorias"
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
                                     
                                    </div>
                                    <div class="form-group col">
                                        <label class="mt-2">Tipo</label>
                                    
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

                                    </div>
                                </div>
                            </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            <button type="button" @click="guardarAuditoria" class="btn btn-primary">{{ editMode ? 'Guardar cambios' : 'Guardar Incidencia' }} </button>
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
            this.loadAuditorias();
        },
        data(){
            return{
                auditorias:[],
                tipos: [],
                guardias: [],
                intersecciones: [],
                paginate: ['auditorias'],
                editMode : false,

                search1: null,
                search2: '', 
                form: new Form({
                    ip_origen: '',
                    fecha: '',
                    hora: '',
                    evento: '',
                    descripcion: ''
                }),
            }
        },methods: {

            getResults(page = 1){
                axios.get('api/auditoria/?page=' + page)
                    .then(response =>{
                        this.auditorias = response.data;
                    });
            },

            editIncidencia(auditoria){
                this.editMode = true;
                this.openModal(auditoria);
            },

            showIncidencia(auditoria){
                this.editMode = false;
                this.openModal(auditoria);
            },

            openModal(auditoria = null){
                if(auditoria) this.form = auditoria;
                $('#showAuditoria').modal('show')
            },

            closeModal(){
                $('#showAuditoria').modal('hide')
            },

            async buscarAuditoria(){
                if(this.search1){
                    await axios.get('api/auditorias/search/'+this.search1).then(({ data }) => {
                        this.auditorias = data
                    })
                }else if(this.search2 != ''){
                    await axios.get('api/auditorias/search/'+this.search2).then(({ data }) => {
                        this.auditorias = data
                    })
                }
                
            },

            async loadAuditorias(){
                await axios.get('api/auditoria').then(({data}) => this.auditorias = data);
            },

            async guardarAuditoria(){

                const response = axios.post('/api/auditoria', this.form).then(({data})=>{
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
                            this.loadAuditorias();
                        
                        })
                    }
                    else Swal.fire('Oops there has been an error');
                });
            },
        }
}   
</script>
