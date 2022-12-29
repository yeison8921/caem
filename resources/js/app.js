/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
window.$ = window.jQuery = require('jquery');
window.Swal = require('sweetalert2');

window.Vue = require('vue').default;

import Vue from 'vue';
import XLSX from 'xlsx';
import Vuelidate from 'vuelidate'
import "datatables.net-bs5/css/dataTables.bootstrap5.min.css";
import axios from 'axios'
import { Model } from 'vue-api-query'
import "../css/nucleo-icons.css";
import "../css/nucleo-svg.css";
import jszip from 'jszip/dist/jszip';
import "./nav-pills.js";
import "../scss/soft-ui-dashboard.scss";

var moment = require("moment-timezone");
var momentDurationFormatSetup = require("moment-duration-format");
momentDurationFormatSetup(moment);
typeof moment.duration.fn.format === "function";
typeof moment.duration.format === "function";
window.moment = moment;
Vue.prototype.moment = window.moment;

Model.$http = axios
require('@fortawesome/fontawesome-free/css/all.min.css');
require('datatables.net-bs5');
require('datatables.net-bs5/js/dataTables.bootstrap5.min.js');
require('datatables.net-buttons/js/dataTables.buttons.min.js');
require('datatables.net-buttons-bs5/js/buttons.bootstrap5.min.js');
require('datatables.net-buttons/js/buttons.html5.min.js');
require('datatables.net-responsive-bs5');
require('datatables.net-fixedcolumns/js/dataTables.fixedColumns.min.js');
require('datatables.net-fixedcolumns-bs5/css/fixedColumns.bootstrap5.min.css')

window.JSZip = jszip;

Vue.use(Vuelidate)

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('login-component', require('./components/auth/LoginComponent.vue').default);
Vue.component('registro-component', require('./components/auth/RegistroComponent.vue').default);
Vue.component('index-parametro-component', require('./components/administracion/parametro/IndexParametroComponent.vue').default);
Vue.component('index-autorizacion-component', require('./components/administracion/autorizacion/IndexAutorizacionComponent.vue').default);
Vue.component('form-parametro-component', require('./components/administracion/parametro/FormParametroComponent.vue').default);
Vue.component('index-convenio-component', require('./components/administracion/convenio/IndexConvenioComponent.vue').default);
Vue.component('form-convenio-component', require('./components/administracion/convenio/FormConvenioComponent.vue').default);
Vue.component('index-empresa-component', require('./components/administracion/empresa/IndexEmpresaComponent.vue').default);
Vue.component('form-empresa-component', require('./components/administracion/empresa/FormEmpresaComponent.vue').default);
Vue.component('index-sede-component', require('./components/administracion/sede/IndexSedeComponent.vue').default);
Vue.component('form-sede-component', require('./components/administracion/sede/FormSedeComponent.vue').default);
Vue.component('index-proceso-component', require('./components/proceso/IndexProcesoComponent.vue').default);
Vue.component('nav-bar-component', require('./components/pageLayout/Navbar.vue').default);
Vue.component('app-footer', require('./components/pageLayout/Footer.vue').default);
Vue.component('side-nav', require('./components/pageLayout/Sidenav/Sidenav.vue').default);
Vue.component('nav-bar-side', require('./components/pageLayout/Sidenav/NavbarSide.vue').default);
Vue.component('soft-input', require('./components/SoftInput.vue').default);
Vue.component('soft-switch', require('./components/SoftSwitch.vue').default);
Vue.component('soft-button', require('./components/SoftButton.vue').default);
Vue.component('soft-button-basic', require('./components/SoftButtonBasic.vue').default);
Vue.component('index-resultado-component', require('./components/resultado/IndexResultadoComponent.vue').default);
Vue.component('index-fuente-component', require('./components/fuente/IndexFuenteComponent.vue').default);
Vue.component('form-combustible-component', require('./components/fuente/combustible/FormCombustibleComponent.vue').default);
Vue.component('form-emision-component', require('./components/fuente/emision/FormEmisionComponent.vue').default);
Vue.component('form-estiercol-component', require('./components/fuente/estiercol/FormEstiercolComponent.vue').default);
Vue.component('form-fertilizante-component', require('./components/fuente/fertilizante/FormFertilizanteComponent.vue').default);
Vue.component('form-refrigerante-component', require('./components/fuente/refrigerante/FormRefrigeranteComponent.vue').default);
Vue.component('form-extintor-component', require('./components/fuente/extintor/FormExtintorComponent.vue').default);
Vue.component('form-lubricante-component', require('./components/fuente/lubricante/FormLubricanteComponent.vue').default);
Vue.component('form-fuga-component', require('./components/fuente/fuga/FormFugaComponent.vue').default);
Vue.component('form-aislamiento-component', require('./components/fuente/aislamiento/FormAislamientoComponent.vue').default);
Vue.component('form-fermentacion-component', require('./components/fuente/fermentacion/FormFermentacionComponent.vue').default);
Vue.component('form-electricidad-component', require('./components/fuente/electricidad/FormElectricidadComponent.vue').default);
Vue.component('form-viaje-component', require('./components/fuente/viaje/FormViajeComponent.vue').default);
Vue.component('Multiselect', require('@vueform/multiselect/dist/multiselect.vue2.js').default);

