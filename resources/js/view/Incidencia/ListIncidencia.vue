<template>

    <div class="container">

        <div class="card border-dark mb-3" >
            <div class="card-header">NUEVO TIPO DE INCIDENCIA</div>
            <form @submit.prevent="newTipo">
            <div class="card-body text-dark">
                <label for="">Incidencia</label>
                <input type="text" :class="{'form-control':true ,'is-invalid':form.errors.has('tipo')}" v-model="form.tipo" v-uppercase>
                <p style="color:red" :class="{'is-invalid':form.errors.has('tipo')}" >{{form.errors.get('tipo')}}</p>
            </div>
            <div class="card-footer text-dark">
                <button type="submit" class="btn btn-success float-right">Registrar</button>
            </div>
            </form>
            </div>


        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Tipos de incidencia</h3>
                        <div class="card-tools">
                            <div class="input-group" >
                            <input type="text" class="form-control float-right" placeholder="Search">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-default">
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card header -->

                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover text-center">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>TIPO</th>
                                    <th>ACCIÓN</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="tipo in tipos" :key="tipo.id">
                                    <td>{{ tipo.id }}</td>
                                    <td>{{ tipo.tipo }}</td>
                                    <td>
                                        <router-link :to="{path: '/editincidencia/'+tipo.id}" class="btn btn-warning">Edit</router-link>
                                        ||
                                        <button class="btn btn-danger" @click="deleteTipo(tipo.id)">Borrar</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- Card body -->
                    <!-- <div class="card-footer">
                        <router-link to="#" class="btn btn-primary float-right">Registrar</router-link>
                    </div> -->
                </div>
            </div>
        </div>
    </div>


</template>

<script>
export default {
    data() {
        return {
            carga: false,
            imageCarga:"/gif/Gear-0.2s-800px.gif",
            tipos: {},

            form: new Form({
                tipo: ''
            })
        }

    },

    methods: {
        async loadTipos(){
            await axios.get('api/tiposincidencia').then((response) => 
            this.tipos = response.data)
        },
        
        async newTipo(){

            await this.form.post('api/storetipo').then(({data}) => {
                Swal.fire({
                    icon  :'success',
                    title:'Success!',
                    text  : data.msg,
                    toast : true
                  });

                  this.tipos = data.tipos
                  this.form.tipo = ''
            })
    
        },

        async deleteTipo(id){
            await axios.get('api/deletetipo/'+id).then((response) => {
                Swal.fire({
                    icon  :'success',
                    title:'Success!',
                    text  : 'Tipo eliminado con éxito',
                    toast : true
                  });
                this.tipos = response.data;
            })

        }
    },


    mounted() {
        this.loadTipos();
    },

}

</script>

<style>

</style>