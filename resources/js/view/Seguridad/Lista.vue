<template>

<div class="container">
    
    <div  class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Lista de Usuarios</h3>

                <div class="card-tools">
                 
                  <div class="input-group input-group-sm" style="width: 150px;">

                   
                    <input type="text" v-model="search"  name="table_search" class="form-control float-right" placeholder="Search">

                    <div class="input-group-append">
                      <button type="submit"  class="btn btn-default">
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
                      <th>User</th>
                      <th>Nombre</th>
                      <th>Status</th>
                      <th>Action</th>
                    </tr>
                    <tr v-for="list in lista" :key="list.id">
                        <td>{{list.id}}</td>
                        <td>{{list.login}}</td>
                        <td>{{list.nombre+' '+list.apellido}}</td>
                        <td v-if="list.baneado === false">Activo</td>
                        <td v-else>Inactivo</td>
                        <td><router-link to="/addpermisos" class="btn btn-primary">add</router-link>/
                            <button class="btn btn-danger">Borrar</button>
                        </td>
                    </tr>
                  </thead>
                  <tbody>
                   
                  </tbody>
                </table>
                <!-- <pagination :data="Lista" @pagination-change-page="getResults"></pagination> -->
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
</div>    
</template>

<script>
export default {
    mounted(){
        this.getListaUser()
    },
    data(){
        return{
            lista:{}
        }
    }
    ,methods:{
        async getListaUser(){
            await axios.get('/api/permisosLista').then(({data}) => {
                this.lista = data['data']
            });
        }
    }
}
</script>