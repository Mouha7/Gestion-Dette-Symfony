import User from "./User.js";
import Model from "./Model.js";
import Dette from "./Dette.js";

class Client {
    constructor(id, surname, tel, address, cumulMontantDu, dettes = [], user = null) {
        this.id = id;
        this.surname = surname;
        this.tel = tel;
        this.address = address;
        this.cumulMontantDu = cumulMontantDu;
        this.dettes = dettes.map(d => Dette.fromJSON(Model.getEntity(d)));
        this.user = user ? User.fromJSON(Model.getEntity(user)) : null;
    }

    static fromJSON(data) {
        return new Client(
            data.id, 
            data.surname, 
            data.tel, 
            data.address, 
            data.cumulMontantDu,
            data.dettes, 
            data.user
        );
    }

    toJSON() {
        return {
            id: this.id,
            surname: this.surname,
            tel: this.tel,
            address: this.address,
            cumulMontantDu: this.cumulMontantDu,
            client: this.client ? this.client.toJSON() : null
        };
    }
}

export default Client;