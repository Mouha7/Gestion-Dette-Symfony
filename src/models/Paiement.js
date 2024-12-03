import Dette from "./Dette.js";
import Model from "./Model.js";

class Paiement {
    constructor(id, montantPaye, createdAt, dette = null) {
        this.id = id;
        this.montantPaye = montantPaye;
        this.createdAt = createdAt;
        this.dette = dette ? Dette.fromJSON(Model.getEntity(dette)) : null;
    }

    static fromJSON(data) {
        return new Paiement(
            data.id,
            data.montantPaye,
            data.createdAt,
            data.dette
        );
    }

    toJSON() {
        return {
            id: this.id,
            montantPaye: this.montantPaye,
            createdAt: this.createdAt,
            dette: this.dette? this.dette.toJSON() : null,
        };
    }
}

export default Paiement;