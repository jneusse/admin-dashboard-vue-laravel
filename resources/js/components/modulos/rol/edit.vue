<template>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Editar Rol</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->

        <div class="content container-fluid">
            <div class="card">
                <div class="card-header">
                    <div class="card-tools">
                        <router-link class="btn btn-info btn-sm" :to="'/rol'">
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
                                <h3 class="card-title">Formuliario Editar Rol</h3>
                            </div>
                            <div class="card-body">
                                <form role="form ">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group row">
                                                <label for="" class="col-md-3 col-form-label">Nombre</label>
                                                <div class="col-md-9">
                                                    <input type="text" class="form-control" v-model="fillEditarRol.cNombre" @keyup.enter="setEditarRolPermiso">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group row">
                                                <label for="" class="col-md-3 col-form-label">Url Amigable</label>
                                                <div class="col-md-9">
                                                    <input type="text" class="form-control" v-model="fillEditarRol.cSlug" @keyup.enter="setEditarRolPermiso">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-md-12">
                                        <button class="btn btn-flat btn-info btnWidth" v-loading.fullscreen.lock="fullscreenLoading" @click.prevent="setEditarRolPermiso">Registrar</button>
                                        <button class="btn btn-flat btn-default btnWidth" @click.prevent="limpiarCriterios">Limpiar</button>
                                    </div>
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
                                    <table class="table table-hover table-head-fxed text-nowrap projects">
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
            fillEditarRol: {
                nIdRol: this.$attrs.id,
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
        this.getListarPermisosByRol()
        this.getListaRoles()
    },
    methods:{
        getListarPermisosByRol(){
            let url = '/administracion/rol/getListarPermisosByRol'
            let params = {
                'nIdRol': this.fillEditarRol.nIdRol
            }
            axios.get(url, {params: params}).then(res=>{
                //console.log(res.data)
                this.listPermisos = res.data
                // console.log(this.listPermisos[0].name)
                this.filtarPermisosByRol()
            })
        },
        limpiarCriterios(){
            this.fillEditarRol.cNombre = ''
            this.fillEditarRol.cSlug = ''
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
                    'checked': (x.checked == 1) ? true : false
                })
                //console.log(x+' - '+y)
            })
        },
        getListaRoles(){
            let url = '/administracion/rol/getListaRoles'
            let params = {
                'nIdRol': this.fillEditarRol.nIdRol,
            }
            this.fullscreenLoading = true
            axios.get(url, {
                params: params
            })
            .then( res => {
                console.log(res.data)
                this.fillEditarRol.cNombre = res.data[0].name
                this.fillEditarRol.cSlug = res.data[0].slug
                this.fullscreenLoading = false
            })
        },
        setEditarRolPermiso(){
             if(this.validarRegistrarRolPermiso()){
                this.modalShow = true
                console.log(this.mensajeError)
                return
            }
            let url = '/administracion/rol/setEditarRolPermiso'
            console.log('setEditarRolPermiso')
            this.fullscreenLoading = true
            let params = {
                    'nIdRol': this.fillEditarRol.nIdRol,
                    'cNombre': this.fillEditarRol.cNombre,
                    'cSlug': this.fillEditarRol.cSlug,
                    'listPermisosFilter': this.listPermisosFilter
                }
            console.log(params)
            axios.post(url, params)
                .then(res=>{
                    console.log(res)
                    console.log("Guardado Exitosamente")
                    this.fullscreenLoading = false
                    Swal.fire({
                        icon: 'success',
                        title: 'Actualizado Exitosamente',
                        showConfirmButton: false,
                        timer: 1500
                    })
                    // this.$router.push('/rol')
                })

        },
        marcarFila(index){
            console.log(this.listPermisosFilter[index])
            this.listPermisosFilter[index].checked = !this.listPermisosFilter[index].checked
        },
        validarRegistrarRolPermiso(){
            this.error = 0
            this.mensajeError = []

            if(!this.fillEditarRol.cNombre){
                this.mensajeError.push('El nombre es un campo obligatorio')
            }
            if(!this.fillEditarRol.cSlug){
                this.mensajeError.push('El slug es un campo obligatorio')
            }

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
