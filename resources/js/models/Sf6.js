import Model from "./Model";

export default class Sf6 extends Model {
    baseURL() {
        return "/api";
    }
    resource() {
        return "sf6s"
    }
}