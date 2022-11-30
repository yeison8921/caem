import Model from "./Model";

export default class Eletricidad extends Model {
    baseURL() {
        return "/api";
    }
    resource() {
        return "electricidades"
    }
}