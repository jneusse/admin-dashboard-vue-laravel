<template>
    <div class="direct-chat-messages" ref="down">
        <!-- Message. Default to the left -->
        <template v-if="contacto">

          <div class="direct-chat-msg" v-for="(item, i) in mensajes" :key="i" :class="(item.to == contacto.id) ? '' : 'right'">
              <div class="direct-chat-infos clearfix">
                <span class="direct-chat-name float-left" :class="(item.to == contacto.id) ? ' float-left' : 'float-right'" v-text="item.usu_from_fullname"></span>
                <span class="direct-chat-timestamp float-right" :class="(item.to == contacto.id) ? ' float-right' : 'float-left'" v-text="item.created_at"></span>
              </div>
              <!-- /.direct-chat-infos -->
              <img class="direct-chat-img" v-if="!item.usu_from_profile_image" src="/img/user1-128x128.jpg" alt="message user image">
              <img class="direct-chat-img" v-else :src="item.usu_from_profile_image" alt="message user image">
              <!-- /.direct-chat-img -->
              <div class="direct-chat-text" v-text="item.text">
              </div>
              <!-- /.direct-chat-text -->
          </div>
          <!-- /.direct-chat-msg -->
      </template>
      <template v-else>
          <!-- Message. Default to the left -->
          <div class="direct-chat-msg">
            <vs-alert shadow>
              <template#title>
                Mensaje
              </template>
              Debe seleccionar un contacto
            </vs-alert>
          </div>

      </template>

    </div>
</template>

<script>
export default {
    props:['mensajes', 'contacto'],
    watch:{
      mensajes(){
        this.scrollToBotom()
      },
      contacto(){
        this.scrollToBotom()
      }
    },
    methods:{
      scrollToBotom(){
        setTimeout(()=>{
          this.$refs.down.scrollTop = this.$refs.down.scrollHeight - this.$refs.down.clientHeight
        },100)
      }
    }
}
</script>

<style>

</style>
