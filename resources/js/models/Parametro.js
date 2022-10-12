import Model from "./Model";

export default class Parametro extends Model {
    baseURL() {
        return "/api";
    }
    resource() {
        return "parametros"
    }
}