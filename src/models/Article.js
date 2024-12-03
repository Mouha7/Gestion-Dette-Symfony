class Article {
    constructor(id, libelle, prix, qteStock) {
        this.id = id;
        this.libelle = libelle;
        this.prix = prix;
        this.qteStock = qteStock;
    }

    static fromJSON(data) {
        return new Article(data.id, data.libelle, data.qteStock);
    }

    toJSON() {
        return {
            id: this.id,
            libelle: this.libelle,
            prix: this.prix,
            qteStock: this.qteStock
        };
    }
}

export default Article;