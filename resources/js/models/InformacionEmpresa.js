import Model from "./Model";

export default class InformacionEmpresa extends Model {
    baseURL() {
        return "/api";
    }
    resource() {
        return "informacion_empresas"
    }
}