<template>

</template>

<script>
    import Swal from 'sweetalert';
    import SweetalertIcon from 'vue-sweetalert-icons';
    export default {
        components: { SweetalertIcon },
        created() {
            window.events.$on('notification', (payload) => {
                //Swal(payload.message);
                Swal({
                    //title: "Deleted!",
                    text: payload.message,
                    button: "Ok", // Text on button
                    icon: "success", //built in icons: success, warning, error, info
                    timer: 3000, //timeOut for auto-close
                });
            })
        }
    }
</script>
