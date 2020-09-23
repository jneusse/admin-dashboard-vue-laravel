<template>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Usuario</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->

        <div class="content container-fluid">
            <div class="card">
                <div class="card-header">
                    <div class="card-tools">
                        <router-link class="btn btn-info btn-sm" :to="'/usuario/crear'">
                            <i class="fas fa-plus-square"></i> Nuevo Usuario
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
                                            <input type="text" class="form-control" v-model="fillBsqUsuario.cNombre" v-loading.fullscreen.lock="fullscreenLoading" @keyup.enter="getListaUsuarios">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label for="" class="col-md-3 col-form-label">Usuario</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" v-model="fillBsqUsuario.cUsuario" v-loading.fullscreen.lock="fullscreenLoading" @keyup.enter="getListaUsuarios">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label for="" class="col-md-3 col-form-label">Email</label>
                                        <div class="col-md-9">
                                            <input type="email" class="form-control" v-model="fillBsqUsuario.cCorreo" v-loading.fullscreen.lock="fullscreenLoading" @keyup.enter="getListaUsuarios">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label for="" class="col-md-3 col-form-label">Estado</label>
                                        <div class="col-md-9">
                                              <el-select v-model="fillBsqUsuario.cEstado" placeholder="Select" clearable>
                                                <el-option
                                                v-for="item in listEstado"
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
                                <button class="btn btn-flat btn-info btnWidth" v-loading.fullscreen.lock="fullscreenLoading" @click.prevent="getListaUsuarios">Buscar</button>
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
                        <template v-if="listUsuariosPaginate.length">
                        <table class="table table-hover table-head-fxed text-nowrap projects">
                            <thead>
                                <tr>
                                    <th>Fotografia</th>
                                    <th>Nombre</th>
                                    <th>Correo</th>
                                    <th>Usuario</th>
                                    <th>Estado</th>
                                    <th>Aciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(item, index) in listUsuariosPaginate" :key="index">
                                    <td>
                                        <template v-if="!item.profile_image">
                                            <li class="user-block">
                                                <img src="/img/avatar.png" :alt="item.username" class="profile-avatar-img img-fluid img-circle">
                                            </li>
                                        </template>
                                        <template v-else>
                                            <li class="user-block">
                                                <img :src="item.profile_image" :alt="item.username" class="profile-avatar-img img-fluid img-circle">
                                            </li>
                                        </template>
                                    </td>
                                    <td v-text="item.fullname">Juan</td>
                                    <td v-text="item.email">correo@email.com</td>
                                    <td v-text="item.username">juan123</td>
                                    <td>
                                        <template v-if="item.state == 'A'">
                                            <span class="badge badge-success">Activo</span>
                                        </template>
                                        <template v-else>
                                            <span class="badge badge-danger">Inactivo</span>
                                        </template>
                                    </td>
                                    <td>
                                        <router-link :to="{name:'usuario.ver', params: {id: item.id}}" class="btn btn-flat btn-primary btn-sm">
                                            <i class="fas fa-folder"></i> Ver
                                        </router-link>
                                        <template v-if="item.state == 'A'">
                                            <router-link :to="{name:'usuario.editar', params: {id: item.id}}" class="btn btn-flat btn-info btn-sm">
                                                <i class="fas fa-pencil-alt"></i> Editar
                                            </router-link>
                                            <router-link :to="{name:'usuario.permiso', params: {id: item.id}}" class="btn btn-flat btn-success btn-sm">
                                                <i class="fas fa-key"></i> Permiso
                                            </router-link>
                                            <button class="btn btn-flat btn-danger btn-sm" @click.prevent="setCambiarEstado(1, item.id)">
                                                <i class="fas fa-trash"></i> Desactivar
                                            </button>
                                        </template>
                                        <template v-else>
                                            <button class="btn btn-flat btn-success btn-sm" @click.prevent="setCambiarEstado(2, item.id)">
                                                <i class="fas fa-check"></i> Activar
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
            fillBsqUsuario: {
                cNombre: '',
                cUsuario: '',
                cCorreo: '',
                cEstado: ''
            },
            listUsuarios:[],
            listEstado:[
                {value:'A', label: 'Activo'},
                {value:'I', label: 'Inactivo'}
            ],
            pageNumber: 0,
            perPage: 5,
            fullscreenLoading: false
        }
    },
    computed:{
        pageCount(){
            let a = this.listUsuarios.length,
                b = this.perPage
            return Math.ceil(a/b)
        },
        listUsuariosPaginate(){
            let inicio  = this.pageNumber * this.perPage,
                fin     = inicio + this.perPage
            return this.listUsuarios.slice(inicio, fin)
        },
        pagesList(){
            let a = this.listUsuarios.length,
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

            this.fillBsqUsuario.cNombre = '';
            this.fillBsqUsuario.cUsuario = '';
            this.fillBsqUsuario.cCorreo = '';
            this.fillBsqUsuario.cEstado = '';
        },
        limpiarBandejaUsuarios(){
            this.listUsuarios   = []
        },
        getListaUsuarios(){
            let url = '/administracion/usuario/getListaUsuarios'
            let params = {
                'cNombre': this.fillBsqUsuario.cNombre,
                'cUsuario': this.fillBsqUsuario.cUsuario,
                'cCorreo': this.fillBsqUsuario.cCorreo,
                'cEstado': this.fillBsqUsuario.cEstado
            }
            this.fullscreenLoading = true
            axios.get(url, {
                params: params
            })
            .then( res => {
                // console.log(res)
                this.pageNumber = 0
                this.listUsuarios = res.data
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
        setCambiarEstado(op, id){
            Swal.fire({
                title: '¿Estás seguro de '+((op == 1) ? 'desactivar' : 'activar' )+ 'el usuario?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: ((op == 1) ? 'Si, desactivar' : 'Si, activar')
                }).then((result) => {
                if (result.isConfirmed) {
                    !this.fullscreenLoading
                    let url = '/administracion/usuario/setCambiarEstadoUsuario'
                    axios.post(url, {
                        'nIdUsuario': id,
                        'cEstado': (op == 1) ? 'I' : 'A'
                    })
                    .then(res=>{
                        Swal.fire({
                            icon: 'success',
                            title: 'Se '+((op == 1) ? 'desactivó' : 'activó')+' el usuario exitosamente',
                            showConfirmButton: false,
                            timer: 1500
                        })
                        this.getListaUsuarios()
                    })
                }
            })
        }

    }
}
</script>

<style>

</style>
