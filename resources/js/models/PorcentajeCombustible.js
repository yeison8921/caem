import Model from "./Model";

export default class PorcentajeCombustible extends Model {
    baseURL() {
        return "/api";
    }
    resource() {
        return "porcentajes_combustible"
    }
}