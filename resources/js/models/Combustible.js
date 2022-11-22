import Model from "./Model";

export default class Combustible extends Model {
    baseURL() {
        return "/api";
    }
    resource() {
        return "combustibles"
    }
}