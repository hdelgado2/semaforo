<template>
<div class="cargando" v-if="carga === false" style="display:none">
    <img class="image" width="50" height="50" :src="imageCarga">
  </div>
<div v-else class="container">
    
    <div  class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Lista de Usuarios</h3>
                <router-link to="/createuser" class="btn btn-primary">Registrar</router-link>
                <div class="card-tools">
                 
                  <div class="input-group input-group-sm" style="width: 150px;">

                   
                    <input type="text" v-model="search"  name="table_search" class="form-control float-right" placeholder="Search">

                    <div class="input-group-append">
                      <button type="submit" @click="searchUser" class="btn btn-default">
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
                    <tr v-for="list in Lista.data" :key="list.id">
                        <td>{{list.id}}</td>
                        <td>{{list.login}}</td>
                        <td>{{list.nombre+' '+list.apellido}}</td>
                        <td v-if="list.baneado === false">Activo</td>
                        <td v-else>Inactivo</td>
                        <td><button class="btn btn-warning">Edit</button>/
                            <button @click="deleteUser(list.id)" class="btn btn-danger">Borrar</button>
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


export default {
    data(){
        return{
            Lista:[],
            carga:false,
            imageCarga:"/gif/Gear-0.2s-800px.gif",
            search:""
        }
    },
    mounted() {
        this.getListUser()
    },
    methods:{
         async searchUser(){
            
            await axios.get('api/searchUser/search='+this.search).then((result) => {
                this.Lista = result['data']
            });
        },
        async getListUser(){
                
               this.carga = false;
                await axios.get('api/search').then((result) => {
               
                    this.Lista = result['data'];
               
            })
             if(this.Lista.data.length > 0) this.carga = true;  
        },
        async deleteUser(id){
            await axios.get('api/deleteUser/'+id).then((result) => this.Lista = result['data']);
          }
    }
}
</script>
<style scoped>
      .cargando {
      width: 100%;height: 100%;
      overflow: hidden; 
      top: 0px;
      left: 0px;
      z-index: 10000;
      text-align: center;
      position:absolute; 
      background-color: /*#FFFFFF*/ #FFF;
      opacity:0.9;
      filter:alpha(opacity=40);
      
   }
   .image{
    margin-top: 500px
   }
  </style>
