import Model from "./Model";

export default class Refrigerante extends Model {
    baseURL() {
        return "/api";
    }
    resource() {
        return "refrigerantes"
    }
}