Vue.prototype.$tablaGlobal = function(nombreTabla) {
    this.$nextTick(() => {
        $(nombreTabla).DataTable({
            "order": [
                [0, 'desc']
            ],
            responsive: false,
            dom: "<'row'<'col-sm-12 mb-3'B>><'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            "language": {
                "lengthMenu": "Ver _MENU_ registros por página",
                "zeroRecords": "No hay información, lo sentimos.",
                "info": "Mostrando página _PAGE_ de _PAGES_",
                "infoEmpty": "No hay registros disponibles",
                "infoFiltered": "(Filtrado de _MAX_ registros totales)",
                "search": "Filtrar:",
                "paginate": {
                    "first": "Primera",
                    "last": "Ultima",
                    "next": "Siguiente",
                    "previous": "Anterior"
                },
            },
            buttons: [{
                "extend": "excelHtml5",
                "text": "<i class='fas fa-file-excel'></i> Excel",
                "titleAttr": "Exportar a Excel",
                "className": "btn btn-success"
            }, ]
        });
    });
}
Vue.prototype.$tablaResultados = function(nombreTabla) {
    this.$nextTick(() => {
        $(nombreTabla).DataTable({
            "columnDefs": [
                { "width": "90%", "targets": 0 }
            ],
            responsive: false,
            dom: "<'row'<'col-sm-12 mb-3'B>><'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            "language": {
                "lengthMenu": "Ver _MENU_ registros por página",
                "zeroRecords": "No hay información, lo sentimos.",
                "info": "Mostrando página _PAGE_ de _PAGES_",
                "infoEmpty": "No hay registros disponibles",
                "infoFiltered": "(Filtrado de _MAX_ registros totales)",
                "search": "Filtrar:",
                "paginate": {
                    "first": "Primera",
                    "last": "Ultima",
                    "next": "Siguiente",
                    "previous": "Anterior"
                },
            },
            buttons: [{
                "extend": "excelHtml5",
                "text": "<i class='fas fa-file-excel'></i> Excel",
                "titleAttr": "Exportar a Excel",
                "className": "btn btn-success"
            }, ]
        });
    });
}
Vue.prototype.$tablaConvenios = function(nombreTabla) {
    this.$nextTick(() => {
        $(nombreTabla).DataTable({
            "columnDefs": [
                { "width": "15%", "targets": 3 }
            ],
            responsive: false,
            dom: "<'row'<'col-sm-12 mb-3'B>><'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            "language": {
                "lengthMenu": "Ver _MENU_ registros por página",
                "zeroRecords": "No hay información, lo sentimos.",
                "info": "Mostrando página _PAGE_ de _PAGES_",
                "infoEmpty": "No hay registros disponibles",
                "infoFiltered": "(Filtrado de _MAX_ registros totales)",
                "search": "Filtrar:",
                "paginate": {
                    "first": "Primera",
                    "last": "Ultima",
                    "next": "Siguiente",
                    "previous": "Anterior"
                },
            },
            buttons: [{
                "extend": "excelHtml5",
                "text": "<i class='fas fa-file-excel'></i> Excel",
                "titleAttr": "Exportar a Excel",
                "className": "btn btn-success"
            }, ]
        });
    });
}
Vue.prototype.$tablaEmpresas = function(nombreTabla) {
    this.$nextTick(() => {
        $(nombreTabla).DataTable({
            "columnDefs": [
                { "width": "10%", "targets": 5 }
            ],
            responsive: false,
            dom: "<'row'<'col-sm-12 mb-3'B>><'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            "language": {
                "lengthMenu": "Ver _MENU_ registros por página",
                "zeroRecords": "No hay información, lo sentimos.",
                "info": "Mostrando página _PAGE_ de _PAGES_",
                "infoEmpty": "No hay registros disponibles",
                "infoFiltered": "(Filtrado de _MAX_ registros totales)",
                "search": "Filtrar:",
                "paginate": {
                    "first": "Primera",
                    "last": "Ultima",
                    "next": "Siguiente",
                    "previous": "Anterior"
                },
            },
            buttons: [{
                "extend": "excelHtml5",
                "text": "<i class='fas fa-file-excel'></i> Excel",
                "titleAttr": "Exportar a Excel",
                "className": "btn btn-success"
            }, ]
        });
    });
}

