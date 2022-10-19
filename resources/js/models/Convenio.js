import Model from "./Model";

export default class Convenio extends Model {
    baseURL() {
        return "/api";
    }
    resource() {
        return "convenios"
    }
}