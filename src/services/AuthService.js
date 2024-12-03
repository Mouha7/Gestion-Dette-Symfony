class AuthService {
    isAuthenticated() {
        const token = localStorage.getItem('jwt_token');
        
        // Vérification simple de la présence du token
        // Vous pouvez ajouter une vérification de l'expiration si nécessaire
        return !!token;
    }

    // Middleware de routage
    requireAuth(router) {
        if (!this.isAuthenticated()) {
            router.navigate('/login');
            return false;
        }
        return true;
    }
}

export default new AuthService();