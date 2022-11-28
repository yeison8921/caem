import Model from "./Model";

export default class Emision extends Model {
    baseURL() {
        return "/api";
    }
    resource() {
        return "emisiones"
    }
}