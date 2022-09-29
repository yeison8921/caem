<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Example Component</div>

                    <div class="card-body">
                        I'm an example component. Table
                        <table class="table" id="tabla">
                            <thead>
                                <tr>
                                    <th scope="col">First</th>
                                    <th scope="col">Last</th>
                                    <th scope="col">Handle</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Mark</td>
                                    <td>Otto</td>
                                    <td>@mdo</td>
                                </tr>
                                <tr>
                                    <td>Jacob</td>
                                    <td>Thornton</td>
                                    <td>@fat</td>
                                </tr>
                            </tbody>
                        </table>

                        Multiselect
                        <Multiselect
                            :options="options"
                            placeholder="Seleccione una opción"
                            required
                        />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    mounted() {
        console.log("Component mounted.");
        this.tabla();
    },
    data() {
        return {
            options: [
                { value: 1, label: "1" },
                { value: 2, label: "2" },
                { value: 3, label: "3" },
            ],
        };
    },
    methods: {
        tabla() {
            $("#tabla").DataTable().destroy();
            this.$tablaGlobal("#tabla");
        },
    },
};
</script>
<style src="@vueform/multiselect/themes/default.css"></style>
