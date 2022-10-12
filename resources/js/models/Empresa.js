import Model from "./Model";

export default class Empresa extends Model {
    baseURL() {
        return "/api";
    }
    resource() {
        return "empresas"
    }
}