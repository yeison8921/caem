import Model from "./Model";

export default class Fertilizante extends Model {
    baseURL() {
        return "/api";
    }
    resource() {
        return "fertilizantes"
    }
}