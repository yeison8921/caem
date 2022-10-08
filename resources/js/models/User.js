import Model from "./Model";

export default class User extends Model {
    baseURL() {
        return "/api";
    }
    resource() {
        return "users"
    }
}
