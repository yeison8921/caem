import Model from "./Model";

export default class ConvenioEmail extends Model {
    baseURL() {
        return "/api";
    }
    resource() {
        return "convenio_emails"
    }
}