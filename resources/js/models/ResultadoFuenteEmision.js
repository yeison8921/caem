import Model from "./Model";

export default class ResultadoFuenteEmision extends Model {
    baseURL() {
        return "/api";
    }
    resource() {
        return "resultados_fuente_emision"
    }
}