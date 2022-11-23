import Model from "./Model";

export default class Aislamiento extends Model {
    baseURL() {
        return "/api";
    }
    resource() {
        return "aislamientos"
    }
}