<template>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Permisos</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->

        <div class="content container-fluid">
            <div class="card">
                <div class="card-header">
                    <div class="card-tools">
                        <router-link class="btn btn-info btn-sm" :to="'/permiso/crear'">
                            <i class="fas fa-plus-square"></i> Nuevo Permiso
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
                                            <input type="text" class="form-control" v-model="fillBsqPermiso.cNombre" v-loading.fullscreen.lock="fullscreenLoading" @keyup.enter="getListarPermisos">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label for="" class="col-md-3 col-form-label">Url Amigable</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" v-model="fillBsqPermiso.cSlug" v-loading.fullscreen.lock="fullscreenLoading" @keyup.enter="getListarPermisos">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-4 offset-4">
                                <button class="btn btn-flat btn-info btnWidth" v-loading.fullscreen.lock="fullscreenLoading" @click.prevent="getListarPermisos">Buscar</button>
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
                                        <router-link :to="{name:'permiso.editar', params: {id: item.id}}" class="btn btn-flat btn-info btn-sm">
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



    </div>
</template>

<script>
export default {
    data(){
        return{
            fillBsqPermiso: {
                cNombre: '',
                cSlug: ''
            },
            listPermisos: [],
            listRoles:[],
            pageNumber: 0,
            perPage: 5,
            fullscreenLoading: false
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

            this.fillBsqPermiso.cNombre = '';
            this.fillBsqPermiso.cUsuario = '';
            this.fillBsqPermiso.cCorreo = '';
            this.fillBsqPermiso.cEstado = '';
        },
        limpiarBandejaUsuarios(){
            this.listRoles   = []
        },
        getListarPermisos(){
            let url = '/administracion/permiso/getListarPermisos'
            let params = {
                'cNombre': this.fillBsqPermiso.cNombre,
                'cSlug': this.fillBsqPermiso.cSlug
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
