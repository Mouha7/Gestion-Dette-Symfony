import Client from "./Client.js";
import Dette from "./Dette.js";
import Model from "./Model.js";

class DemandeDette {
    constructor(id, montantTotal, etat, client = null, dette = null) {
        this.id = id;
        this.montantTotal = montantTotal;
        this.etat = etat;
        this.client = client ? Client.fromJSON(Model.getEntity(client)) : null;
        this.dette = dette ? Dette.fromJSON(Model.getEntity(dette)) : null;
    }

    static fromJSON(data) {
        return new DemandeDette(
            data.id,
            data.montantTotal,
            data.etat,
            data.client,
            data.dette
        );
    }

    toJSON() {
        return {
            id: this.id,
            montantTotal: this.montantTotal,
            client: this.client? this.client.toJSON() : null,
            dette: this.dette? this.dette.toJSON() : null,
        };
    }
}

export default DemandeDette;