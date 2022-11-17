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
                        <select multiple="" @change="nivel" class="form-control " id="nivel">
                          <option  :value="menus.id" v-for="(menus,index) in form.permisos" :id="index" :key="menus.id">{{menus.modulo}}</option>
                        </select>
                      </div>
                    </div>
                    <div class="row">
                    <div class="col-sm-6">
                      <!-- checkbox -->
                      <div class="form-group"  v-show="ocultar">
                        <div @change="checked" v-html="checkboxx"  class="custom-control custom-checkbox">
                          
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
            }),
            menu:{},
            niveles:['Ver contenido','Crear Contenido','Editar Contenido','Borrar Contenido'],
            ocultar:false,
            temp:null,
            nivel1:0,
            string:""

        }
    },mounted(){
        console.log(router.history.current.params.id)
        this.getUser()
    },
    computed:{
        checkboxx:function() {
             this.string = '';
            if(this.form.permisos[this.nivel1] === undefined) return this.string;

             this.form.permisos[this.nivel1].niveles.map((_,index) => {
                this.string += `<input class="custom-control-input" name="${index}"  type="checkbox" id="customCheckbox${index}" >
                          <label for="customCheckbox${index}" class="custom-control-label">${this.niveles[index]}</label><br/>`
                    
             })
          return this.string  
         },
    },
    methods:{
      checked($event){
        console.log(parseInt($event.target.name))
          this.form.permisos[this.nivel1].niveles.map((_,index) => (parseInt($event.target.name) === index) ? this.form.permisos[this.nivel1].niveles[index] = true : '')
          console.log($event)
      },
       
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
        
            this.menu.map(({id,nombre_menu}) => (id === parseInt($event.target.value)) ? this.form.permisos = [...this.form.permisos,{'id':id,'modulo':nombre_menu,'niveles':[false,false,false,false]}] : '')
            
        
          },nivel($event){
              this.ocultar = true
              this.nivel1 = parseInt($event.explicitOriginalTarget.id)
              if($event.target.id === "nivel")
                 this.temp = this.form.permisos.find((_,index) => (index === parseInt($event.explicitOriginalTarget.id)));
              
           }

    }
}
</script>
