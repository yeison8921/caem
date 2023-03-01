<template>
    <div class="col-lg-12">
        <div class="row">
            <div class="form-group">
                <br />
                <h4>{{ datos.accion }} producto</h4>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <form @submit.prevent="submit">
                    <div class="mb-3">
                        <label class="form-label required">Nombre</label>
                        <input
                            v-model="producto.nombre"
                            type="text"
                            class="form-control"
                            required
                        />
                    </div>
                    <div class="mb-3">
                        <label class="form-label required"
                            >Unidad de consumo</label
                        >
                        <input
                            v-model="producto.unidad_consumo"
                            type="text"
                            class="form-control"
                            required
                        />
                    </div>
                    <div class="mb-3">
                        <label class="form-label required"
                            >Factor de emisión CO2e</label
                        >
                        <input
                            v-model="producto.factor_emision_co2"
                            type="number"
                            step="any"
                            class="form-control"
                            required
                        />
                    </div>
                    <div class="mb-3">
                        <label class="form-label required"
                            >Unidad factor de emisión CO2</label
                        >
                        <input
                            v-model="producto.unidad_factor_emision_co2"
                            type="text"
                            class="form-control"
                            required
                        />
                    </div>
                    <div class="mb-3">
                        <label class="form-label required"
                            >Incertidumbre (+/- %) CO2 1</label
                        >
                        <input
                            v-model="producto.incertidumbre_co2_1"
                            type="number"
                            step="any"
                            class="form-control"
                            required
                        />
                    </div>
                    <div class="mb-3">
                        <label class="form-label required"
                            >Incertidumbre (+/- %) CO2 2</label
                        >
                        <input
                            v-model="producto.incertidumbre_co2_2"
                            type="number"
                            step="any"
                            class="form-control"
                            required
                        />
                    </div>
                    <div class="mb-3">
                        <label class="form-label required"
                            >Fuente bibliográfica CO2</label
                        >
                        <input
                            v-model="producto.fuente_bibliografica_co2"
                            type="text"
                            class="form-control"
                            required
                        />
                    </div>
                    <div class="mb-3">
                        <label class="form-label required">Tipo producto</label>
                        <Multiselect
                            v-model="producto.subtipo"
                            :options="options_subtipo"
                            placeholder="Seleccione una opción"
                            required
                        />
                    </div>

                    <div class="mb-3">
                        <div class="col-lg-4 offset-lg-4">
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">
                                    Guardar
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
<script>
import Producto from "../../../models/Producto";

export default {
    data() {
        return {
            producto: new Producto({}),
            options_subtipo: "",
        };
    },
    props: ["datos"],

    mounted() {
        if (this.datos.tipo != "utiliza" && this.datos.tipo != "uso") {
            this.$root.mostrarMensaje(
                "Error",
                "No existe el tipo de producto especificado",
                "error"
            );
            this.$root.redirectIndex("/fuentes");
        }

        if (this.datos.tipo == "utiliza") {
            this.options_subtipo = [
                { value: "producto", label: "Producto" },
                { value: "equipo", label: "Equipo" },
                { value: "materia_prima", label: "Materia prima" },
                { value: "servicio", label: "Servicio" },
            ];
        } else {
            this.options_subtipo = [
                { value: "uso", label: "Uso" },
                { value: "destino", label: "Destino" },
                { value: "activo", label: "Activo" },
                { value: "inversion", label: "Inversion" },
            ];
        }

        if (this.datos.accion == "Actualizar") {
            this.getProducto();
        }
    },
    methods: {
        async getProducto() {
            this.producto = await Producto.find(this.datos.id_producto);
        },

        async submit() {
            this.$root.mostrarCargando("Guardando");
            if (this.datos.accion == "Crear") {
                this.producto.tipo = this.datos.tipo;
            }
            if (this.datos.accion == "Actualizar") {
                this.producto.id = this.datos.id_producto;
            }
            await this.producto.save();
            Swal.close();
            this.$root.mostrarMensaje(
                "Éxito",
                "Guardado exitosamente",
                "success"
            );
            this.$root.redirectIndex("/fuentes");
        },
    },
};
</script>