Vue.prototype.$tablaSedes = function(nombreTabla) {
    this.$nextTick(() => {
        $(nombreTabla).DataTable({
            "columnDefs": [
                { "width": "10%", "targets": 3 }
            ],
            responsive: false,
            dom: "<'row'<'col-sm-12 mb-3'B>><'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            "language": {
                "lengthMenu": "Ver _MENU_ registros por página",
                "zeroRecords": "No hay información, lo sentimos.",
                "info": "Mostrando página _PAGE_ de _PAGES_",
                "infoEmpty": "No hay registros disponibles",
                "infoFiltered": "(Filtrado de _MAX_ registros totales)",
                "search": "Filtrar:",
                "paginate": {
                    "first": "Primera",
                    "last": "Ultima",
                    "next": "Siguiente",
                    "previous": "Anterior"
                },
            },
            buttons: [{
                "extend": "excelHtml5",
                "text": "<i class='fas fa-file-excel'></i> Excel",
                "titleAttr": "Exportar a Excel",
                "className": "btn btn-success"
            }, ]
        });
    });
}

Vue.prototype.$tablaUsuarios = function(nombreTabla) {
    this.$nextTick(() => {
        $(nombreTabla).DataTable({
            "columnDefs": [
                { "width": "10%", "targets": 3 }
            ],
            responsive: false,
            dom: "<'row'<'col-sm-12 mb-3'B>><'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            "language": {
                "lengthMenu": "Ver _MENU_ registros por página",
                "zeroRecords": "No hay información, lo sentimos.",
                "info": "Mostrando página _PAGE_ de _PAGES_",
                "infoEmpty": "No hay registros disponibles",
                "infoFiltered": "(Filtrado de _MAX_ registros totales)",
                "search": "Filtrar:",
                "paginate": {
                    "first": "Primera",
                    "last": "Ultima",
                    "next": "Siguiente",
                    "previous": "Anterior"
                },
            },
            buttons: [{
                "extend": "excelHtml5",
                "text": "<i class='fas fa-file-excel'></i> Excel",
                "titleAttr": "Exportar a Excel",
                "className": "btn btn-success"
            }, ]
        });
    });
}
Vue.prototype.$tablaResultadosEmision = function(nombreTabla) {
    this.$nextTick(() => {
        $(nombreTabla).DataTable({
            scrollX: true,
            scrollCollapse: true,
            fixedColumns: {
                leftColumns: 1,
            },
            scrollY: "400px",
            responsive: false,
            dom: "<'row'<'col-sm-12 mb-3'B>><'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",

            "paging": false,
            "searching": false,
            "ordering": false,
            "info": false,
            "language": {
                "lengthMenu": "Ver _MENU_ registros por página",
                "zeroRecords": "No hay información, lo sentimos.",
                "info": "Mostrando página _PAGE_ de _PAGES_",
                "infoEmpty": "No hay registros disponibles",
                "infoFiltered": "(Filtrado de _MAX_ registros totales)",
                "search": "Filtrar:",
                "paginate": {
                    "first": "Primera",
                    "last": "Ultima",
                    "next": "Siguiente",
                    "previous": "Anterior"
                },
            },
            buttons: [{
                "extend": "excelHtml5",
                "text": "<i class='fas fa-file-excel'></i> Excel",
                "titleAttr": "Exportar a Excel",
                "className": "btn btn-success"
            }, ]
        });
    });
}

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
/*window.isLoggedIn = localStorage.getItem('token') != 'undefined' && localStorage.getItem('token') != null;
if (window.isLoggedIn) {
    axios
        .get("/api/user")
        .then((response) => {
            window.user = response.data;
            console.log(user);
        })
        .catch((error) => {
            console.log(error.response.status);
            if (error.response.status == 401) {
                localStorage.removeItem("token");
                console.log(localStorage.getItem('token'));
                window.isLoggedIn = false;
            }
        });
}*/
const app = new Vue({
    el: '#app',
    methods: {
        mostrarCargando(mensaje) {
            Swal.fire({
                title: mensaje,
                text: "Espere un poco por favor.",
                imageUrl: "/loading.gif",
                imageWidth: 70,
                imageHeight: 70,
                showConfirmButton: false,
                allowEscapeKey: false,
                allowOutsideClick: false,
            });
        },
        cerrarCargando() { Swal.close(); },
        mostrarMensaje(titulo, mensaje, icono) {
            Swal.fire({
                title: titulo,
                html: mensaje,
                icon: icono,
                showConfirmButton: false,
                allowEscapeKey: false,
                allowOutsideClick: false,
                timer: 2000,
            });
        },
        redirectIndex(url) {
            setTimeout(() => {
                window.location.href = url;
            }, 2000);
        },

    }
});