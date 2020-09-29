<template>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Categoria</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->

        <div class="content container-fluid">
            <div class="card">
                <div class="card-header">
                    <div class="card-tools">
                        <template v-if="listRolPermisosByUsuario.includes('categoria.crear')">
                            <router-link class="btn btn-info btn-sm" :to="{name: 'categoria.crear'}">
                                <i class="fas fa-plus-square"></i> Nueva Categoria
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
                                            <input type="text" class="form-control" v-model="fillBsqCategoria.cNombre" v-loading.fullscreen.lock="fullscreenLoading" @keyup.enter="getListaCategorias">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label for="" class="col-md-3 col-form-label">Descripción</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" v-model="fillBsqCategoria.cUsuario" v-loading.fullscreen.lock="fullscreenLoading" @keyup.enter="getListaCategorias">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-4 offset-4">
                                <button class="btn btn-flat btn-info btnWidth" v-loading.fullscreen.lock="fullscreenLoading" @click.prevent="getListaCategorias">Buscar</button>
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
                        <template v-if="listCategoriasPaginate.length">
                        <table class="table table-hover table-head-fxed text-nowrap projects">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Descripción</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(item, index) in listCategoriasPaginate" :key="index">
                                    <td v-text="item.name"></td>
                                    <td v-text="item.description"></td>
                                    <td>
                                        <template v-if="listRolPermisosByUsuario.includes('categoria.editar')">
                                            <router-link :to="{name:'categoria.editar', params: {id: item.id}}" class="btn btn-flat btn-info btn-sm">
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
            fillBsqCategoria: {
                cNombre: '',
                cDescripcion: ''
            },
            listRolPermisosByUsuario: JSON.parse(sessionStorage.getItem('listRolPermisosByUsuario')),
            listCategorias:[],
            pageNumber: 0,
            perPage: 5,
            fullscreenLoading: false
        }
    },
    mounted(){
        this.getListaCategorias()
    },
    computed:{
        pageCount(){
            let a = this.listCategorias.length,
                b = this.perPage
            return Math.ceil(a/b)
        },
        listCategoriasPaginate(){
            let inicio  = this.pageNumber * this.perPage,
                fin     = inicio + this.perPage
            return this.listCategorias.slice(inicio, fin)
        },
        pagesList(){
            let a = this.listCategorias.length,
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

            this.fillBsqCategoria.cNombre = '';
            this.fillBsqCategoria.cDescripcion= '';
        },
        limpiarBandejaUsuarios(){
            this.listCategorias   = []
        },
        getListaCategorias(){
            let url = '/configuracion/categoria/getListaCategorias'
            let params = {
                // 'nIdCategoria': null,
                'cNombre': this.fillBsqCategoria.cNombre,
                'cDescripcion': this.fillBsqCategoria.cDescripcion
            }
            this.fullscreenLoading = true
            axios.get(url, {
                    params: params
                })
                .then( res => {
                    // console.log(JSON.parse(sessionStorage.getItem('listRolPermisosByUsuario')))
                    this.pageNumber = 0
                    this.listCategorias = res.data
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
