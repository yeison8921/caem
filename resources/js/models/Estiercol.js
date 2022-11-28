import Model from "./Model";

export default class Estiercol extends Model {
    baseURL() {
        return "/api";
    }
    resource() {
        return "estiercoles"
    }
}