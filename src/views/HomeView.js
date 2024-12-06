import Main from "../components/Main.js";
import SecurityController from "../controllers/SecurityController.js";
import UserController from "../controllers/UserController.js";

class HomeView {
    constructor(router) {
        this.router = router;
        this.securityController = new SecurityController();
        this.userController = new UserController();
    }

    render(users) {
        const container = document.getElementById("app");
        container.innerHTML = Main.sideBarLeft(users);
        this.eventMenu();
    }

    eventMenu() {
		document.addEventListener("DOMContentLoaded", () => {
			// Ajout d'événements pour chaque élément de menu
			const menuItems = document.querySelectorAll("#side-menu ul li button");
			menuItems.forEach((item) => {
				item.addEventListener("click", (e) => {
					// Retirer la classe active de tous les éléments
					menuItems.forEach((menuItem) => {
						menuItem.classList.remove("bg-gray-300", "text-first");
					});

					// Ajouter la classe active à l'élément cliqué
					e.currentTarget.classList.add("bg-gray-300", "text-first");

					// Récupérer le texte de l'élément cliqué
					const sectionTitle = e.currentTarget.textContent.trim();

					// Exemple de gestion de navigation basique
					switch (sectionTitle) {
						case "Dashboard":
							// Logique pour afficher le tableau de bord
							console.log("Naviguer vers le Dashboard");
							break;
						case "Dettes":
							console.log("Naviguer vers les Dettes");
							break;
						case "Clients":
							console.log("Naviguer vers les Clients");
							break;
						case "Articles":
							console.log("Naviguer vers les Articles");
							break;
						case "Demandes":
							console.log("Naviguer vers les Demandes");
							break;
						case "Utilisateurs":
							console.log("Naviguer vers les Utilisateurs");
							break;
						case "Logout":
							// Logique de déconnexion
							console.log("Déconnexion");
							break;
					}
				});
			});
		});
	}
}

export default HomeView;