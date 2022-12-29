<template>
    <div class="col-lg-12">
        <div class="row">
            <div class="form-group">
                <br />
                <h2>Administración fuentes de emisión</h2>
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
                            <div class="d-grid gap-2">
                                <a
                                    :href="
                                        fuente.includes('combustibles') ||
                                        fuente.includes('emisiones') ||
                                        fuente.includes('estiercoles') ||
                                        fuente.includes('fertilizantes')
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
                                                fuente.includes(
                                                    'combustibles'
                                                ) ||
                                                fuente.includes('emisiones') ||
                                                fuente.includes(
                                                    'estiercoles'
                                                ) ||
                                                fuente.includes('fertilizantes')
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

export default {
    data() {
        return {
            options_fuente: [
                { value: "combustibles_liquido", label: "Combustible líquido" },
                { value: "combustibles_solido", label: "Combustible sólido" },
                { value: "combustibles_gaseoso", label: "Combustible gaseoso" },
                { value: "refrigerantes", label: "Refrigerante" },
                { value: "extintores", label: "Extintor" },
                { value: "lubricantes", label: "Lubricante" },
                { value: "fugas", label: "Fuga" },
                { value: "aislamientos", label: "Aislamiento" },

                { value: "emisiones_embalse", label: "Manejo de embalses" },
                { value: "emisiones_mineria", label: "Minería" },
                { value: "emisiones_industrial", label: "Industrial" },
                { value: "emisiones_residuo", label: "Residuo organizacional" },

                { value: "fermentaciones", label: "Fermentación Entérica" },

                { value: "estiercoles_estiercol", label: "Estiercol" },
                {
                    value: "estiercoles_residuo",
                    label: "Residuo agropecuario",
                },

                { value: "fertilizantes_fertilizante", label: "Fertilizante" },
                { value: "fertilizantes_cal", label: "Cal" },

                { value: "electricidades", label: "Electricidad" },
                { value: "viajes", label: "Viaje" },
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
            }

            if (
                this.fuente.includes("combustible") ||
                this.fuente.includes("emision") ||
                this.fuente.includes("estiercol") ||
                this.fuente.includes("fertilizante")
            ) {
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
        // async confirmarEliminar(id_parametro) {
        //     Swal.fire({
        //         title: "¿Está seguro que desea desactivar este parámetro?",
        //         html: "El parámetro no se mostrará mas en el sistema pero los datos relacionados persistirán",
        //         icon: "question",
        //         showCancelButton: true,
        //         cancelButtonlabel: "No",
        //         confirmButtonlabel: "Si, eliminar",
        //         confirmButtonColor: "rgb(48, 133, 214)",
        //     }).then((result) => {
        //         if (result.isConfirmed) {
        //             this.eliminarParametro(id_parametro);
        //         }
        //     });
        // },
        // async eliminarParametro(id_parametro) {
        //     this.$root.mostrarCargando("Eliminando parámetro");
        //     try {
        //         let parametro = await Parametro.find(id_parametro);
        //         parametro.delete();
        //         Swal.close();
        //         this.$root.mostrarMensaje(
        //             "Éxito",
        //             "Parámetro eliminado exitosamente",
        //             "success"
        //         );
        //         setTimeout(() => {
        //             this.getParametros();
        //         }, 2000);
        //     } catch (e) {}
        // },
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
