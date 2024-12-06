import ApiService from "../services/ApiService.js";

export default class {
    constructor() {
        this.apiService = new ApiService();
    }

    async loginCheck(credentials) {
        return await this.apiService.login(credentials);
    }

    logoutCheck() {
        this.apiService.logout();
    }

    async receive(uri) {
        return await this.apiService.get(uri);
    }

    async send(uri, data) {
        return await this.apiService.post(uri, data);
    }

    async update(uri, data) {
        return await this.apiService.put(uri, data);
    }
}