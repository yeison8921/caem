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
import Vuelidate from 'vuelidate'
import "datatables.net-bs5/css/dataTables.bootstrap5.min.css";
import Vuetify from 'vuetify'

import axios from 'axios'
import { Model } from 'vue-api-query'
Model.$http = axios
require('@fortawesome/fontawesome-free/js/all.min.js');
require('jszip');
require('datatables.net-bs5');
require('datatables.net-buttons-bs5');
require('datatables.net-buttons/js/buttons.html5.js');
require('datatables.net-responsive-bs5');

Vue.use(Vuetify);
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

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    vuetify: new Vuetify(),
});