import Article from "./Article.js";
import DemandeDette from "./DemandeDette.js";
import Model from "./Model.js";

class DemandeArticle {
	constructor(id, qteArticle, article = null, demandeDette = null) {
		this.id = id;
		this.qteArticle = qteArticle;
		this.article = article
			? Article.fromJSON(Model.getEntity(article))
			: null;
		this.demandeDette = demandeDette
			? DemandeDette.fromJSON(Model.getEntity(demandeDette))
			: null;
	}

	static fromJSON(data) {
		return new DemandeArticle(
			data.id,
			data.qteArticle,
			data.article,
			data.demandeDette
		);
	}

	toJSON() {
		return {
			id: this.id,
			qteArticle: this.qteArticle,
			article: this.article ? this.article.toJSON() : null,
			demandeDette: this.demandeDette ? this.demandeDette.toJSON() : null,
		};
	}
}

export default DemandeArticle;
