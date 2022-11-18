<template>

<div class="container">
        <div class="row">
            <div class="col">
                <div class="card w-75">
                    <div class="card-header">
                        <h3 class="card-title">Edición de incidencia</h3>
                        <div class="card-tools">
                            
                        </div>
                    </div>

                    <!-- Card header -->

                <form @submit.prevent="editIncidencia">
                    <div class="card-body">

                    <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="exampleInputEmail1">ID</label>
                            <input class="form-control" type="text" v-model="form.id" id="exampleInputEmail1" placeholder="Tipo" disabled>
                            <p style="color:red"></p>
                        </div> 
                    </div>
                    
                    <div class="col">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Tipo</label>
                            <input :class="{'form-control':true ,'is-invalid':form.errors.has('tipo')}" type="text" v-model="form.tipo" id="exampleInputEmail1" placeholder="Tipo" v-uppercase>
                            <p style="color:red" :class="{'is-invalid':form.errors.has('tipo')}">{{form.errors.get('tipo')}}</p>
                        </div>
                    </div>
                            
                    </div>

                    </div>
                    <!-- Card body -->
                    <div class="card-footer">
                       
                         <button type="submit" class="btn btn-primary float-right">Editar</button>
                        <router-link to="/gtincidencia" class="btn btn-default float-left mr-3">Volver</router-link>
                    
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
  
</template>

<script>

export default {
    data() {
        return {
            form: new Form({
                id: 0,
                tipo: ''
            })
            
        }
    },

    methods: {

        async getTipo(){

        console.log('mounted')
            var id = this.$router.currentRoute.params.id
            await axios.get('../api/edittipo/'+id)
                .then((res) =>{
            
            this.form.id   = res.data.id
            this.form.tipo = res.data.tipo
            }
            );
        },

        async editIncidencia(){
            await this.form.post('../api/updatetipo').then(({data}) => {
                Swal.fire({
                    icon  :'success',
                    title:'Success!',
                    text  : data.msg,
                    toast : true
                  });

                  router.push('/gtincidencia')
            })
        }
        
    },

    mounted() {

        this.getTipo();

    },

}
</script>

<style>

</style>