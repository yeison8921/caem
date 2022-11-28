import Model from "./Model";

export default class Fermentacion extends Model {
    baseURL() {
        return "/api";
    }
    resource() {
        return "fermentaciones"
    }
}