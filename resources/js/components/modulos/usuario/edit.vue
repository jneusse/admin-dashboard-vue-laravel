<template>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Editar Usuario</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->

        <div class="content container-fluid">
            <div class="card">
                <div class="card-header">
                    <div class="card-tools">
                        <router-link class="btn btn-info btn-sm" :to="'/usuario'">
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
                        <h3 class="card-title">Formuliario Editar Usuario</h3>
                    </div>
                    <div class="card-body">
                        <form role="form ">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label for="" class="col-md-3 col-form-label">Primer Nombre</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" v-model="fillEditarUsuario.cPrimerNombre" v-loading.fullscreen.lock="fullscreenLoading" @keyup.enter="setRegistrarUsuario">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label for="" class="col-md-3 col-form-label">Segundo Nombre</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" v-model="fillEditarUsuario.cSegundoNombre" v-loading.fullscreen.lock="fullscreenLoading" @keyup.enter="setRegistrarUsuario">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label for="" class="col-md-3 col-form-label">Apellidos</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" v-model="fillEditarUsuario.cApellido" v-loading.fullscreen.lock="fullscreenLoading" @keyup.enter="setRegistrarUsuario">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label for="" class="col-md-3 col-form-label">Usuario</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" v-model="fillEditarUsuario.cUsuario" v-loading.fullscreen.lock="fullscreenLoading" @keyup.enter="setRegistrarUsuario">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label for="" class="col-md-3 col-form-label">Email</label>
                                        <div class="col-md-9">
                                            <input type="email" class="form-control" v-model="fillEditarUsuario.cCorreo" v-loading.fullscreen.lock="fullscreenLoading" @keyup.enter="setRegistrarUsuario">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label for="" class="col-md-3 col-form-label">Contraseña</label>
                                        <div class="col-md-9">
                                            <el-input placeholder="Please input password" v-model="fillEditarUsuario.cContrasena" show-password v-loading.fullscreen.lock="fullscreenLoading" @keyup.enter="setRegistrarUsuario"></el-input>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label for="" class="col-md-3 col-form-label">Fotografia</label>
                                        <div class="col-md-9">
                                            <input type="file" class="form-control" @change="getFile">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-4 offset-4">
                                <button class="btn btn-flat btn-info btnWidth" v-loading.fullscreen.lock="fullscreenLoading" @click.prevent="setRegistrarUsuario">Guardar</button>
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
            fillEditarUsuario: {
                nIdUsuario: this.$attrs.id,
                cPrimerNombre: '',
                cSegundoNombre: '',
                cApellido: '',
                cUsuario: '',
                cCorreo: '',
                cContrasena: '',
                oFotografia: ''
            },
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
        this.getUsuarioById();
    },
    methods:{
        getUsuarioById(){
            let url = '/administracion/usuario/getListaUsuarios'
            let params = {
                'nIdUsuario': this.fillEditarUsuario.nIdUsuario
            }
            this.fullscreenLoading = true
            axios.get(url, {
                params: params
            })
            .then( res => {
                console.log(res.data[0])
                let usuario = res.data[0]
                this.fillEditarUsuario.cPrimerNombre = usuario.firstname,
                this.fillEditarUsuario.cSegundoNombre = usuario.secondname,
                this.fillEditarUsuario.cApellido = usuario.lastname,
                this.fillEditarUsuario.cUsuario = usuario.username,
                this.fillEditarUsuario.cCorreo = usuario.email,
                setTimeout(() => {
                    this.fullscreenLoading = false
                }, 1000);
            })
        },
        limpiarCriterios(){
            this.fillEditarUsuario.cPrimerNombre = ''
            this.fillEditarUsuario.cSegundoNombre = ''
            this.fillEditarUsuario.cApellido = ''
            this.fillEditarUsuario.cUsuario = ''
            this.fillEditarUsuario.cCorreo = ''
            this.fillEditarUsuario.cContrasena = ''
            this.fillEditarUsuario.oFotografia = ''
        },
        abrirModal(){
            this.modalShow = !this.modalShow
        },
        getFile(e){
            this.fillEditarUsuario.oFotografia =  e.target.files[0]
        },
        setRegistrarUsuario(){
            if(this.validarResgistrarUsuario()){
                this.modalShow = true
                console.log(this.mensajeError)
                return
            }
            if(!this.fillEditarUsuario.oFotografia || this.fillEditarUsuario == undefined){
                this.setGuardarUsuario(0)
            }else{
                this.setRegistrarArchivo()
            }

        },
        setGuardarUsuario(nIdFile){
            let url = '/administracion/usuario/setEditarUsuario'
            console.log('setGuardarUsuario')
            console.log('File: '+nIdFile)
            this.fullscreenLoading = true
            axios.post(url, {
                'nIdUsuario': this.fillEditarUsuario.nIdUsuario,
                'cPrimerNombre': this.fillEditarUsuario.cPrimerNombre,
                'cSegundoNombre':this.fillEditarUsuario.cSegundoNombre,
                'cApellido': this.fillEditarUsuario.cApellido,
                'cUsuario': this.fillEditarUsuario.cUsuario,
                'cCorreo': this.fillEditarUsuario.cCorreo,
                'cContrasena': this.fillEditarUsuario.cContrasena,
                'oFotografia': nIdFile
                })
                .then(res=>{
                    console.log(res)
                    console.log("Actualizado Exitosamente")
                    this.fullscreenLoading = false
                    Swal.fire({
                        icon: 'success',
                        title: 'Actualizado Exitosamente',
                        showConfirmButton: false,
                        timer: 1500
                    })
                    //this.$router.push('/usuario')
                })

        },
        setRegistrarArchivo(){
            this.form.append('file', this.fillEditarUsuario.oFotografia)
            const config = { headers: {'Content-Type': 'Multipart/from-data'}}
            var url = '/archivo/setRegistrarArchivo'
            console.log('setRegistrarArchivo')
            axios.post(url, this.form, config)
                .then(res=>{
                    console.log(res)
                    let nIdFile = res.data[0].nIdFile;
                    this.setGuardarUsuario(nIdFile)
                })
        },
        validarResgistrarUsuario(){
            this.error = 0
            this.mensajeError = []

            if(!this.fillEditarUsuario.cPrimerNombre){
                this.mensajeError.push('El primer nombre es un campo obligatorio')
            }
            if(!this.fillEditarUsuario.cSegundoNombre){
                this.mensajeError.push('El segundo nombre es un campo obligatorio')
            }
            if(!this.fillEditarUsuario.cApellido){
                this.mensajeError.push('El apellido es un campo obligatorio')
            }
            if(!this.fillEditarUsuario.cUsuario){
                this.mensajeError.push('El usuario es un campo obligatorio')
            }
            if(!this.fillEditarUsuario.cCorreo){
                this.mensajeError.push('El correo es un campo obligatorio')
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

</style>
