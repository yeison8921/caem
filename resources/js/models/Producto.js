import Model from "./Model";

export default class Producto extends Model {
    baseURL() {
        return "/api";
    }
    resource() {
        return "productos"
    }
}