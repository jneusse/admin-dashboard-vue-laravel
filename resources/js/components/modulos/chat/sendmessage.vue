<template>
    <form action="#" method="post">
        <div class="input-group">
            <input type="text" v-model="message" placeholder="Type Message ..." class="form-control" @keydown.enter.prevent="setRegistrarMensaje" @keydown="escribiendoMensaje">
            <span class="input-group-append">
            <button type="button" class="btn btn-primary" @click="setRegistrarMensaje">Send</button>
            </span>
        </div>
    </form>
</template>

<script>
export default {
  props: ['contacto', 'usuario'],
    data(){
        return{
            message:''
        }
    },
    methods:{
        setRegistrarMensaje(){
            if(!this.message){
                return
            }
            if(!this.contacto){
                return
            }
            let url = '/chat/setRegistrarMensaje'
            let params = {
              'nIdContacto' : this.contacto.id,
              'cMensaje' : this.message
            }
            axios.post(url, params)
              .then( res => {
                this.$emit('mensaje', res.data[0])
                this.message = ''
              })
        },
        escribiendoMensaje(){
          Echo.private('escribiendo')
            .whisper('typing', {
              usuario: this.usuario.id,
              contacto: this.contacto.id,
              typing: true
            })
        }
    }
}
</script>

<style>

</style>
