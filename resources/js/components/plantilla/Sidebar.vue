<template>
        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <router-link :to="'/'" class="brand-link">
                <img :src="ruta + '/img/AdminLTELogo.png'"
                    alt="AdminLTE Logo"
                    class="brand-image img-circle elevation-3"
                    style="opacity: .8">
                <span class="brand-text font-weight-light">Laravel AdminLTE 3</span>
            </router-link>

            <!-- Sidebar -->
            <div class="sidebar">
            <!-- Sidebar user (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <template v-if="!usuario.file_id">
                    <div class="image">
                        <img :src="ruta + '/img/user2-160x160.jpg'" class="img-circle elevation-2" alt="User Image">
                    </div>
                </template>
                <template v-else>
                    <div class="image">
                        <img :src="usuario.file.path" class="img-circle elevation-2" alt="User Image">
                    </div>
                </template>
                <div class="info">
                <router-link :to="{name: 'usuario.ver', params:{id: usuario.id}}" class="d-block">{{ usuario.fullname }}</router-link>
                </div>
            </div>
             <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="info">
                    <a href="#" class="d-block" @click="logout" v-loading.fullscreen.lock="fullscreenLoading">
                        <i class="fas fa-sign-out-alf"></i>
                        Sign out</a>
                </div>
            </div>
            <!-- Sidebar Menu -->
            <nav class="mt-2">z
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class
                        with font-awesome or any other icon font library -->
                    <li class="nav-item">
                        <router-link :to="'/'" class="nav-link active">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>
                                Dashboard
                            </p>
                        </router-link>
                    </li>
                    <li class="nav-header">OPERACIONES</li>
                    <li class="nav-item">
                        <router-link :to="'/pedido'" class="nav-link">
                            <i class="nav-icon fas fa-cash-register"></i>
                            <p>
                                Pedidos
                            </p>
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link :to="'/cliente'" class="nav-link">
                            <i class="nav-icon far fa-plus-square"></i>
                            <p>
                                Clientes
                            </p>
                        </router-link>
                    </li>
                    <li class="nav-header">CONFIGURACIÓN</li>
                    <li class="nav-item">
                        <router-link :to="'/categoria'" href="../examples/login.html" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Categoria</p>
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link :to="'/producto'" href="../examples/register.html" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Productos</p>
                        </router-link>
                    </li>
                    <li class="nav-header">ADMINISTRACIÓN</li>
                    <li class="nav-item">
                        <router-link :to="'/usuario'" href="../examples/forgot-password.html" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Usuario</p>
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link :to="'/rol'" href="../examples/recover-password.html" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Roles</p>
                        </router-link>
                    </li>
                    <li class="nav-header">ADMINISTRACIÓN</li>
                    <li class="nav-item">
                        <router-link :to="'/permiso'" href="../examples/lockscreen.html" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Permiso</p>
                        </router-link>
                    </li>
                    <li class="nav-header">REPORTES</li>
                    <li class="nav-item">
                        <router-link :to="'/pedido'" href="../examples/legacy-user-menu.html" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Pedidos</p>
                        </router-link>
                    </li>
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>
</template>

<script>
export default {
    props: ['ruta', 'usuario'],
    data(){
        return{
            fullscreenLoading: false
        }
    },
    methods:{
        logout(){
            this.fullscreenLoading = true
            var url = '/authenticate/logout'
            console.log('logout')
            axios.post(url).then(res=>{
                if(res.data.code == 204 ){
                    this.$router.push({name: 'login'})
                    location.reload()
                    // this.fullscreenLoading = false
                }
            })
        }
    }
}
</script>

<style>

</style>
