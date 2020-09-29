<template>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Editar Producto</h1>
                </div>
            </div>
        </div>

        <div class="content container-fluid">
            <div class="card">
                <div class="card-header">
                    <div class="card-tools">
                        <router-link class="btn btn-info btn-sm" :to="{name: 'producto.index'}">
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
                        <h3 class="card-title">Formuliario Editar Producto</h3>
                    </div>
                    <div class="card-body">
                        <form role="form ">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label for="" class="col-md-3 col-form-label">Nombre</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" v-model="fillEditarProducto.cNombre" @keyup.enter="setEditarProducto">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label for="" class="col-md-3 col-form-label">Descripción</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" v-model="fillEditarProducto.cDescripcion" @keyup.enter="setEditarProducto">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label for="" class="col-md-3 col-form-label">Stock</label>
                                        <div class="col-md-9">
                                            <el-input-number v-model="fillEditarProducto.nStock" controls-position="right" @keyup.enter="setEditarProducto" :min="1"></el-input-number>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label for="" class="col-md-3 col-form-label">Precio</label>
                                        <div class="col-md-9">
                                            <el-input-number v-model="fillEditarProducto.fPrecio" controls-position="right" @keyup.enter="setEditarProducto" :min="1"></el-input-number>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label for="" class="col-md-3 col-form-label">Categoria</label>
                                        <div class="col-md-9">
                                              <el-select v-model="fillEditarProducto.nIdCategoria" placeholder="Select" clearable>
                                                <el-option
                                                v-for="item in listCategorias"
                                                :key="item.value"
                                                :label="item.name"
                                                :value="item.id">
                                                </el-option>
                                            </el-select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-4 offset-4">
                                <button class="btn btn-flat btn-info btnWidth" v-loading.fullscreen.lock="fullscreenLoading" @click.prevent="setEditarProducto">Guardar</button>
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
            fillEditarProducto: {
                nIdProducto: this.$attrs.id,
                cNombre: '',
                cDescripcion: '',
                nStock: 1,
                fPrecio: 1,
                nIdCategoria: ''
            },
            listPermisosFilter: [],
            listCategorias:[],
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
        this.getListaCategorias()
        this.getListaProductos()
    },
    computed:{
    },
    methods:{
        limpiarCriterios(){
            this.fillEditarProducto.cNombre = ''
            this.fillEditarProducto.cDescripcion = ''
            this.fillEditarProducto.nStock = 1
            this.fillEditarProducto.fPrecio = 1
            this.fillEditarProducto.nIdCategoria = ''
        },
        abrirModal(){
            this.modalShow = !this.modalShow
        },
        getListaProductos(){
            let url = '/configuracion/producto/getListaProductos'
            this.fullscreenLoading = true
            let params = {
                'nIdProducto': this.fillEditarProducto.nIdProducto
            }
            console.log(params);
            axios.get(url, {params: params})
                .then( res => {
                    this.fillEditarProducto.cNombre = res.data[0].name
                    this.fillEditarProducto.cDescripcion = res.data[0].description
                    this.fillEditarProducto.nStock = res.data[0].stock
                    this.fillEditarProducto.fPrecio = res.data[0].price
                    this.fillEditarProducto.nIdCategoria = res.data[0].nidcategoria
                    this.fullscreenLoading = false
                })
                .catch(error=>{
                    console.log(error.response)
                    if(error.response.status == 401){
                        this.$router.push({name: 'login'})
                        location.reload()
                        sessionStorage.clear()
                        this.fullscreenLoading = false
                    }
                })
        },
        getListaCategorias(){
            let url = '/configuracion/categoria/getListaCategorias'
            this.fullscreenLoading = true
            axios.get(url)
                .then( res => {
                    this.listCategorias = res.data
                    this.fullscreenLoading = false
                })
                .catch(error=>{
                    console.log(error.response)
                    if(error.response.status == 401){
                        this.$router.push({name: 'login'})
                        location.reload()
                        sessionStorage.clear()
                        this.fullscreenLoading = false
                    }
                })
        },
        setEditarProducto(){
             if(this.validarEditarProducto()){
                this.modalShow = true
                console.log(this.mensajeError)
                return
            }
            let url = '/configuracion/producto/setEditarProducto'
            this.fullscreenLoading = true
            let params = {
                    'nIdProducto': this.fillEditarProducto.nIdProducto,
                    'cNombre': this.fillEditarProducto.cNombre,
                    'cDescripcion': this.fillEditarProducto.cDescripcion,
                    'nStock': this.fillEditarProducto.nStock,
                    'fPrecio': this.fillEditarProducto.fPrecio,
                    'nIdCategoria': this.fillEditarProducto.nIdCategoria
                }
            // console.log(this.fillEditarProducto);
            axios.post(url, params)
                .then(res=>{
                    // console.log(res.data)
                    this.fullscreenLoading = false
                    Swal.fire({
                        icon: 'success',
                        title: 'Actualizado Exitosamente',
                        showConfirmButton: false,
                        timer: 1500
                    })
                    this.$router.push({name: 'producto.index'})
                })
                .catch(error=>{
                    console.log(error.response)
                    if(error.response.status == 401){
                        this.$router.push({name: 'login'})
                        location.reload()
                        sessionStorage.clear()
                        this.fullscreenLoading = false
                    }
                })

        },
        validarEditarProducto(){
            this.error = 0
            this.mensajeError = []

            if(!this.fillEditarProducto.cNombre){
                this.mensajeError.push('El nombre es un campo obligatorio')
            }
            if(!this.fillEditarProducto.nStock){
                this.mensajeError.push('El Stock es un campo obligatorio')
            }
            if(!this.fillEditarProducto.fPrecio){
                this.mensajeError.push('El Precio es un campo obligatorio')
            }
            if(!this.fillEditarProducto.nIdCategoria){
                this.mensajeError.push('Categoria es un campo obligatorio')
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
    .el-input-number{
        width: 100% !important;
    }
</style>
