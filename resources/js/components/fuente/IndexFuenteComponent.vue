<template>
    <div class="col-lg-12">
        <div class="row">
            <div class="form-group">
                <br />
                <h4>Administración fuentes de emisión</h4>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="mb-3">
                    <Multiselect
                        v-model="fuente"
                        :options="options_fuente"
                        placeholder="Seleccione una opción"
                        required
                        @input="getFuentes()"
                        :searchable="true"
                    />
                </div>
                <div v-if="fuente != '' && fuente != null">
                    <div class="mb-3">
                        <div class="col-lg-1 offset-lg-11">
                            <div
                                class="d-grid gap-2"
                                v-if="fuente != 'porcentajes'"
                            >
                                <a
                                    :href="
                                        fuente.includes('_')
                                            ? fuente.split('_')[0] +
                                              '/' +
                                              fuente.split('_')[1] +
                                              '/create'
                                            : fuente.split('_')[0] + '/create'
                                    "
                                    class="btn btn-success"
                                    title="Crear parametro"
                                >
                                    <i class="fas fa-plus"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <table
                            class="table table-bordered table-hover table-stripered"
                            id="tabla-fuentes"
                            width="100%"
                        >
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(f, i) in fuentes" v-bind:key="i">
                                    <td>
                                        {{ f.nombre }}
                                    </td>
                                    <td>
                                        <a
                                            :href="
                                                fuente.includes('_')
                                                    ? fuente.split('_')[0] +
                                                      '/' +
                                                      fuente.split('_')[1] +
                                                      '/edit/' +
                                                      f.id
                                                    : fuente.split('_')[0] +
                                                      '/edit/' +
                                                      f.id
                                            "
                                            class="btn btn-success"
                                            title="Actualizar parametro"
                                        >
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <!-- <button
                                            type="button"
                                            class="btn btn-danger"
                                            title="Eliminar parametro"
                                            @click="confirmarEliminar(p.id)"
                                        >
                                            <i class="fas fa-trash"></i>
                                        </button> -->
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import Combustible from "../../models/Combustible";
import Refrigerante from "../../models/Refrigerante";
import Extintor from "../../models/Extintor";
import Lubricante from "../../models/Lubricante";
import Fuga from "../../models/Fuga";
import Aislamiento from "../../models/Aislamiento";
import Emision from "../../models/Emision";
import Fermentacion from "../../models/Fermentacion";
import Estiercol from "../../models/Estiercol";
import Fertilizante from "../../models/Fertilizante";
import Electricidad from "../../models/Electricidad";
import Viaje from "../../models/Viaje";
import Producto from "../../models/Producto";
import Trasversal from "../../models/Trasversal";
import Otro from "../../models/Otro";
import PorcentajeCombustible from "../../models/PorcentajeCombustible";

export default {
    data() {
        return {
            options_fuente: [
                {
                    value: "combustibles_liquido",
                    label: "Consumo de combustible líquido",
                },
                {
                    value: "combustibles_solido",
                    label: "Consumo de combustible sólido",
                },
                {
                    value: "combustibles_gaseoso",
                    label: "Consumo de combustible gaseoso",
                },
                {
                    value: "refrigerantes",
                    label: "Consumo de refrigerantes y espumantes",
                },
                { value: "extintores", label: "Uso de extintores" },
                { value: "lubricantes", label: "Consumo de lubricantes" },
                { value: "fugas", label: "Fugas de CO2 en proceso" },
                {
                    value: "aislamientos",
                    label: "Consumo de aislante eléctrico",
                },

                {
                    value: "emisiones_embalse",
                    label: "Uso de embalses o represamientos de agua",
                },
                { value: "emisiones_mineria", label: "Procesos de minería" },
                {
                    value: "emisiones_industrial",
                    label: "Procesos industriales",
                },
                {
                    value: "emisiones_residuo",
                    label: "Procesos de gestión de residuos",
                },

                {
                    value: "fermentaciones",
                    label: "Procesos agricolas (ganadería - fermentación entérica)",
                },

                {
                    value: "estiercoles_estiercol",
                    label: "Procesos agrícolas (manejo de estiércol)",
                },
                {
                    value: "estiercoles_residuo",
                    label: "Proceso agrícolas (manejo de residuos agropecuarios) ",
                },

                {
                    value: "fertilizantes_fertilizante",
                    label: "Procesos agrícolas (uso de fertilizantes)",
                },
                { value: "fertilizantes_cal", label: "Procesos con cal" },

                {
                    value: "electricidades",
                    label: "Consumo de energía eléctrica",
                },
                { value: "viajes", label: "Viajes" },

                {
                    value: "productos_utiliza",
                    label: "Productos que utiliza la organización",
                },
                {
                    value: "productos_uso",
                    label: "Uso de productos de la organización",
                },

                { value: "trasversales", label: "Trasversales" },
                { value: "otros", label: "Otros" },
                {
                    value: "porcentajes",
                    label: "Porcentaje corporativo y biogenico",
                },
            ],
            fuente: "",
            fuentes: "",
        };
    },
    methods: {
        async getFuentes() {
            this.$root.mostrarCargando();

            let modelo;

            if (this.fuente.includes("combustibles")) {
                modelo = Combustible;
            } else if (this.fuente.includes("emisiones")) {
                modelo = Emision;
            } else if (this.fuente.includes("estiercoles")) {
                modelo = Estiercol;
            } else if (this.fuente.includes("fertilizantes")) {
                modelo = Fertilizante;
            } else if (this.fuente == "refrigerantes") {
                modelo = Refrigerante;
            } else if (this.fuente == "extintores") {
                modelo = Extintor;
            } else if (this.fuente == "lubricantes") {
                modelo = Lubricante;
            } else if (this.fuente == "fugas") {
                modelo = Fuga;
            } else if (this.fuente == "aislamientos") {
                modelo = Aislamiento;
            } else if (this.fuente == "fermentaciones") {
                modelo = Fermentacion;
            } else if (this.fuente == "electricidades") {
                modelo = Electricidad;
            } else if (this.fuente == "viajes") {
                modelo = Viaje;
            } else if (this.fuente.includes("productos")) {
                modelo = Producto;
            } else if (this.fuente == "trasversales") {
                modelo = Trasversal;
            } else if (this.fuente == "otros") {
                modelo = Otro;
            } else if (this.fuente == "porcentajes") {
                modelo = PorcentajeCombustible;
            }

            if (this.fuente.includes("_")) {
                this.fuentes = await modelo
                    .where("tipo", this.fuente.split("_")[1])
                    .get();
            } else {
                this.fuentes = await modelo.get();
            }

            Swal.close();
            $("#tabla-fuentes").DataTable().destroy();
            this.$tablaResultados("#tabla-fuentes");
        },
    },
};
</script>
<style>
.required:after {
    content: " *";
    color: red;
}
</style>
<style src="@vueform/multiselect/themes/default.css"></style>
