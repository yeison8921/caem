import Model from "./Model";

export default class Extintor extends Model {
    baseURL() {
        return "/api";
    }
    resource() {
        return "extintores"
    }
}