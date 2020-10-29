<template>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Cliente</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->

        <div class="content container-fluid">
            <div class="card">
                <div class="card-header">
                    <div class="card-tools">
                        <template v-if="listRolPermisosByUsuario.includes('cliente.crear')">
                            <router-link class="btn btn-info btn-sm" :to="{name: 'cliente.crear'}">
                                <i class="fas fa-plus-square"></i> Nuevo Cliente
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
                                            <input type="text" class="form-control" v-model="fillBsqCliente.cNombre" v-loading.fullscreen.lock="fullscreenLoading" @keyup.enter="getListaClientes">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label for="" class="col-md-3 col-form-label">#Documento</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" v-model="fillBsqCliente.cDocumento" v-loading.fullscreen.lock="fullscreenLoading" @keyup.enter="getListaClientes">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-4 offset-4">
                                <button class="btn btn-flat btn-info btnWidth" v-loading.fullscreen.lock="fullscreenLoading" @click.prevent="getListaClientes">Buscar</button>
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
                        <template v-if="listClientesPaginate.length">
                        <table class="table table-hover table-head-fxed text-nowrap projects">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Documento</th>
                                    <th>Correo</th>
                                    <th>Teléfono</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(item, index) in listClientesPaginate" :key="index">
                                    <td v-text="item.fullname"></td>
                                    <td v-text="item.document"></td>
                                    <td v-text="item.email"></td>
                                    <td v-text="item.phone"></td>
                                    <td>
                                        <template v-if="listRolPermisosByUsuario.includes('cliente.editar')">
                                            <router-link :to="{name:'cliente.editar', params: {id: item.id}}" class="btn btn-flat btn-info btn-sm">
                                                <i class="fas fa-pencil-alt"></i> Editar
                                            </router-link>
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
            fillBsqCliente: {
                cNombre: '',
                cDocumento: ''
            },
            listRolPermisosByUsuario: JSON.parse(sessionStorage.getItem('listRolPermisosByUsuario')),
            listClientes:[],
            pageNumber: 0,
            perPage: 5,
            fullscreenLoading: false
        }
    },
    mounted(){
        this.getListaClientes()
    },
    computed:{
        pageCount(){
            let a = this.listClientes.length,
                b = this.perPage
            return Math.ceil(a/b)
        },
        listClientesPaginate(){
            let inicio  = this.pageNumber * this.perPage,
                fin     = inicio + this.perPage
            return this.listClientes.slice(inicio, fin)
        },
        pagesList(){
            let a = this.listClientes.length,
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

            this.fillBsqCliente.cNombre = '';
            this.fillBsqCliente.cDocumento= '';
        },
        getListaClientes(){
            let url = '/operacion/cliente/getListaClientes'
            this.fullscreenLoading = true
            let params = {
                'cNombre': this.fillBsqCliente.cNombre,
                'cDocumento': this.fillBsqCliente.cDocumento
            }
            axios.get(url, {params: params})
                .then( res => {
                    this.pageNumber = 0
                    this.listClientes = res.data
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
        }

    }
}
</script>

<style>

</style>
