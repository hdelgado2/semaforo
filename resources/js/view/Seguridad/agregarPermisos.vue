<template>
  <div class="container">
    <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Permisos a {{form.nombre}}</h3>
              </div>
              <form>
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Login</label>
                    <input type="email" disabled v-model="form.login" class="form-control" id="exampleInputEmail1" placeholder="Enter email">
                  </div>
                  <div class="row">
                    <div class="col-sm-12">
                      <!-- Select multiple-->
                      <div class="form-group">
                        <label>Select Multiple</label>
                        <select multiple="" @change="cambioPermisos" class="form-control">
                          <option :value="menus.id" v-for="menus in menu" :key="menus.id">{{menus.nombre_menu}}</option>
                        </select>
                      </div>
                    </div>
                  </div>
                
                    <div class="col-sm-12">
                      <!-- Select multiple-->
                      <div class="form-group">
                        <label>Select Multiple</label>
                        <select multiple="" @change="nivel" class="form-control">
                          <option :value="menus.id" v-for="menus in form.permisos" :key="menus.id">{{menus.modulo}}</option>
                        </select>
                      </div>
                    </div>
                    <div class="row">
                    <div class="col-sm-6">
                      <!-- checkbox -->
                      <div class="form-group" v-show="ocultar">
                        <div v-for="(niveles2,index) in form.niveles" :key="index" class="custom-control custom-checkbox">
                          <input class="custom-control-input" type="checkbox" :id="'customCheckbox'+index" >
                          <label :for="'customCheckbox'+index" class="custom-control-label">{{niveles[index]}}</label>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
              </form>
            </div>

  </div>
   
    
</template>
<script>

export default {
    data(){
        return{
            form:new Form({
                'nombre':"",
                'login': "",
                'permisos':[],
                'niveles' :[{'Ver contenido':false},
                            {'Crear Contenido':false},
                            {'Editar Contenido':false},
                            {'Borrar Contenido':false}
                           ]                           
                            
                            
            }),
            menu:{},
            niveles:['Ver contenido','Crear Contenido','Editar Contenido','Borrar Contenido'],
            ocultar:false

        }
    },mounted(){
        console.log(router.history.current.params.id)
        this.getUser()
    },
    methods:{
        async getUser(){
            await axios.get('/api/edituser/'+router.history.current.params.id).then(({data}) => {
                this.form.nombre = data.nombre
                this.form.login = data.login
            })

            await axios.get('/api/menu').then(({data}) => this.menu = data);
        },

        cambioPermisos($event){
           //busca si hay modulo añadido
            let findd = this.form.permisos.find(({id}) => (id === parseInt($event.target.value)))
              //si lo encuentra no lo deja ingresar
              if(findd) return ;
        
            this.menu.map(({id,nombre_menu}) => (id === parseInt($event.target.value)) ? this.form.permisos = [...this.form.permisos,{'id':id,'modulo':nombre_menu}] : '')
            
        
          },nivel($event){
              this.ocultar = true
              /*let findd = this.form.find(({id}) => (id === parseInt($event.target.value)))

              if(findd){

              };*/
          } 

    }
}
</script>
