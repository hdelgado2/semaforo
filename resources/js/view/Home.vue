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
</style>
    