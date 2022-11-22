import Model from "./Model";

export default class Lubricante extends Model {
    baseURL() {
        return "/api";
    }
    resource() {
        return "lubricantes"
    }
}