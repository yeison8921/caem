import Model from "./Model";

export default class EmpresaSede extends Model {
    baseURL() {
        return "/api";
    }
    resource() {
        return "empresa_sedes"
    }
}