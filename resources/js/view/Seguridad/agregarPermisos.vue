<template>
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
                <div class="col-sm-6">
                      <!-- Select multiple-->
                      <div class="form-group">
                        <label>Select Multiple</label>
                        <select multiple="" @change="cambioPermisos" class="form-control">
                          <option :value="menus.id" v-for="menus in menu" :key="menus.id">{{menus.nombre_menu}}</option>

                        </select>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <!-- Select multiple-->
                      <div class="form-group">
                        <label>Select Multiple</label>
                        <select multiple="" @change="cambioPermisos" class="form-control">
                          <option :value="menus.id" v-for="menus in form.permisos" :key="menus.id">{{menus.modulo}}</option>

                        </select>
                      </div>
                    </div>
                </div>
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
              </form>
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
                'niveles' :[]
            }),
            menu:{}
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

            this.menu.map(({id,nombre_menu}) => (id === parseInt($event.target.value)) ? this.form.permisos = [...this.form.permisos,{'id':id,'modulo':nombre_menu}] : '')
        }
    }
}
</script>
