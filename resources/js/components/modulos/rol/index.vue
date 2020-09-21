<template>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Roles</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->

        <div class="content container-fluid">
            <div class="card">
                <div class="card-header">
                    <div class="card-tools">
                        <router-link class="btn btn-info btn-sm" :to="'/rol/crear'">
                            <i class="fas fa-plus-square"></i> Nuevo Rol
                        </router-link>
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
                                            <input type="text" class="form-control" v-model="fillBsqRol.cNombre" v-loading.fullscreen.lock="fullscreenLoading" @keyup.enter="getListaRoles">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label for="" class="col-md-3 col-form-label">Url Amigable</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" v-model="fillBsqRol.cSlug" v-loading.fullscreen.lock="fullscreenLoading" @keyup.enter="getListaRoles">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-4 offset-4">
                                <button class="btn btn-flat btn-info btnWidth" v-loading.fullscreen.lock="fullscreenLoading" @click.prevent="getListaRoles">Buscar</button>
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
                        <template v-if="listRolesPaginate.length">
                        <table class="table table-hover table-head-fxed text-nowrap projects">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Url Amigable</th>
                                    <th>Aciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(item, index) in listRolesPaginate" :key="index">
                                    <td v-text="item.name"></td>
                                    <td v-text="item.slug"></td>
                                    <td>
                                        <button class="btn btn-flat btn-primary btn-sm" @click.prevent="abrirModalByOption('rol', 'ver', item)">
                                            <i class="fas fa-folder"></i> Ver
                                        </button>
                                        <router-link :to="{name:'rol.editar', params: {id: item.id}}" class="btn btn-flat btn-info btn-sm">
                                            <i class="fas fa-pencil-alt"></i> Editar
                                        </router-link>
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

        <div class="modal fade" :class="{ show: modalShow }" :style=" modalShow ? mostrarModal : ocultarModal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Sistema Laravel VUE</h5>
                        <button class="close" @click="abrirModal()"></button>
                    </div>
                    <div class="modal-body">
                        <template v-if="modalOption == 1">
                            <div class="callout callout-danger" style="padding: 5px" v-for="(item, index) in mensajeError" :key="index" v-text="item"></div>
                        </template>
                        <template v-if="modalOption == 2">
                            <div class="container-fluid">
                                <div class="card card-info">
                                    <div class="card-header">
                                        <h3 class="card-title">Nombre</h3>
                                    </div>
                                    <div class="card-body">
                                        <form role="form ">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group row">
                                                        <label for="" class="col-md-3 col-form-label">Nombre</label>
                                                        <div class="col-md-12">
                                                            <span type="text" class="form-control" v-text="fillVerRol.cNombre" v-loading.fullscreen.lock="fullscreenLoading" @keyup.enter="getListaRoles"/>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group row">
                                                        <label for="" class="col-md-3 col-form-label">Url Amigable</label>
                                                        <div class="col-md-12">
                                                            <span type="text" class="form-control" v-text="fillVerRol.cSlug" v-loading.fullscreen.lock="fullscreenLoading" @keyup.enter="getListaRoles"/>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="card card-info">
                                    <div class="card-header">
                                        <h3 class="card-title">Lista permisos</h3>
                                    </div>
                                    <div class="card-body table-responsive">
                                        <template v-if="listPermisos.length">
                                            <div class="scrollTable">
                                                <table class="table table-hover table-head-fixed text-nowrap projects">
                                                    <thead>
                                                        <tr>
                                                            <th>Nombre</th>
                                                            <th>Url Amigable</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr v-for="(item, index) in listPermisos" :key="index">
                                                            <td v-text="item.name"></td>
                                                            <td v-text="item.slug"></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </template>
                                        <template v-else>
                                            <div class="callout callout-info">
                                                <h5>No se encontraron registros</h5>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" @click="abrirModal()">Cerrar</button>
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
            fillBsqRol: {
                cNombre: '',
                cSlug: ''
            },
            fillVerRol: {
                cNombre: '',
                cSlug: ''
            },
            listPermisos: [],
            listRoles:[],
            pageNumber: 0,
            perPage: 5,
            fullscreenLoading: false,
            modalShow: false,
            mostrarModal:{
                display: 'block',
                background: '#0000006b',
            },
            ocultarModal:{
                display: 'none',
            },
            modalOption: 0,
        }
    },
    computed:{
        pageCount(){
            let a = this.listRoles.length,
                b = this.perPage
            return Math.ceil(a/b)
        },
        listRolesPaginate(){
            let inicio  = this.pageNumber * this.perPage,
                fin     = inicio + this.perPage
            return this.listRoles.slice(inicio, fin)
        },
        pagesList(){
            let a = this.listRoles.length,
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

            this.fillBsqRol.cNombre = '';
            this.fillBsqRol.cUsuario = '';
            this.fillBsqRol.cCorreo = '';
            this.fillBsqRol.cEstado = '';
        },
        limpiarBandejaUsuarios(){
            this.listRoles   = []
        },
        getListaRoles(){
            let url = '/administracion/rol/getListaRoles'
            let params = {
                'cNombre': this.fillBsqRol.cNombre,
                'cSlug': this.fillBsqRol.cUsuario
            }
            this.fullscreenLoading = true
            axios.get(url, {
                params: params
            })
            .then( res => {
                //console.log(res.data)
                this.pageNumber = 0
                this.listRoles = res.data
                this.fullscreenLoading = false
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
        getListarPermisosByRol(id){
            let url = '/administracion/rol/getListarPermisosByRol'
            let params = {
                'nIdRol': id
            }
            axios.get(url, {params: params})
                .then(res=>{
                    console.log('getListarPermisosByRol: '+ res.data)
                    this.listPermisos = res.data
                    // console.log(this.listPermisos[0].name)
                    this.modalShow = true
                    this.modalOption = 2
            })
        },
        abrirModal(){
            this.modalShow = !this.modalShow
        },
        limpiarModal(){
            this.fillVerRol.cNombre = ''
            this.fillVerRol.cSlug = ''
            this.listPermisos = []
            this.modalOption = 0
        },
        abrirModalByOption(modulo, accion, data){
            switch (modulo) {
                case 'rol':{
                    switch (accion) {
                        case 'ver':{
                            // console.log('data: '+data.slug)
                            this.fillVerRol.cNombre = data.name
                            this.fillVerRol.cSlug = data.slug
                            this.getListarPermisosByRol(data.id)
                        }

                            break;

                        default:
                            break;
                    }
                }

                    break;

                default:
                    break;
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
</style>
