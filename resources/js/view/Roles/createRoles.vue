<template>
    <div class="container">
            <div class="row mt-2">
        <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Registrar Roles</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form @submit.prevent="Registrar">
                <div class="card-body">
                    <div class="form-group">
                    <label for="exampleInputEmail1">Role</label>
                    <input type="text" :class="{'form-control':true ,'is-invalid':form.errors.has('role')}" v-model="form.role" id="exampleInputEmail1" placeholder="Enter role">
                    <p style="color:red" :class="{'is-invalid':form.errors.has('role')}" >{{form.errors.get('role')}}</p>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Descripcion</label>
                    <input type="text" :class="{'form-control':true ,'is-invalid':form.errors.has('desc')}" v-model="form.desc" id="exampleInputEmail1" placeholder="Enter Cedula">
                    <p style="color:red" :class="{'is-invalid':form.errors.has('desc')}" >{{form.errors.get('desc')}}</p>
                  </div>
                  <div class="form-group">
                    <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                    <input type="checkbox"  v-model="form.activo" :class="{'custom-control-input':true,'is-invalid':form.errors.has('activo')}" id="customSwitch3" name="pfactur">
                    <label class="custom-control-label" id="customSwitch4" for="customSwitch3">{{cambioStatus}}</label>
                    <p style="color:red" :class="{'is-invalid':form.errors.has('activo')}" >{{form.errors.get('activo')}}</p>

                    </div>
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

import Swal from 'sweetalert2/dist/sweetalert2.js'

import 'sweetalert2/src/sweetalert2.scss'
export default {
  
    data(){
        return{
            form:new Form({
                role:"",
                desc:"",
                activo:false
            }),
            cambio:"no"
        }
    },computed:{
        cambioStatus:function(){
            return this.form.activo === true ?  'Si' : 'No'
        }
    },methods:{
        Registrar(){
            this.form.post('/api/createroles').then(({data}) => {
                    Swal.fire({
                    icon  :'success',
                    title:'Success!',
                    text  : data.msg,
                    toast : true
                  });

                  router.push('/groles');

                });
        }
    }
}
</script>
