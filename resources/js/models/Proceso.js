import Model from "./Model";

export default class Proceso extends Model {
    baseURL() {
        return "/api";
    }
    resource() {
        return "procesos"
    }
}