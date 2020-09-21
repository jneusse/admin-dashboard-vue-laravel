<template>
    <div>
        <!--Nav Bar-->
        <Navbar :ruta="ruta"/>
        <!--Sidebar-->
        <Sidebar :ruta="ruta"/>
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
        props:['ruta'],
        components: {Navbar, Sidebar, Footer}
    }
</script>

<style>

</style>
