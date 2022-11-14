<template>
     <div class="container">
            <div class="row mt-2">
        <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Registrar Usuario</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form @submit.prevent="EditarUser">
                <div class="card-body">
                    <div class="form-group">
                    <label for="exampleInputEmail1">Cedula</label>
                    <input type="text" :class="{'form-control':true ,'is-invalid':form.errors.has('cedula')}" v-model="form.cedula" id="exampleInputEmail1" placeholder="Enter Cedula">
                    <p style="color:red" :class="{'is-invalid':form.errors.has('cedula')}" >{{form.errors.get('cedula')}}</p>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail2">Login</label>
                    <input type="text" :class="{'form-control':true ,'is-invalid':form.errors.has('login')}" v-model="form.login" id="exampleInputEmail1" placeholder="Enter Usuario">
                    <p style="color:red" :class="{'is-invalid':form.errors.has('login')}" >{{form.errors.get('login')}}</p>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Password</label>
                    <input type="password" class="form-control" v-model="form.password" :class="{'form-control':true ,'is-invalid':form.errors.has('password')}" id="exampleInputPassword1" placeholder="Enter Contraseña">
                    <p style="color:red" :class="{'is-invalid':form.errors.has('password')}" >{{form.errors.get('password')}}</p>

                  </div>
                  <div class="form-group">
                    <label for="exampleInputFile33">Nombre</label>
                    <div class="form-group">
                    <input type="text" class="form-control" v-model="form.nombre" :class="{'form-control':true ,'is-invalid':form.errors.has('nombre')}" id="exampleInputFile" placeholder="Enter Nombre">
                    <p style="color:red" :class="{'is-invalid':form.errors.has('nombre')}" >{{form.errors.get('nombre')}}</p>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputFile122">Apellido</label>
                    <input type="text" class="form-control" v-model="form.apellido" id="exampleInputFile" :class="{'form-control':true ,'is-invalid':form.errors.has('apellido')}" placeholder="Enter Apellido">
                    <p style="color:red" :class="{'is-invalid':form.errors.has('apellido')}" >{{form.errors.get('apellido')}}</p>
                  </div>
                  <div class="form-group">
                    <label >Roles</label>
                    <select v-model="form.roles" class="form-control select2bs4 select2-hidden-accessible " :class="{'is-invalid':form.errors.has('roles')}" style="width: 100%;" data-select2-id="17" tabindex="-1" aria-hidden="true">
                    <option selected :value="form.roles">{{role}}</option>
                    <option v-for="roles in roleslist" :key="roles.id" :value="roles.id">{{roles.nombre_rol}}</option>
                    
                    
                  </select>
                  <p style="color:red" :class="{'is-invalid':form.errors.has('roles')}" >{{form.errors.get('roles')}}</p>
                </div>
                </div>
                
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
              </form>
            </div>
        </div>
    </div>
    </div>
</template>
<script>


export default {
     data(){
        return{
            form: new Form({
                    login:"",
                    password:"",
                    nombre:"",
                    apellido:"",
                    roles:"",
                    cedula:"",
                    idUserEdit:0

                }),
                roleslist:[],
                role:"",
        }
     },mounted(){
        
        this.cargaUser();
        
     },
     methods:{
       async EditarUser(){
          await this.form.post('/api/editusers').then(({data}) => {

            Swal.fire({
                    icon  :'success',
                    title:'Success!',
                    text  : data.msg,
                    toast : true
                  });

                  router.push('/guser')

          });
        },  
        async cargaUser(){
            var id = this.$router.currentRoute.params.id
            this.form.idUserEdit = id;
            //console.log(url.hostname);
            await axios.get('../api/edituser/'+id).then(({data}) => {
              this.form.login    = data.login
              this.form.password = data.password
              this.form.nombre   = data.nombre
              this.form.apellido = data.apellido
              this.form.roles    = data.roles[0]['id']
              this.form.cedula   = data.cedula
              this.role = data.roles[0]['nombre_rol']
              this.roleslist = data.roless
              
                
            }).catch((err) => {
              
            });;
            
        }
     }
}
</script>
