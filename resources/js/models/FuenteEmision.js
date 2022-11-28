import Model from "./Model";

export default class FuenteEmision extends Model {
    baseURL() {
        return "/api";
    }
    resource() {
        return "fuentes_emision"
    }
}