<template>
    <div class="cargando" v-if="carga === false" style="display:none">
    <img class="image" width="50" height="50" :src="imageCarga">
  </div>
<div v-else class="container">
    
    <div  class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Lista de Roles</h3>
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
                      <th>Roles</th>
                      <th>Status</th>
                      <th>Action</th>
                    </tr>
                    <tr v-for="roles in listaRoles" :key="roles.id">
                        <td>{{roles.id}}</td>
                        <td>{{roles.nombre_rol}}</td>
                        <td v-if="roles.activo === true">Activo</td>
                        <td v-else>Inactivo</td>
                        <td><router-link :to="{path:'/deleteRoles/'+roles.id}" class="btn btn-warning">Edit</router-link>/
                            <button class="btn btn-danger" @click="deleteRoles(roles)">Borrar</button>
                        </td>
                        
                    </tr>
                  </thead>
                  <tbody>
                   
                  </tbody>
                </table>
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
            console.log("lllego");
            this.getRoles()
        },
        data(){
            return{
                listaRoles:{},
                search:""
            }
        },methods: {

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
            }
        }
}   
</script>
