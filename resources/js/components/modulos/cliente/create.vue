<template>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Crear Cliente</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->

        <div class="content container-fluid">
            <div class="card">
                <div class="card-header">
                    <div class="card-tools">
                        <router-link class="btn btn-info btn-sm" :to="'/cliente'">
                            <i class="fas fa-arrow-left"></i> Regresar
                        </router-link>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title">Formulario Registrar Cliente</h3>
                            </div>
                            <div class="card-body">
                                <form role="form ">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label for="" class="col-md-12 col-form-label">Documento</label>
                                                <div class="col-md-12">
                                                    <input type="text" class="form-control" v-model="fillCrearCliente.cDocumento" @keyup.enter="setRegistrarPedido">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label for="" class="col-md-12 col-form-label">Nombre</label>
                                                <div class="col-md-12">
                                                    <input type="text" class="form-control" v-model="fillCrearCliente.cNombre" @keyup.enter="setRegistrarPedido">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label for="" class="col-md-12 col-form-label">Apellido</label>
                                                <div class="col-md-12">
                                                    <input type="text" class="form-control" v-model="fillCrearCliente.cApellido" @keyup.enter="setRegistrarPedido">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label for="" class="col-md-12 col-form-label">Correo</label>
                                                <div class="col-md-12">
                                                    <vs-input v-model="fillCrearCliente.cEmail" placeholder="correo@email.com">
                                                        <template v-if="validEmail" #message-success>
                                                        Email Valido
                                                        </template>
                                                        <template v-if="!validEmail && fillCrearCliente.cEmail !== ''" #message-danger>
                                                        Email Invalido
                                                        </template>
                                                    </vs-input>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label for="" class="col-md-12 col-form-label">Teléfono</label>
                                                <div class="col-md-12">
                                                    <input type="text" class="form-control" v-model="fillCrearCliente.cTelefono" @keyup.enter="setRegistrarPedido">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-md-12">
                                        <button class="btn btn-flat btn-default" @click.prevent="limpiarCriterios">Limpiar</button>
                                        <button class="btn btn-flat btn-info" v-loading.fullscreen.lock="fullscreenLoading" @click.prevent="setRegistrarCliente">Registrar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" :class="{ show: modalShow }" :style=" modalShow ? mostrarModal : ocultarModal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Sistema Laravel VUE</h5>
                        <button class="close" @click="abrirModal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="callout callout-danger" style="padding: 5px" v-for="(item, index) in mensajeError" :key="index" v-text="item"></div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" @click="abrirModal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>


    </div>
</template>

<script>
export default {
    data(){
        return{
            cBuscar: '',
            fillCrearCliente: {
                cDocumento: '',
                cNombre: '',
                cApellido: '',
                cEmail: '',
                cTelefono: ''
            },
            fullscreenLoading: false,
            modalShow: false,
            mostrarModal:{
                display: 'block',
                background: '#0000006b',
            },
            ocultarModal:{
                display: 'none',
            },
            error: 0,
            mensajeError: [],
        }
    },
    computed:{
    },
    mounted(){
    },
    computed:{
        validEmail() {
          return /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(this.fillCrearCliente.cEmail)
        }
    },
    methods:{
        limpiarCriterios(){
            this.fillCrearCliente.cDocumento = ''
            this.fillCrearCliente.cNombre = ''
            this.fillCrearCliente.cApellido = ''
            this.fillCrearCliente.cEmail = ''
            this.fillCrearCliente.cTelefono = ''
            this.cBuscar = ''
        },
        abrirModal(){
            this.modalShow = !this.modalShow
        },
        setRegistrarCliente(){

            if(this.validarRegistrarCliente()){
                let url = '/operacion/cliente/setRegistrarCliente'
                this.fullscreenLoading = true
                let params = {
                        'cDocumento': this.fillCrearCliente.cDocumento,
                        'cNombre': this.fillCrearCliente.cNombre,
                        'cApellido': this.fillCrearCliente.cApellido,
                        'cEmail': this.fillCrearCliente.cEmail,
                        'cTelefono': this.fillCrearCliente.cTelefono
                    }
                axios.post(url, params)
                    .then(res=>{
                        this.fullscreenLoading = false
                        this.limpiarCriterios()
                        Swal.fire({
                        icon: 'success',
                        title: 'Cliente guardado exitosamente',
                        showConfirmButton: false,
                        timer: 1500
                    })
                    })
                    .catch(error=>{
                        console.log(error.response)
                        if(error.response.status == 401){
                            this.$router.push({name: 'login'})
                            location.reload()
                            sessionStorage.clear()
                            this.fullscreenLoading = false
                        }
                    })
            }
        },
        validarRegistrarCliente(){
            this.mensajeError = []

            if(!this.validEmail){
                this.mensajeError.push('Introduzca un correo válido')
            }
            if(!this.fillCrearCliente.cEmail){
                this.mensajeError.push('El campo correo es obligatorio')
            }
            if(!this.fillCrearCliente.cDocumento){
                this.mensajeError.push('El campo Documento es obligatorio')
            }
            if(!this.fillCrearCliente.cNombre){
                this.mensajeError.push('El campo Nombre es obligatorio')
            }
            if(!this.fillCrearCliente.cApellido){
                this.mensajeError.push('El campo Apellido es obligatorio')
            }

            if(this.mensajeError.length){
                this.modalShow = true
                return false
            }else{
                return true
            }
        }
    }
}
</script>

<style>
    .scrollTable{
        max-height: 350px;
        overflow: auto !important;
    }
    .modal{
        overflow: auto !important;
    }
    .el-autocomplete{
        width: 100% !important;
    }
    .vs-input{
        width: 100% !important;
        border-radius: .25rem !important;
        border: 1px solid #ced4da;
    }
    .vs-tooltip-content{
        width: min-content;
    }
    .el-row {
        margin-bottom: 20px;
        &:last-child {
            margin-bottom: 0;
        }
    }
    .el-col {
        border-radius: 4px;
    }
    .bg-purple-dark {
        background: #99a9bf;
    }
    .bg-purple {
        background: #d3dce6;
    }
    .bg-purple-light {
        background: #e5e9f2;
    }
    .grid-content {
        border-radius: 4px;
        min-height: 36px;
    }
    .row-bg {
        padding: 10px 0;
        background-color: #f9fafc;
    }
    .btnFullWidth {
        width: 100% !important;
    }
</style>
