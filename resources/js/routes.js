import Axios from 'axios'
import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router)

function verificarAcceso(to, from, next){
    let authUser = JSON.parse(sessionStorage.getItem('authUser'))
    if (authUser) {
        let listRolPermisosByUsuario = JSON.parse(sessionStorage.getItem('listRolPermisosByUsuario'))
        if(listRolPermisosByUsuario.includes(to.name)){
            next()
        }else{
            let listRolPermisosByUsuarioFilter = []
            listRolPermisosByUsuario.map(function(x) {
                if(x.includes('index')){
                    listRolPermisosByUsuarioFilter.push(x)
                }
            })
            if(to.name == 'dashboard.index'){
                next({name: listRolPermisosByUsuarioFilter[0]})
            }else{
                next(from.path)
            }

            next(from.path)
        }
    }else{
        next('/login')
    }
}
export const rutas = [
    {
        path: '/login',
        name: 'login',
        component: require('./components/modulos/authenticate/login.vue').default,
        beforeEnter: (to,from, next) => {
            let authUser = JSON.parse(sessionStorage.getItem('authUser'))
            if (authUser) {
                next({name: dashboard.index})
            }else{
                next()
            }
        }
    },
    {
        path: '/',
        name: 'dashboard.index',
        component: require('./components/modulos/dashboard/index.vue').default,
        beforeEnter: (to, from, next) => {
            verificarAcceso(to, from, next)
        }
    },
    {
        path: '/categoria',
        name: 'categoria.index',
        component: require('./components/modulos/categoria/index.vue').default,
        beforeEnter: (to, from, next) => {
            verificarAcceso(to, from, next)
        }
    },
    {
        path: '/categoria/crear',
        name: 'categoria.crear',
        component: require('./components/modulos/categoria/create.vue').default,
        beforeEnter: (to, from, next) => {
            verificarAcceso(to, from, next)
        }
    },
    {
        path: '/categoria/editar/:id',
        name: 'categoria.editar',
        props: true,
        component: require('./components/modulos/categoria/edit.vue').default,
        beforeEnter: (to, from, next) => {
            verificarAcceso(to, from, next)
        }
    },
    {
        path: '/cliente',
        name: 'cliente.index',
        component: require('./components/modulos/cliente/index.vue').default,
        beforeEnter: (to, from, next) => {
            verificarAcceso(to, from, next)
        }
    },
    {
        path: '/pedido',
        name: 'pedido.index',
        component: require('./components/modulos/pedido/index.vue').default,
        beforeEnter: (to, from, next) => {
            verificarAcceso(to, from, next)
        }
    },
    {
        path: '/permiso',
        name: 'permiso.index',
        component: require('./components/modulos/permiso/index.vue').default,
        beforeEnter: (to, from, next) => {
            verificarAcceso(to, from, next)
        }
    },
    {
        path: '/permiso/crear',
        name: 'permiso.crear',
        component: require('./components/modulos/permiso/create.vue').default,
        beforeEnter: (to, from, next) => {
            verificarAcceso(to, from, next)
        }
    },
    {
        path: '/permiso/editar/:id',
        name: 'permiso.editar',
        component: require('./components/modulos/permiso/edit.vue').default,
        props: true,
        beforeEnter: (to, from, next) => {
            verificarAcceso(to, from, next)
        }
    },
    {
        path: '/producto',
        name: 'producto.index',
        component: require('./components/modulos/producto/index.vue').default,
        beforeEnter: (to, from, next) => {
            verificarAcceso(to, from, next)
        }
    },
    {
        path: '/producto/crear',
        name: 'producto.crear',
        component: require('./components/modulos/producto/create.vue').default,
        beforeEnter: (to, from, next) => {
            verificarAcceso(to, from, next)
        }
    },
    {
        path: '/producto/editar/:id',
        name: 'producto.editar',
        component: require('./components/modulos/producto/edit.vue').default,
        props: true,
        beforeEnter: (to, from, next) => {
            verificarAcceso(to, from, next)
        }
    },
    {
        path: '/usuario',
        name: 'usuario.index',
        component: require('./components/modulos/usuario/index.vue').default,
        beforeEnter: (to, from, next) => {
            verificarAcceso(to, from, next)
        }
    },
    {
        path: '/usuario/crear',
        name: 'usuario.crear',
        component: require('./components/modulos/usuario/create.vue').default,
        beforeEnter: (to, from, next) => {
            verificarAcceso(to, from, next)
        }
    },
    {
        path: '/usuario/ver/:id',
        name: 'usuario.ver',
        component: require('./components/modulos/usuario/view.vue').default,
        props: true,
        beforeEnter: (to, from, next) => {
            verificarAcceso(to, from, next)
        }
    },
    {
        path: '/usuario/editar/:id',
        name: 'usuario.editar',
        component: require('./components/modulos/usuario/edit.vue').default,
        props: true,
        // beforeEnter: (to, from, next) => {
        //     verificarAcceso(to, from, next)
        // }
    },
    {
        path: '/usuario/permiso/:id',
        name: 'usuario.permiso',
        component: require('./components/modulos/usuario/permission.vue').default,
        props: true,
        // beforeEnter: (to, from, next) => {
        //     verificarAcceso(to, from, next)
        // }
    },

    {
        path: '/rol',
        name: 'rol.index',
        component: require('./components/modulos/rol/index.vue').default,
        beforeEnter: (to, from, next) => {
            verificarAcceso(to, from, next)
        }
    },
    {
        path: '/rol/crear',
        name: 'rol.crear',
        component: require('./components/modulos/rol/create.vue').default,
        beforeEnter: (to, from, next) => {
            verificarAcceso(to, from, next)
        }
    },
    {
        path: '/rol/editar/:id',
        name: 'rol.editar',
        component: require('./components/modulos/rol/edit.vue').default,
        props: true,
        beforeEnter: (to, from, next) => {
            verificarAcceso(to, from, next)
        }
    },
    {
        path: '/reporte',
        name: 'reporte.pedido.index',
        component: require('./components/modulos/reporte/index.vue').default,
        beforeEnter: (to, from, next) => {
            verificarAcceso(to, from, next)
        }
    },
    {
        path: '*',
        component: require('./components/plantilla/404.vue').default
    }
]
export default new Router({
    routes: rutas,
    mode:'history',
    linkExactActiveClass: 'active'
})
