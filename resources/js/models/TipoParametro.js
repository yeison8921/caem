import Model from "./Model";

export default class TipoParametro extends Model {
    baseURL() {
        return "/api";
    }
    resource() {
        return "tipos"
    }
}