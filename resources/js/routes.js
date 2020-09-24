import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router)

export default new Router({
    routes:[
        { path: '/login', name: 'login', component: require('./components/modulos/authenticate/login.vue').default },
        { path: '/', name: 'dashboard.index', component: require('./components/modulos/dashboard/index.vue').default },
        { path: '/categoria', name: 'categoria.index', component: require('./components/modulos/categoria/index.vue').default },
        { path: '/cliente', name: 'cliente.index', component: require('./components/modulos/cliente/index.vue').default },
        { path: '/pedido', name: 'pedido.index', component: require('./components/modulos/pedido/index.vue').default },
        { path: '/permiso', name: 'permiso.index', component: require('./components/modulos/permiso/index.vue').default },
        { path: '/permiso/crear', name: 'permiso.crear', component: require('./components/modulos/permiso/create.vue').default },
        {   path: '/permiso/editar/:id',
            name: 'permiso.editar',
            component: require('./components/modulos/permiso/edit.vue').default,
            props: true
        },
        { path: '/producto', component: require('./components/modulos/producto/index.vue').default },

        { path: '/usuario', name: 'usuario.index', component: require('./components/modulos/usuario/index.vue').default },
        { path: '/usuario/crear', name: 'usuario.crear', component: require('./components/modulos/usuario/create.vue').default },
        {   path: '/usuario/ver/:id',
            name: 'usuario.ver',
            component: require('./components/modulos/usuario/view.vue').default,
            props: true
        },
        {   path: '/usuario/editar/:id',
            name: 'usuario.editar',
            component: require('./components/modulos/usuario/edit.vue').default,
            props: true
        },
        {   path: '/usuario/permiso/:id',
            name: 'usuario.permiso',
            component: require('./components/modulos/usuario/permission.vue').default,
            props: true
        },

        { path: '/rol', component: require('./components/modulos/rol/index.vue').default },
        { path: '/rol/crear', component: require('./components/modulos/rol/create.vue').default },
        {   path: '/rol/editar/:id',
            name: 'rol.editar',
            component: require('./components/modulos/rol/edit.vue').default,
            props: true
        },
        { path: '/reporte', name: 'reporte.index',  component: require('./components/modulos/reporte/index.vue').default }
    ],
    mode:'history',
    linkExactActiveClass: 'active'
})
