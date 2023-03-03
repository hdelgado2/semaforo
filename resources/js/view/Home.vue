<template class="content-wallpaper" :style="image">
        <div class="content-wallpaper" style="height: 2000px;width: 2000px;"  :style="image">
        </div>
</template>
    
<script>
import Swal from 'sweetalert2/dist/sweetalert2.js'

import 'sweetalert2/src/sweetalert2.scss'
    
export default {
    data(){
        return{
            image: url("../../../public/images/wallpapers/semaforo3.jpg"),
        }
    },
        
}

</script>
<style scoped>
    .content-wallpaper{
        background-image: url("../../../public/images/wallpapers/semaforo3.jpg");
    }
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
    