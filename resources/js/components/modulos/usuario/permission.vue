<template>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Formulario asignar Permiso</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->

        <div class="content container-fluid">
            <div class="card">
                <div class="card-header">
                    <div class="card-tools">
                        <router-link class="btn btn-info btn-sm" :to="'/usuarios'">
                            <i class="fas fa-arrow-left"></i> Regresar
                        </router-link>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-5">
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title">Listar Permiso del Rol {{ fillPermiso.cNombre }}</h3>
                            </div>
                            <div class="card-body">
                                <div class="scrollTable">
                                    <table class="table table-hover table-head-fixed text-nowrap projects">
                                        <thead>
                                            <th>Nombre</th>
                                            <th>Url Amigable</th>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(item, index) in listarPermisosByRolAsignado" :key="index">
                                                <td v-text="item.name"></td>
                                                <td v-text="item.slug"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title">Listar Permiso</h3>
                            </div>
                            <div class="card-body">
                                <div class="scrollTable">
                                    <table class="table table-hover table-head-fixed text-nowrap projects">
                                        <thead>
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
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-md-6 offset-4">
                                        <button class="btn btn-flat btn-info btnWidth" v-loading.fullscreen.lock="fullscreenLoading" @click.prevent="setRegistrarPermisosByUsuario">Guardar</button>
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
                fillPermiso:{
                    nIdUsuario: this.$attrs.id,
                    cNombre: ''
                },
                listarPermisosByRolAsignado:[],
                fillCrearRol: {
                    cNombre: '',
                    cSlug: ''
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
                mensajeError: []
            }
        },
        computed:{
        },
        mounted(){
            this.getListarPermisosByUsuarioAsignado()
            this.getListarPermisosByUsuario()
            this.getRolByUsuario()
        },
        methods:{
            getListarPermisosByUsuarioAsignado(){
                let url = '/administracion/usuario/getListarPermisosByUsuario'
                axios.get(url, {params:
                    {
                        'nIdUsuario': this.fillPermiso.nIdUsuario
                    }
                }).then(res=>{
                    // console.log('res.data')
                    this.listarPermisosByRolAsignado = res.data
                    // console.log(this.listPermisos[0].name)
                    this.filtarPermisosByUsuario()
                })
            },
            getRolByUsuario(){
                let url = '/administracion/usuario/getRolByUsuario'
                let params = {
                    'nIdUsuario': this.fillPermiso.nIdUsuario
                }
                axios.get(url, {
                    params: params
                })
                .then( res => {
                    // console.log(res.data)
                    this.fillPermiso.cNombre = (res.data.length == 0) ? '' : res.data[0].name
                })
            },
            getListarPermisosByUsuario(){
                let url = '/administracion/usuario/getListarPermisosByUsuario'
                axios.get(url,{params:
                    {
                        'nIdUsuario': this.fillPermiso.nIdUsuario
                    }
                }).then(res=>{
                    // console.log(res.data)
                    this.listPermisos = res.data
                    // console.log(this.listPermisos[0].name)
                    this.filtarPermisosByUsuario()
                })
            },
            limpiarCriterios(){
                this.fillCrearRol.cNombre = ''
                this.fillCrearRol.cSlug = ''
            },
            abrirModal(){
                this.modalShow = !this.modalShow
            },
            filtarPermisosByUsuario(){
                let me = this
                me.listPermisos.map(function(x,y){
                    me.listPermisosFilter.push({
                        'id': x.id,
                        'name': x.name,
                        'slug': x.slug,
                        'checked': (x.checked == 1) ? true : false
                    })
                    //console.log(x+' - '+y)
                })
            },
            setRegistrarPermisosByUsuario(){
                if(this.validarRegistrarPermisosyUsuario()){
                    this.modalShow = true
                    console.log(this.mensajeError)
                    return
                }
                let url = '/administracion/usuario/setRegistrarPermisosByUsuario'
                console.log('setRegistrarPermisosByUsuario')
                this.fullscreenLoading = true
                let params = {
                        'nIdUsuario': this.fillPermiso.nIdUsuario,
                        'listPermisosFilter': this.listPermisosFilter
                    }
                console.log(params)
                axios.post(url, params)
                    .then(res=>{
                        this.fullscreenLoading = false
                        Swal.fire({
                            icon: 'success',
                            title: 'Permisos otorgados',
                            showConfirmButton: false,
                            timer: 1500
                        })
                    })

            },
            marcarFila(index){
                console.log(this.listPermisosFilter[index])
                this.listPermisosFilter[index].checked = !this.listPermisosFilter[index].checked
            },
            validarRegistrarPermisosyUsuario(){
                this.error = 0
                this.mensajeError = []

                let count = 0
                this.listPermisosFilter.map(function(x,y){
                    if(x.checked == true){
                        count++
                    }
                })
                if(count == 0 )this.mensajeError.push('Debe seleccionar al menos un permiso')

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
</style>
