<template>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Editar Permiso</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->

        <div class="content container-fluid">
            <div class="card">
                <div class="card-header">
                    <div class="card-tools">
                        <router-link class="btn btn-info btn-sm" :to="'/permiso'">
                            <i class="fas fa-arrow-left"></i> Regresar
                        </router-link>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="container-fluid">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Formuliario Editar Permiso</h3>
                    </div>
                    <div class="card-body">
                        <form role="form ">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group row">
                                        <label for="" class="col-md-3 col-form-label">Nombre</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" v-model="fillEditarPermiso.cNombre" @keyup.enter="setEditarPermiso">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group row">
                                        <label for="" class="col-md-3 col-form-label">Url Amigable</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" v-model="fillEditarPermiso.cSlug" @keyup.enter="setEditarPermiso">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-4 offset-4">
                                <button class="btn btn-flat btn-info btnWidth" v-loading.fullscreen.lock="fullscreenLoading" @click.prevent="setEditarPermiso">Guardar</button>
                                <button class="btn btn-flat btn-default btnWidth" @click.prevent="limpiarCriterios">Limpiar</button>
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
            fillEditarPermiso: {
                nIdPermiso: this.$attrs.id,
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
    mounted(){
        this.getListarPermisos()
    },
    computed:{
    },
    methods:{
        limpiarCriterios(){
            this.fillEditarPermiso.cNombre = ''
            this.fillEditarPermiso.cSlug = ''
        },
        abrirModal(){
            this.modalShow = !this.modalShow
        },
        setEditarPermiso(){
             if(this.validarEditarPermiso()){
                this.modalShow = true
                console.log(this.mensajeError)
                return
            }
            let url = '/administracion/permiso/setEditarPermiso'
            console.log('setEditarPermiso')
            this.fullscreenLoading = true
            let params = {
                    'nIdPermiso': this.fillEditarPermiso.nIdPermiso,
                    'cNombre': this.fillEditarPermiso.cNombre,
                    'cSlug': this.fillEditarPermiso.cSlug
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
                    this.$router.push('/permiso')
                })

        },
        getListarPermisos(){
            let url = '/administracion/permiso/getListarPermisos'

            let params = {
                'nIdPermiso': this.fillEditarPermiso.nIdPermiso
            }

            this.fullscreenLoading = true

            axios.get(url, {
                params: params
            })
            .then( res => {
                // console.log(res.data)
                this.fillEditarPermiso.cNombre = res.data[0].name
                this.fillEditarPermiso.cSlug = res.data[0].slug
                // this.listRoles = res.data
                this.fullscreenLoading = false
            })
        },
        validarEditarPermiso(){
            this.error = 0
            this.mensajeError = []

            if(!this.fillEditarPermiso.cNombre){
                this.mensajeError.push('El nombre es un campo obligatorio')
            }
            if(!this.fillEditarPermiso.cSlug){
                this.mensajeError.push('El slug es un campo obligatorio')
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
</style>
