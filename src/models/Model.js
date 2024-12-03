import ApiService from "../services/ApiService.js";

class Model {
    async getEntity(data) {
        const match = data.match(/\/api\/(\w+)\/(\d+)/);
        const resource = match[1].replace(/s$/, '');  // Supprime le "s" final s'il existe
        const id = match[2];

        return await ApiService.get(resource + `/${id}`)
    }
}

export default Model;
