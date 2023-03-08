<template class="py-2">
        <div class="wallpaper" style="background-image: url('images/wallpapers/semaforo4.jpg');" >
        </div> 
        <!-- <div>
            <img width="400px" height="400px" :src="imageCarga">
        </div> -->
</template>
    
<script>
import Swal from 'sweetalert2/dist/sweetalert2.js'

import 'sweetalert2/src/sweetalert2.scss'
    
export default {
    data(){
        return{
            // image: url("../../../public/images/wallpapers/semaforo3.jpg"),
            imageCarga:"https://fotografias.lasexta.com/clipping/cmsimages01/2021/06/17/B822C48C-B5A2-4C1B-8F5F-D9A52C11B28F/default.jpg?crop=1300,731,x0,y0&width=1900&height=1069&optimize=low",
        }
    },
        
}

</script>
<style scoped>
    .wallpaper {
        height: 900px;
        width: 2000px;
        margin-block: -23px;
        background-repeat: no-repeat; 
    }
</style>
    