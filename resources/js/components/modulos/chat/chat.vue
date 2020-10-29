<template>
    <div class="card direct-chat direct-chat-primary" :class="(openContact) ? 'direct-chat-contacts-open' : '' " style="position: relative; left: 0px; top: 0px;">
        <div class="card-header ui-sortable-handle" style="cursor: move;">
            <h3 class="card-title">Mensajes</h3>

            <div class="card-tools">
            <span data-toggle="tooltip" title="3 New Messages" class="badge badge-primary">{{totalMensajes}}</span>
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
            </button>
            <button type="button" class="btn btn-tool"  @click.prevent="abrirContactos">
                <i class="fas fa-comments"></i>
            </button>
            <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i>
            </button>
            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <!-- Conversations are loaded here -->
            <Conversation :mensajes="listMensajes" :contacto="selectedContact"/>
            <!--/.direct-chat-messages-->
            <ContactList :contactos="listContactos" @contacto="getListarConversaciones" :typing="userTyping"/>
            <!-- Contacts are loaded here -->

            <!-- /.direct-chat-pane -->
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            <SendMessage :usuario="usuario" @mensaje="setNuevoMensaje" :contacto="selectedContact"/>
        </div>
        <!-- /.card-footer-->
    </div>
</template>
<script>
import Conversation from './conversation'
import ContactList from './contaclist'
import SendMessage from './sendmessage'
export default {
    components:{Conversation, ContactList, SendMessage},
    props: ['usuario'],
    data(){
        return{
             listContactos: [],
             listMensajes: [],
             selectedContact: null,
             openContact: false,
             userTyping: {
               usuario: 0,
               state: false
             }
        }
    },
    computed:{
        totalMensajes(){
            return this.listContactos.reduce(function(valorAnterior, valorActual) {
                return valorAnterior + parseFloat(valorActual.nNumeroMensajesNoLeidos);
            },0)
        }
    },
    mounted(){
      this.getListarContactos()
      Echo.private(`mensaje.${this.usuario.id}`)
        .listen('NuevoMensaje', (e) => {
          console.log(e);
          this.setMensajeEntrante(e.mensaje)
        })
      Echo.private('escribiendo')
        .listenForWhisper('typing', (e) => {
          if(this.usuario.id == e.contacto){
            this.userTyping.state = true
            this.userTyping.usuario = e.usuario
            // console.log(this.userTyping.state);

            setTimeout(()=>{
              this.userTyping.state = false
              // console.log(this.userTyping.state);
            }, 2000)
          }
        })

    },
    methods:{
        getListarContactos(){
            let url = '/chat/getListarContactos'
            axios.get(url)
                .then( res => {
                    // console.log(res.data);
                    this.listContactos = res.data
                })
        },
        setNuevoMensaje(rpta){
          this.listMensajes.push(rpta)
        },
        getListarConversaciones(contacto){
          this.abrirContactos()
            let url = '/chat/getListarConversaciones'
            let params = {
                'nIdContacto': contacto.id
            }
            axios.get(url, {params: params})
                .then( res => {
                    this.getListarContactos()
                    this.listMensajes = res.data
                    this.selectedContact = contacto
                })

        },
        abrirContactos(){
          this.openContact = !this.openContact
        },
        setMensajeEntrante(mensaje){
          if(this.selectedContact && this.selectedContact.id == mensaje.from){
            this.setNuevoMensaje(mensaje)
          }

          const noti = this.$vs.notification({
              border: true,
              position: 'top-center',
              color: 'primary',
              title: mensaje.usu_from_fullname,
              text: mensaje.text
          })
          this.getListarContactos()
        }
    }
}
</script>

<style>

</style>
