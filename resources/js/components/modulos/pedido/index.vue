<template>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Pedido</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->

        <div class="content container-fluid">
            <div class="card">
                <div class="card-header">
                    <div class="card-tools">
                        <template v-if="listRolPermisosByUsuario.includes('pedido.crear')">
                            <router-link class="btn btn-info btn-sm" :to="{name: 'pedido.crear'}">
                                <i class="fas fa-plus-square"></i> Nuevo Pedido
                            </router-link>
                        </template>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="container-fluid">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Criterios de Búsquedad</h3>
                    </div>
                    <div class="card-body">
                        <form role="form ">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label for="" class="col-md-3 col-form-label">Nombre</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" v-model="fillBsqPedido.cNombre" v-loading.fullscreen.lock="fullscreenLoading" @keyup.enter="getListaPedidos">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label for="" class="col-md-3 col-form-label">#Documento</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" v-model="fillBsqPedido.cDocumento" v-loading.fullscreen.lock="fullscreenLoading" @keyup.enter="getListaPedidos">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label for="" class="col-md-3 col-form-label">#Pedido</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" v-model="fillBsqPedido.cPedido" v-loading.fullscreen.lock="fullscreenLoading" @keyup.enter="getListaPedidos">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label for="" class="col-md-3 col-form-label">Estado</label>
                                        <div class="col-md-9">
                                              <el-select v-model="fillBsqPedido.nIdCategoria" placeholder="Select" clearable>
                                                <el-option
                                                v-for="item in listEstados"
                                                :key="item.value"
                                                :label="item.label"
                                                :value="item.value">
                                                </el-option>
                                            </el-select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-4 offset-4">
                                <button class="btn btn-flat btn-info btnWidth" v-loading.fullscreen.lock="fullscreenLoading" @click.prevent="getListaPedidos">Buscar</button>
                                <button class="btn btn-flat btn-default btnWidth" v-loading.fullscreen.lock="fullscreenLoading" @click.prevent="limpiarCriteriosBsq">Limpiar</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Bandeja de resultados</h3>
                    </div>
                    <div class="card-body table-responsive">
                        <template v-if="listPedidosPaginate.length">
                        <table class="table table-hover table-head-fxed text-nowrap projects">
                            <thead>
                                <tr>
                                    <th>#Pedido</th>
                                    <th>#Documento</th>
                                    <th>Cliente</th>
                                    <th>Total</th>
                                    <th>Vendedor</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(item, index) in listPedidosPaginate" :key="index">
                                    <td v-text="item.pedido"></td>
                                    <td v-text="item.documento"></td>
                                    <td v-text="item.cliente"></td>
                                    <td v-text="item.total"></td>
                                    <td v-text="item.vendedor"></td>
                                    <td>
                                        <template v-if="item.state == 'A'">
                                            <span class="badge badge-success">Activo</span>
                                        </template>
                                        <template v-else>
                                            <span class="badge badge-danger">Rechazado</span>
                                        </template>
                                    </td>
                                    <td>
                                        <template v-if="listRolPermisosByUsuario.includes('pedido.ver')">
                                            <button class="btn btn-flat btn-info btn-sm" @click.prevent="setGenerarDocumento(item.id)">
                                                <i class="fas fa-file-pdf"></i> Ver PDF
                                            </button>
                                        </template>
                                        <template v-if="listRolPermisosByUsuario.includes('pedido.rechazar')">
                                            <button v-if="item.state == 'A'" class="btn btn-flat btn-danger btn-sm" @click.prevent="setCambiarEstado(1, item.id)">
                                                <i class="fas fa-trash"></i> Rechazar
                                            </button>
                                        </template>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        </template>
                        <template v-else>
                            <div class="callout callout-info">
                                <h5>No se encontraron registros</h5>
                            </div>
                        </template>
                        <div class="card-footer clearfix">
                            <ul class="pagination pagination-sm m-0 float-right">
                                <li class="page-item" v-if="pageNumber > 0">
                                    <a href="" class="page-link" @click.prevent="prevPage">Anterior</a>
                                </li>
                                <li class="page-item" v-for="(page, index) in pagesList" :key="index"
                                :class="[page == pageNumber ? 'active' : '']">
                                    <a href="" class="page-link" @click.prevent="selectPage(page)">{{ page+1 }}</a>
                                </li>
                                <li class="page-item" v-if="pageNumber < pageCount - 1">
                                    <a href="" class="page-link" @click.prevent="nextPage">Next</a>
                                </li>
                            </ul>
                        </div>
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
            fillBsqPedido: {
                cNombre: '',
                cDocumento: '',
                cPedido: '',
                cCliente: '',
                cEstado: ''
            },
            listRolPermisosByUsuario: JSON.parse(sessionStorage.getItem('listRolPermisosByUsuario')),
            listEstados:[
                { value: 'A', label: 'Activo' },
                { value: 'I', label: 'Inactivo' }
            ],
            listPedidos:[],
            pageNumber: 0,
            perPage: 5,
            fullscreenLoading: false
        }
    },
    mounted(){
        this.getListaPedidos()
    },
    computed:{
        pageCount(){
            let a = this.listPedidos.length,
                b = this.perPage
            return Math.ceil(a/b)
        },
        listPedidosPaginate(){
            let inicio  = this.pageNumber * this.perPage,
                fin     = inicio + this.perPage
            return this.listPedidos.slice(inicio, fin)
        },
        pagesList(){
            let a = this.listPedidos.length,
                b = this.perPage
            let pageCount = Math.ceil(a/b)
            let count = 0,
                pagesArray = []

            while (count < pageCount){
                pagesArray.push(count)
                count++
            }
            return pagesArray
        }
    },
    methods:{
        limpiarCriteriosBsq(){

            this.fillBsqPedido.cNombre = '';
            this.fillBsqPedido.cDocumento= '';
            this.fillBsqPedido.cPedido= '';
            this.fillBsqPedido.cCliente= '';
            this.fillBsqPedido.cEstado= '';
        },
        limpiarBandejaUsuarios(){
            this.listEstados   = []
        },
        getListaPedidos(){
            let url = '/operacion/pedidos/getListaPedidos'
            this.fullscreenLoading = true
            let params = {
                'cNombre': this.fillBsqPedido.cNombre,
                'cDocumento': this.fillBsqPedido.cDocumento,
                'cPedido': this.fillBsqPedido.cPedido,
                'cCliente': this.fillBsqPedido.cCliente,
                'cEstado': this.fillBsqPedido.cEstado
            }
            axios.get(url, {params: params})
                .then( res => {
                    this.pageNumber = 0
                    this.listPedidos = res.data
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
        nextPage(){
            this.pageNumber++
        },
        prevPage(){
            this.pageNumber--
        },
        selectPage(page){
            this.pageNumber = page
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
        setCambiarEstado(op, id){
            Swal.fire({
                    title: '¿Estás seguro de '+((op == 1) ? 'rechazar' : 'activar' )+ 'el pedido?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: ((op == 1) ? 'Si, rechazar' : 'Si, activar')
                }).then((result) => {
                    if (result.isConfirmed) {
                        !this.fullscreenLoading
                        let url = '/operacion/pedido/setCambiarEstadoPedido'
                        axios.post(url, {
                            'nIdPedido': id,
                            'cEstado': (op == 1) ? 'I' : 'A'
                        })
                        .then(res=>{
                            Swal.fire({
                                icon: 'success',
                                title: 'Se '+((op == 1) ? 'rechazó' : 'activó')+' el pedido exitosamente',
                                showConfirmButton: false,
                                timer: 1500
                            })
                            this.getListaPedidos()
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
                })
        }

    }
}
</script>

<style>

</style>
