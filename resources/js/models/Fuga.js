import Model from "./Model";

export default class Fuga extends Model {
    baseURL() {
        return "/api";
    }
    resource() {
        return "fugas"
    }
}