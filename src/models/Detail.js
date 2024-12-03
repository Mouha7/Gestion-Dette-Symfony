import Article from "./Article.js";
import Dette from "./Dette.js";
import Model from "./Model.js";

class Detail {
	constructor(id, qte, prixVente, article = null, dette = null) {
		this.id = id;
		this.qte = qte;
		this.prixVente = prixVente;
		this.article = article
			? Article.fromJSON(Model.getEntity(article))
			: null;
		this.dette = dette ? Dette.fromJSON(Model.getEntity(dette)) : null;
	}

	static fromJSON(data) {
		return new Detail(
			data.id,
			data.qte,
			data.prixVente,
			data.article,
			data.dette
		);
	}

	toJSON() {
		return {
			id: this.id,
			qte: this.qte,
			prixVente: this.prixVente,
			article: this.article ? this.article.toJSON() : null,
			dette: this.dette ? this.dette.toJSON() : null,
		};
	}
}

export default Detail;
