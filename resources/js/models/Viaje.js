import Model from "./Model";

export default class Viaje extends Model {
    baseURL() {
        return "/api";
    }
    resource() {
        return "viajes"
    }
}