import Model from "./Model.js";
import Client from "./Client.js";

class Dette {
	constructor(id, montantTotal, montantVerser, status, etat, client = null) {
		this.id = id;
		this.montantTotal = montantTotal;
		this.montantVerser = montantVerser;
        this.status = status;
        this.etat = etat;
		this.client = client ? Client.fromJSON(Model.getEntity(client)) : null;
	}

	static fromJSON(data) {
		return new Dette(
			data.id,
			data.montantTotal,
			data.montantVerser,
            data.status,
            data.etat,
			data.client
		);
	}

	toJSON() {
		return {
			id: this.id,
			montantTotal: this.montantTotal,
			montantVerser: this.montantVerser,
			client: this.client ? this.client.toJSON() : null,
		};
	}
}

export default Dette;
