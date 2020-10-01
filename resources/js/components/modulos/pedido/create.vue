<template>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Crear Pedido</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->

        <div class="content container-fluid">
            <div class="card">
                <div class="card-header">
                    <div class="card-tools">
                        <router-link class="btn btn-info btn-sm" :to="'/pedido'">
                            <i class="fas fa-arrow-left"></i> Regresar
                        </router-link>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-4">
                        <div class="card" :class="(switchCliente) ? 'card-info' : 'card-success'">
                            <div class="card-header">
                                <h3 class="card-title">Formulario {{(switchCliente) ? 'Registrar' : 'Buscar'}}  Cliente</h3>
                            </div>
                            <div class="card-body">
                                <form role="form ">
                                    <div class="row">

                                        <vs-switch square color="grey" v-model="switchCliente" @change="limpiarCriterios">
                                            <template #off>
                                                <i class="fas fa-plus-square"></i>
                                            </template>
                                            <template #on>
                                                <i class="fas fa-search"></i>
                                            </template>
                                        </vs-switch>

                                        <div class="col-md-12">
                                            <div class="form-group row">
                                                <label for="" class="col-md-12 col-form-label">Documento</label>
                                                <template v-if="switchCliente">
                                                    <div class="col-md-12">
                                                        <input type="text" class="form-control" v-model="fillCrearCliente.cDocumento" @keyup.enter="setRegistrarPedido">
                                                    </div>
                                                </template>
                                                <template v-else>
                                                    <el-autocomplete
                                                        class="inline-input"
                                                        v-model="cBuscar"
                                                        :fetch-suggestions="querySearch"
                                                        placeholder="Please Input"
                                                        :trigger-on-focus="true"
                                                        size="medium"
                                                        @select="handleSelect">
                                                        <i
                                                            class="el-icon-search el-input__icon"
                                                            slot="suffix">
                                                        </i>
                                                    </el-autocomplete>
                                                </template>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group row">
                                                <label for="" class="col-md-12 col-form-label">Nombre</label>
                                                <div class="col-md-12">
                                                    <input type="text" class="form-control" v-model="fillCrearCliente.cNombre" @keyup.enter="setRegistrarPedido" :disabled="(switchCliente) ? false : true">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group row">
                                                <label for="" class="col-md-12 col-form-label">Apellido</label>
                                                <div class="col-md-12">
                                                    <input type="text" class="form-control" v-model="fillCrearCliente.cApellido" @keyup.enter="setRegistrarPedido" :disabled="(switchCliente) ? false : true">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group row">
                                                <label for="" class="col-md-12 col-form-label">Correo</label>
                                                <div class="col-md-12">
                                                    <vs-input v-model="fillCrearCliente.cEmail" placeholder="correo@email.com" :disabled="(switchCliente) ? false : true">
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
                                        <div class="col-md-12">
                                            <div class="form-group row">
                                                <label for="" class="col-md-12 col-form-label">Teléfono</label>
                                                <div class="col-md-12">
                                                    <input type="text" class="form-control" v-model="fillCrearCliente.cTelefono" @keyup.enter="setRegistrarPedido" :disabled="(switchCliente) ? false : true">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-md-12">
                                        <button class="btn btn-flat btn-info btnWidth" v-loading.fullscreen.lock="fullscreenLoading" @click.prevent="setRegistrarPedido">Registrar</button>
                                        <button class="btn btn-flat btn-default btnWidth" @click.prevent="limpiarCriterios">Limpiar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title">Listar Permiso</h3>
                            </div>
                            <div class="card-body">
                                <div class="scrollTable">
                                    <table class="table table-hover table-head-fixed text-nowrap projects">
                                        <thead>
                                            <th>Acción</th>
                                            <th>Nombre</th>
                                            <th>Url Amigable</th>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(item, index) in listPermisosFilter" :key="index" @click.prevent="marcarFila(index)">
                                                <td>
                                                    <el-checkbox v-model="item.checked"/>
                                                </td>
                                                <td v-text="item.name"></td>
                                                <td v-text="item.slug"></td>
                                            </tr>
                                        </tbody>
                                    </table>
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
                nIdCliente: '',
                cDocumento: '',
                cNombre: '',
                cApellido: '',
                cEmail: '',
                cTelefono: ''
            },
            listPermisosFilter: [],
            listPermisos:[],
            form: new FormData,
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
            switchCliente: false,
        }
    },
    computed:{
    },
    mounted(){
        this.getListarPermisosByRol()
        this.getListarClientes()
    },
    computed:{
        validEmail() {
          return /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(this.fillCrearCliente.cEmail)
        }
    },
    methods:{
        querySearch(queryString, cb) {
            var links = this.filterListarClientes;
            var results = queryString ? links.filter(this.createFilter(queryString)) : links;
            // call callback function to return suggestions
            cb(results);
        },
        createFilter(queryString) {
            return (link) => {
                return (link.value.toLowerCase().indexOf(queryString.toLowerCase()) != -1);
            };
        },
        handleSelect(item) {
            let rpta = this.listClientes.filter(cliente => {
                return ((String(cliente.id)).indexOf(String(item.link)) != -1)
            })
            console.log(rpta);
            this.fillCrearCliente.nIdCliente = rpta[0].id
            this.fillCrearCliente.cDocumento = rpta[0].document
            this.fillCrearCliente.cNombre = rpta[0].name
            this.fillCrearCliente.cApellido = rpta[0].lastname
            this.fillCrearCliente.cEmail = rpta[0].email
            this.fillCrearCliente.cTelefono = rpta[0].phone
        },
        getListarClientes(){
                let url = '/operacion/cliente/getListarClientes'
                axios.get(url)
                    .then(res=>{
                        this.listClientes = res.data
                        this.filtrarClientes()
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
        },
        filtrarClientes(){
            let me = this
            me.filterListarClientes = []
            me.listClientes.map(function(x,y){
                me.filterListarClientes.push({
                    'value' : x.document + ' - ' + x.fullname,
                    'link'  : x.id
                })
            })
        },
        getListarPermisosByRol(){
            let url = '/administracion/rol/getListarPermisosByRol'
            axios.get(url)
                .then(res=>{
                    //console.log(res.data)
                    this.listPermisos = res.data
                    console.log(this.listPermisos[0].name)
                    this.filtarPermisosByRol()
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
        },
        limpiarCriterios(){
            this.fillCrearCliente.nIdCliente = ''
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
        filtarPermisosByRol(){
            let me = this
            me.listPermisos.map(function(x,y){
                me.listPermisosFilter.push({
                    'id': x.id,
                    'name': x.name,
                    'slug': x.slug,
                    'checked': false
                })
                //console.log(x+' - '+y)
            })
        },
        setRegistrarPedido(){
             if(this.validarRegistrarPedido()){
                this.modalShow = true
                console.log(this.mensajeError)
                return
            }
            if(this.switchCliente){
                this.setRegistrarCliente()
            }
            let url = '/operacion/pedidos/setRegistrarPedido'
            this.fullscreenLoading = true
            let params = {
                    'cNombre': this.fillCrearCliente.cNombre,
                    'cSlug': this.fillCrearCliente.cSlug,
                    'listPermisosFilter': this.listPermisosFilter
                }
            // axios.post(url, params)
            //     .then(res=>{
            //         console.log(res)
            //         console.log("Guardado Exitosamente")
            //         this.fullscreenLoading = false
            //         this.$router.push('/rol')
            //     })
            //     .catch(error=>{
            //         console.log(error.response)
            //         if(error.response.status == 401){
            //             this.$router.push({name: 'login'})
            //             location.reload()
            //             sessionStorage.clear()
            //             this.fullscreenLoading = false
            //         }
            //     })

        },
        setRegistrarCliente(){
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
                    console.log(res.data)
                    this.getListarClientes()
                    this.fullscreenLoading = false
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
        },
        marcarFila(index){
            console.log(this.listPermisosFilter[index])
            this.listPermisosFilter[index].checked = !this.listPermisosFilter[index].checked
        },
        validarRegistrarPedido(){
            this.error = 0
            this.mensajeError = []

            if(this.switchCliente){

                if(!this.fillCrearCliente.cDocumento){
                    this.mensajeError.push('El documento es un campo obligatorio')
                }
                if(!this.fillCrearCliente.cNombre){
                    this.mensajeError.push('El nombre es un campo obligatorio')
                }
                if(!this.fillCrearCliente.cApellido){
                    this.mensajeError.push('El apellido es un campo obligatorio')
                }
                if(this.fillCrearCliente.cEmail){
                    if(!this.validEmail){
                        this.mensajeError.push('El email es inválido')
                    }
                }
                // if(!this.fillCrearCliente.cTelefono){
                //     this.mensajeError.push('El teléfono es un campo obligatorio')
                // }
            }else{

                if(!this.fillCrearCliente.nIdCliente){
                    this.mensajeError.push('El cliente es un campo obligatorio')
                }
            }

            if(this.mensajeError.length){
                this.error = true
            }
            return this.error
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
</style>
