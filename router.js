import AuthService from './src/services/AuthService.js';
import LoginView from './src/views/LoginView.js';

class Router {
    constructor(routes) {
        this.routes = routes;
        this.rootElement = document.getElementById('app');
        this.authService = AuthService;
        this.init();
    }

    init() {
        window.addEventListener('popstate', () => this.handleLocation());
        this.handleLocation();
    }

    navigate(route) {
        window.history.pushState({}, '', route);
        this.handleLocation();
    }

    handleLocation() {
        const path = window.location.pathname;
        const route = this.routes.find(r => r.path === path);

        if (route) {
            // Vérification de l'authentification pour les routes protégées
            if (route.requireAuth && !this.authService.isAuthenticated()) {
                this.loadView(LoginView);
                return;
            }
            
            this.loadView(route.view);
        } else {
            // Route par défaut ou 404
            this.loadView(this.routes[0].view);
        }
    }

    async loadView(view) {
        this.rootElement.innerHTML = '';
        
        // Passer le routeur à la vue si nécessaire
        const viewInstance = typeof view === 'function' 
            ? new view(this) 
            : new view();
        
        await viewInstance.render();
    }
}

export default Router;