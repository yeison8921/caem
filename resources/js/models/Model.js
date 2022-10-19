import { Model as BaseModel } from "vue-api-query";

export default class Model extends BaseModel {
    // define a base url for a REST API
    baseURL() {
        return "/api/v1/admin";
    }

    // implement a default request method
    request(config) {
        return this.$http.request(config);
    }

    // Overwrite save method to more easily deal with 422 errors
    async save() {
            try {
                let result = null
                await super.save().then(response => {
                    result = response;
                    Swal.fire({
                        title: "Éxito",
                        html: "Guardado exitosamente",
                        icon: "success",
                        showConfirmButton: false,
                        allowEscapeKey: false,
                        allowOutsideClick: false,
                        timer: 2000,
                        confirmButtonColor: "#28a745",
                    });
                });
                return result;
            } catch (e) {
                console.log(e);
                if (e.response) {
                    if (e.response.status == 422) {
                        var errorText = "";
                        Object.entries(e.response.data.errors).forEach(([key, value]) => {
                            value.forEach(errorMessage => {
                                errorText += "" + errorMessage + " <br>";
                            });
                        });
                        Swal.fire('', errorText, 'error');
                        return e.response;
                    } else {
                        Swal.fire('', 'Server error', 'error');
                    }
                } else {
                    Swal.fire('', 'Frontend Error', 'error');
                }
            } finally {
                // Stuff I want to do regardless of success/fail
            }
        }
        // async update() {
        //     console.log("entra");
        //     try {
        //         await super.patch().then(response => {

    //         })

    //     } catch (e) {

    //     }
    // }
}