<template>
    <div class="login-box">
        <div class="login-logo">
            <router-link :to="{name: 'login'}">
                <b>Iniciar sesión</b>
            </router-link>
        </div>
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body">
            <p class="login-box-msg">Sign in to start your session</p>

            <form method="post">
                <div class="input-group mb-3">
                    <vs-input icon-after type="email" :state="error ? 'danger' : ''" v-model="fillLogin.cEmail" @keyup.enter="login" placeholder="Email">
                        <template #icon>
                        <i class='fas fa-envelope'></i>
                        </template>
                    </vs-input>
                </div>
                <div class="input-group mb-3">
                    <vs-input icon-after type="password" :state="error ? 'danger' : ''" v-model="fillLogin.cContrasena" @keyup.enter="login" placeholder="Password">
                        <template #icon>
                        <i class='fas fa-lock'></i>
                        </template>
                    </vs-input>
                </div>
                <div class="row">
                <div class="col-8">
                    <div class="icheck-primary">
                    <input type="checkbox" id="remember">
                    <label for="remember">
                        Remember Me
                    </label>
                    </div>
                </div>
                <!-- /.col -->
                <div class="col-4">
                    <button type="submit" class="btn btn-primary btn-block" @click.prevent="login">Sign In</button>
                </div>
                <!-- /.col -->
                </div>
            </form>

            <div class="row">
                <div class="col-md-12">
                    <span v-if="error">
                        <div v-for="(e, index) in mensajeError" :key="index" v-text="e" class="callout callout-danger">

                        </div>
                    </span>
                </div>
            </div>

            <p class="mb-1">
                <a href="forgot-password.html">I forgot my password</a>
            </p>
            <p class="mb-0">
                <a href="register.html" class="text-center">Register a new membership</a>
            </p>
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
</template>

<script>
export default {
    data(){
        return {
            fillLogin : {
                cEmail: '',
                cContrasena: ''
            },
            listRolPermisosByUsuario: [],
            listRolPermisosByUsuarioFilter: [],
            error: 0,
            mensajeError: []
        }
    },
    methods:{
        login(){
            if(this.validarLogin()) return
            const loading = this.$vs.loading()
            var url = '/authenticate/login'
            axios.post(url,{
                'cEmail': this.fillLogin.cEmail,
                'cContrasena': this.fillLogin.cContrasena
            }).then(res=>{
                console.log(res.data)
                loading.close()
                if(res.data.code == 401){
                    this.loginFailed()
                }
                if(res.data.code == 200){
                    // this.loginSucess()
                    this.getListarRolPermisosbyUsuario(res.data.authUser)
                }
            })
        },
        getListarRolPermisosbyUsuario(authUser){
            let url = '/administracion/usuario/getListarRolPermisosbyUsuario'
            axios.get(url,{params:{
                'nIdUsuario': authUser.id
                }
            }).then(res=>{
                this.listRolPermisosByUsuario = res.data
                console.log(this.listRolPermisosByUsuario)
                this.filtarListarRolPermisosbyUsuario(authUser)
            })
        },
        filtarListarRolPermisosbyUsuario(authUser){
            let me = this
            me.listRolPermisosByUsuario.map(function(x,y){
                me.listRolPermisosByUsuarioFilter.push(x.slug)
                console.log(x.slug)
            })
            sessionStorage.setItem('listRolPermisosByUsuario', JSON.stringify(me.listRolPermisosByUsuarioFilter))
            sessionStorage.setItem('authUser', JSON.stringify(authUser))
            this.loginSucess()
        },
        loginSucess(){
            this.$router.push({name: 'dashboard.index'})
            location.reload()
        },
        loginFailed(){
            this.error = 0
            this.mensajeError = []

            this.mensajeError.push("Login invalid")
            this.fillLogin.cContrasena = ''

            if(this.mensajeError.length) this.error = 1
            return this.error

        },
        validarLogin(){
            this.error = 0
            this.mensajeError = []

            if(!this.fillLogin.cEmail){
                this.mensajeError.push("El correo es obligatorio")
            }

            if(!this.fillLogin.cContrasena){
                this.mensajeError.push("contraseña es obligatorio")
            }
            if(this.mensajeError.length) this.error = 1
            return this.error
        }
    }
}
</script>

<style>
.vs-input-parent{
    width: 100% !important;
}

</style>
