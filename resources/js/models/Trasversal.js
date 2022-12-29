import Model from "./Model";

export default class Trasversal extends Model {
    baseURL() {
        return "/api";
    }
    resource() {
        return "trasversales"
    }
}