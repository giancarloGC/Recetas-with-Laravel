<template>
        <input type="submit" class="btn btn-danger mr-1" value="Eliminar" @click="eliminarReceta">
</template>

<script>
    export default {
        props: ['recetaId'],
        methods: {
            eliminarReceta(){
                this.$swal({
                    title: "¿Estas Seguro de querer eliminar la Receta?",
                    text: "¡Una vez eliminada la receta, no se podra recuperar!",
                    icon: "warning",
                    showCancelButton: true, 
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Sí',
                    cancelButtonText: 'No'                   
                    })
                    .then((result) => {
                    if (result.value) {
                        const params= {
                            id: this.recetaId
                        }
                        //Aquí voy a enviar la peticion al servidor
                        axios.post(`/recetas/${this.recetaId}`, {params, _method: 'delete'})
                            .then(respuesta => {
                                this.$swal({
                                    title: 'Receta Eliminada',
                                    text: 'Se eliminó la receta',
                                    icon: "success",
                                });

                                //Eliminar la receta del DOM
                                this.$el.parentNode.parentNode.parentNode.removeChild(this.$el.parentNode.parentNode);
                            })
                            .catch(error => {
                                console.log(error);
                            })

                    }
                })
            }
        }
    }
</script>