<template>
    <div>
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Dashboard</h1>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="conteiner-fluid">
                <div class="row">
                    <div class="col-md-6">
                        <Chat :usuario="authUser"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Chat from '../chat/chat'
export default {
    components: {Chat},
    data(){
      return{
          authUser: JSON.parse(sessionStorage.getItem('authUser'))
        }
      }
}
</script>

<style>

</style>
