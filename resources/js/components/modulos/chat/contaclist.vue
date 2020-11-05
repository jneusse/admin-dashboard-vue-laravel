<template>
              <div class="direct-chat-contacts">
                <div class="input-group">
                  <input type="search" class="form-control" v-model="cBuscarContact">
                </div>
                <ul class="contacts-list">
                    <li v-for="(item, index) in filterContactos" :key="index" @click.prevent="seleccionarContacto(index, item)" :class="(selected == index) ? 'selected' : ''">
                        <a href="#">
                            <img v-if="!item.profile_imagen" class="contacts-list-img" src="/img/user1-128x128.jpg">
                            <img v-else class="contacts-list-img" :src="item.profile_imagen">

                            <div class="contacts-list-info">
                            <span class="contacts-list-name">
                                {{ item.fullname }}
                                <small class="contacts-list-date float-right">{{item.nNumeroMensajesNoLeidos}}</small>
                            </span>
                            <span v-if="typing.state == true && typing.usuario == item.id" class="contacts-list-msg">Está escribiendo . . . </span>
                            </div>
                            <!-- /.contacts-list-info -->
                        </a>
                    </li>
                    <!-- End Contact Item -->
                </ul>
                <!-- /.contacts-list -->
            </div>
</template>

<script>
export default {
    props:{
      contactos: {
        type: Array,
        default: []
      },
      typing: {
        type: Object
      }
    },
    data(){
        return{
            selected: '',
            cBuscarContact: ''
        }
    },
    mounted(){
    },
    computed:{
      filterContactos(){
        return this.contactos.filter(contacto => {
            return (contacto.fullname.toLowerCase().indexOf(this.cBuscarContact.toLowerCase()) != -1)
        })
      }
    },
    methods:{
        seleccionarContacto(index, item){
            this.selected = index
            this.$emit('contacto', item)
        }
    }
}
</script>

<style>

</style>
