import Menu from "../components/Menu.js";
import ApiService from "../services/ApiService.js";

class HomeView {
    constructor(router) {
        this.router = router;
        this.apiService = ApiService;
    }

    render() {
        const container = document.getElementById("app");
        container.innerHTML = Menu.sideBarLeft();
        this.attachEventListeners();
    }

    attachEventListeners() {
        const logout = document.querySelector('.logout');
        // const user = document.querySelector('#user');
        logout.addEventListener('click', () => {
            try {
                this.apiService.logout();
            } catch(error) {
                console.error('Erreur lors de la déconnexion', error);
            }
        });

        // user.addEventListener('click', () => {
        //     this.router.navigate('/users');
        // });
    }
}

export default HomeView;