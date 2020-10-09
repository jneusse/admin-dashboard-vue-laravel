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
                                    <div v-if="fTotalPedido > 0 && listPedidos.length > 0" class="col-md-12">
                                        <button class="btn btn-flat btn-info btnFullWidth" v-loading.fullscreen.lock="fullscreenLoading" @click.prevent="setRegistrarPedido">Registrar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title">Selecionar productos</h3>
                            </div>
                            <div class="card-body">
                                    <vs-tooltip not-arrow right>
                                        <vs-button
                                            square
                                            icon
                                            color="rgb(59,222,200)"
                                            gradient
                                            @click.prevent="agregarProducto">
                                            <i class="fas fa-plus-square"></i>
                                        </vs-button>
                                        <template #tooltip>
                                            Agregar producto
                                        </template>
                                    </vs-tooltip>
                                <template v-if="listPedidos.length">
                                    <div class="scrollTable">
                                        <table class="table table-hover table-head-fixed text-nowrap projects">
                                            <thead>
                                                <th>Artículo</th>
                                                <th>Stock</th>
                                                <th>Precio</th>
                                                <th>Subtotal</th>
                                                <th>Acciónes</th>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(item, index) in listPedidos" :key="index">
                                                    <td>
                                                        <el-select  v-model="item.nIdProducto"
                                                                    placeholder="Seleccione un producto"
                                                                    clearable
                                                                    filterable
                                                                    @change="obtenerProducto(item.nIdProducto, index)">
                                                            <el-option
                                                            v-for="item in listProductos"
                                                            :key="item.id"
                                                            :label="item.name"
                                                            :value="item.id">
                                                            </el-option>
                                                        </el-select>
                                                    </td>
                                                    <td>
                                                        <el-input-number v-model="item.nStock" controls-position="right"
                                                            :min="1"
                                                            :max="(item.nStock) ? item.nStockFlag : 1"></el-input-number>
                                                    </td>
                                                    <td v-text="item.fPrecio"></td>
                                                    <td>{{ item.fSubtotal = item.fPrecio * item.nStock}}</td>
                                                    <td>
                                                        <el-tooltip class="item" effect="dark" content="Eliminar" placement="left">
                                                            <vs-button
                                                                square
                                                                icon
                                                                danger
                                                                gradient
                                                                @click.prevent="removerProducto(index)">
                                                                <i class="fas fa-trash"></i>
                                                            </vs-button>
                                                        </el-tooltip>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <el-row :gutter="20">
                                        <el-col :span="16">
                                            <vs-input shadow v-model="cComentario" placeholder="Comentario" />
                                            </el-col>
                                        <el-col :span="8">
                                            <strong>Total:</strong> {{fTotalPedido = totalPedido}}
                                        </el-col>
                                    </el-row>
                                </template>
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
            fTotalPedido: 0,
            cComentario: '',
            listPermisosFilter: [],
            listPermisos:[],
            listPedidos:[],
            listProductos:[],
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
        this.agregarProducto()
        this.getListarClientes()
        this.getListarProductos()
    },
    computed:{
        validEmail() {
          return /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(this.fillCrearCliente.cEmail)
        },
        totalPedido(){
            return this.listPedidos.reduce(function(valorAnterior, valorActual) {
                return valorAnterior + parseFloat(valorActual.fSubtotal);
            },0)
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
            this.fillCrearCliente.nIdCliente = rpta[0].id
            this.fillCrearCliente.cDocumento = rpta[0].document
            this.fillCrearCliente.cNombre = rpta[0].name
            this.fillCrearCliente.cApellido = rpta[0].lastname
            this.fillCrearCliente.cEmail = rpta[0].email
            this.fillCrearCliente.cTelefono = rpta[0].phone
        },
        getListarProductos(){
                let url = '/configuracion/producto/getListaProductos'
                axios.get(url)
                    .then(res=>{
                        this.listProductos = res.data
                        // this.filtrarClientes()
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
        obtenerProducto(nIdProducto, index){
            let count = 0
            let me = this
                if(!nIdProducto){
                    Vue.nextTick(function() {
                        me.listPedidos[index].nStock = ''
                        me.listPedidos[index].nStockFlag = ''
                        me.listPedidos[index].fPrecio = ''
                    })
                }
            this.listPedidos.map(function(x,y){
                if(x.nIdProducto == nIdProducto && y != index ){
                    count++
                    const noti = me.$vs.notification({
                        border: true,
                        position: 'top-center',
                        color: 'warning',
                        title: 'Atención',
                        text: `El producto ya se encuentra agregado`
                    })
                }
            })
            if(count == 0){
                let rpta = this.listProductos.filter(producto => {
                    return ((String(producto.id)).indexOf(String(nIdProducto)) != -1)
                })
                this.listPedidos[index].nStock = rpta[0].stock
                this.listPedidos[index].nStockFlag = rpta[0].stock
                this.listPedidos[index].fPrecio = rpta[0].price
            }else{
                this.listPedidos[index].nIdProducto = ''
            }

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
        agregarProducto(){
            if(this.listPedidos.length == 0){
                this.listPedidos.push({
                    'nIdProducto': '',
                    'nStock': '',
                    'nStockFlag': '',
                    'fPrecio': '',
                    'fSubtotal': '',
                })
            }else{
                let me = this
                let count = 0
                this.listPedidos.map(function(x,y){
                    if(!x.nIdProducto || !x.nStock || !x.fPrecio || !x.fSubtotal){
                        count++
                        const noti = me.$vs.notification({
                            border: true,
                            position: 'top-center',
                            color: 'warning',
                            title: 'Atención',
                            text: `Debe completar la información antes de agregar un nuevo producto`
                        })
                    }
                })
                if(count == 0){
                    this.listPedidos.push({
                        'nIdArticulo': '',
                        'nStock': '',
                        'nStockFlag': '',
                        'fPrecio': '',
                        'fSubtotal': '',
                    })
                }
            }
        },
        removerProducto(index){
            this.$delete(this.listPedidos, index)
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
        setRegistrarPedido(){
             if(this.validarRegistrarPedido()){
                this.modalShow = true
                console.log(this.mensajeError)
                return
            }
            if(this.switchCliente){
                this.setRegistrarCliente()
                console.log('setRegistrarCliente primero')
            }else{
                console.log('setGuardarPedido primero')
                let nIdCliente = this.fillCrearCliente.nIdCliente
                this.setGuardarPedido(nIdCliente)
            }

        },
        setGenerarDocumento(nIdPedido){
            const loading = this.$vs.loading()
            let url = '/operacion/pedidos/setGenerarDocumento'
            let params = {
                'nIdPedido': nIdPedido
            }
            const config = {
                responseType: 'blob'
            }
            axios.post(url, params, config)
                .then( res => {
                    console.log(res.data)
                    var oMyBlob = new Blob([res.data], {type : 'application/pdf'}); // the blob
                    let url = URL.createObjectURL(oMyBlob);
                    window.open(url)
                    loading.close()
                    Swal.fire({
                        icon: 'success',
                        title: 'Pedido guardado exitosamente',
                        showConfirmButton: false,
                        timer: 1500
                    })
                    this.$router.push({name: 'pedido.index'})
                })
                .catch(error=>{
                    console.log(error.response)
                    if(error.response.status == 401){
                        this.$router.push({name: 'login'})
                        sessionStorage.clear()
                        location.reload()
                        loading.close()
                    }
                })
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
                    this.fullscreenLoading = false
                    let nIdCliente = res.data[0].nIdCliente
                    this.getListarClientes()
                    this.setGuardarPedido(nIdCliente)
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
        setGuardarPedido(nIdCliente){
            let url = '/operacion/pedido/setRegistrarPedido'
            this.fullscreenLoading = true
            let params = {
                    'nIdCliente': nIdCliente,
                    'cComentario': this.cComentario,
                    'fTotalPedido': this.fTotalPedido,
                    'listPedido': this.listPedidos
                }
                // return console.log(params)
            axios.post(url, params)
                .then(res=>{
                    this.fullscreenLoading = false
                    this.setGenerarDocumento(res.data)
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
