import UserView from "../views/UserView.js";
import ApiService from "../services/ApiService.js";
import User from "../models/User.js";
import UserService from "../services/UserService.js";
import Main from "../components/Main.js";
import HomeView from "../views/HomeView.js";

class UserController {
	constructor() {
		this.userService = new UserService();
		this.homeView = new HomeView();
	}

	async listUsers() {
		try {
			const users = await userService.getAll();
			this.homeView.render(users);
		} catch (error) {
			console.error(
				"Erreur lors de la récupération des données dans UserController: ",
				error
			);
			return null;
		}
	}
	// async listUsers() {
	//     await this.userService.getAll()
	//     .then(response => {
	//         // Traitez la réponse ici (par exemple, vérifiez si la réponse est correcte)
	//         console.log('Données récupérées :', response);
	//         return response; // Retournez les données pour les utiliser ailleurs
	//     })
	//     .catch(error => {
	//         // Gérez les erreurs ici
	//         console.error('Impossible de charger les utilisateurs :', error.message);
	//         return null; // Retournez null ou une valeur par défaut en cas d'erreur
	//     });
	// }

	async getOneBy() {
		try {
			const user = await this.userService.getByUser();
			localStorage.setItem("user", user);
			localStorage.setItem("role", user.role);
		} catch (error) {
			console.error("Impossible de charger l'utilisateur");
		}
	}
}

export default UserController;
