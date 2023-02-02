import Model from "./Model";

export default class Otro extends Model {
    baseURL() {
        return "/api";
    }
    resource() {
        return "otros"
    }
}