<template>
    <div>
        <!--Nav Bar-->
        <Navbar :ruta="ruta"/>
        <!--Sidebar-->
        <Sidebar :ruta="ruta" :usuario="authUser"/>
        <!--Content-->
        <div class="content-wrapper">
            <transition name="slide-fade" modo="in-out">
                <router-view/>
            </transition>
        </div>
        <!--Footer-->
        <Footer/>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
</template>

<script>
    import Footer from './plantilla/Footer'
    import Navbar from './plantilla/Navbar'
    import Sidebar from './plantilla/Sidebar'
    export default {
        props:['ruta', 'usuario'],
        components: {Navbar, Sidebar, Footer},
        data(){
            return{
                authUser: this.usuario
            }
        },
        mounted(){
            EventBus.$on('verifyAuthenticatedUser', data => {
                console.log(':easdf')
                console.log(data)
                this.authUser = data;
            })
        }
    }
</script>

<style>

</style>
