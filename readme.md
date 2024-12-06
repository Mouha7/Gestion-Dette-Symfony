# Frontend
- Installation de `axios`: 
```bash
npm install axios
```
- Installation de `Tailwind Css`:
```bash
npm install -D tailwindcss
npx tailwindcss init
```
config:
```javascript
/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./src/**/*.{html,js}"],
  theme: {
    extend: {},
  },
  plugins: [],
}
```
```css
@tailwind base;
@tailwind components;
@tailwind utilities;
```
```bash
npx tailwindcss -i ./src/input.css -o ./src/output.css --watch
```
- Installation de DaisyUI:
```bash
npm i -D daisyui@latest
```
- Installation et Utilisation de Vite comme dépendance de développement:
    1. Installation de Vite
    ```bash
    npm install vite -D
    ```
    2. Configuration de Vite (Modifier le package.json)
    ```json
    {
        "scripts": {
            "tailwind:dev": "npx tailwindcss -i ./styles/main.css -o ./styles/output.css --watch",
            "tailwind:build": "npx tailwindcss -i ./styles/main.css -o ./styles/output.css --minify",
            "dev": "concurrently \"npm run tailwind:dev\" \"vite\"",
            "build": "npm run tailwind:build && vite build",
            "preview": "vite preview"
        }
    }
    ```
    3. Créer un fichier `vite.config.js` à la racine du projet
    ```javascript
    import { defineConfig } from 'vite';

    export default defineConfig({
    server: {
        port: 3000,
        open: true, // Ouvre automatiquement dans le navigateur
        cors: true  // Active CORS si nécessaire
    },
    // Configuration pour les imports
    resolve: {
        alias: {
        '@': '/src'  // Permet des imports plus courts
        }
    }
    });
    ```

- Installation de concurrently : pour exécuter plusieurs commandes en parallèle
```bash
npm install -D concurrently
```


## Explication de Claude pour la mise en place
Je vais vous guider étape par étape pour créer un projet monolithique distribué avec Symfony pour le backend et JavaScript vanilla pour le frontend, en suivant une architecture MVC et SPA.

Structure de projet recommandée :
```
mon-projet/
│
├── backend/                  # Partie Symfony
│   ├── src/
│   ├── config/
│   ├── public/
│   └── composer.json
│
├── frontend/                 # Partie JavaScript Vanilla
│   ├── src/
│   │   ├── models/           # Classes de modèles
│   │   ├── views/            # Templates/Vues HTML
│   │   ├── controllers/      # Logique de contrôle
│   │   ├── services/         # Services pour les appels API
│   │   └── utils/            # Utilitaires
│   ├── index.html
│   ├── app.js                # Point d'entrée principal
│   └── router.js             # Gestion des routes
│
└── README.md
```

Configuration du Backend Symfony (API REST)

1. Configuration CORS dans Symfony
Dans `config/packages/cors.yaml` :
```yaml
framework:
    cors:
        enabled: true
        allow_origin: ['*']
        allow_methods: ['GET', 'POST', 'PUT', 'DELETE', 'OPTIONS']
        allow_headers: ['Content-Type', 'Authorization']
```

2. Installation d'Axios (dans le dossier frontend)
```bash
npm install axios
```

3. Création des services frontend (exemple)
`/frontend/src/services/apiService.js`
```javascript
import axios from 'axios';

class ApiService {
    constructor() {
        this.baseURL = 'http://localhost:8000/api';
        this.axios = axios.create({
            baseURL: this.baseURL,
            headers: {
                'Content-Type': 'application/json'
            }
        });
    }

    async getUsers() {
        try {
            const response = await this.axios.get('/users');
            return response.data;
        } catch (error) {
            console.error('Erreur lors de la récupération des utilisateurs', error);
            throw error;
        }
    }

    async createUser(userData) {
        try {
            const response = await this.axios.post('/users', userData);
            return response.data;
        } catch (error) {
            console.error('Erreur lors de la création', error);
            throw error;
        }
    }
}

export default new ApiService();
```

4. Router personnalisé (`/frontend/router.js`)
```javascript
class Router {
    constructor(routes) {
        this.routes = routes;
        this.rootElement = document.getElementById('app');
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
            this.loadView(route.view);
        } else {
            // Route par défaut ou 404
            this.loadView(this.routes[0].view);
        }
    }

    async loadView(view) {
        this.rootElement.innerHTML = '';
        const viewInstance = new view();
        await viewInstance.render();
    }
}

export default Router;
```

5. Exemple de contrôleur et vue (`/frontend/src/controllers/UserController.js`)
```javascript
import UserView from '../views/UserView.js';
import ApiService from '../services/apiService.js';

class UserController {
    constructor() {
        this.view = new UserView();
        this.apiService = ApiService;
    }

    async listUsers() {
        try {
            const users = await this.apiService.getUsers();
            this.view.renderUserList(users);
        } catch (error) {
            this.view.showError('Impossible de charger les utilisateurs');
        }
    }
}

export default UserController;
```

6. Vue correspondante (`/frontend/src/views/UserView.js`)
```javascript
class UserView {
    constructor() {
        this.container = document.getElementById('app');
    }

    renderUserList(users) {
        const userList = users.map(user => `
            <li>${user.name} - ${user.email}</li>
        `).join('');

        this.container.innerHTML = `
            <h1>Liste des utilisateurs</h1>
            <ul>${userList}</ul>
        `;
    }

    showError(message) {
        this.container.innerHTML = `
            <div class="error">${message}</div>
        `;
    }
}

export default UserView;
```

7. Point d'entrée principal (`/frontend/app.js`)
```javascript
import Router from './router.js';
import HomeView from './src/views/HomeView.js';
import UserView from './src/views/UserView.js';
import UserController from './src/controllers/UserController.js';

const routes = [
    { path: '/', view: HomeView },
    { path: '/users', view: () => {
        const controller = new UserController();
        controller.listUsers();
        return UserView;
    }}
];

const router = new Router(routes);
```

8. `index.html`
```html
<!DOCTYPE html>
<html>
<head>
    <title>Mon Application</title>
</head>
<body>
    <div id="app"></div>
    <script type="module" src="app.js"></script>
</body>
</html>
```

Points importants :
- Utilisation de modules ES6 pour la modularité
- Gestion des routes côté client
- Séparation claire MVC
- Communication via Axios
- Single Page Application (SPA)

Recommandations supplémentaires :
- Gérer les erreurs de manière centralisée
- Ajouter une authentification JWT
- Mettre en place des intercepteurs Axios
- Gérer le state de l'application

Cette architecture permet une séparation claire des responsabilités, une communication efficace entre frontend et backend, et une expérience utilisateur fluide.

Voulez-vous que je développe un point en particulier ou que je vous aide à mettre en place une partie spécifique du projet ?

## Modifications après la prise en compte du `JWT`
Excellent ! Je vais adapter l'architecture précédente pour intégrer l'authentification JWT dans le frontend.

1. Mise à jour du service API (`/frontend/src/services/apiService.js`)
```javascript
import axios from 'axios';

class ApiService {
    constructor() {
        this.baseURL = 'http://localhost:8000/api';
        this.axios = axios.create({
            baseURL: this.baseURL,
            headers: {
                'Content-Type': 'application/json'
            }
        });

        // Intercepteur pour ajouter le token à chaque requête
        this.axios.interceptors.request.use(
            config => {
                const token = localStorage.getItem('jwt_token');
                if (token) {
                    config.headers['Authorization'] = `Bearer ${token}`;
                }
                return config;
            },
            error => {
                return Promise.reject(error);
            }
        );

        // Intercepteur pour gérer les erreurs d'authentification
        this.axios.interceptors.response.use(
            response => response,
            error => {
                if (error.response && error.response.status === 401) {
                    // Token expiré ou invalide
                    this.logout();
                }
                return Promise.reject(error);
            }
        );
    }

    async login(credentials) {
        try {
            const response = await this.axios.post('/login', credentials);
            const { token } = response.data;
            
            // Stocker le token
            localStorage.setItem('jwt_token', token);
            
            return response.data;
        } catch (error) {
            console.error('Erreur de connexion', error);
            throw error;
        }
    }

    logout() {
        localStorage.removeItem('jwt_token');
        // Rediriger vers la page de connexion
        window.location.href = '/login';
    }

    // Autres méthodes API (getUsers, createUser, etc.)
    async getUsers() {
        try {
            const response = await this.axios.get('/users');
            return response.data;
        } catch (error) {
            console.error('Erreur lors de la récupération des utilisateurs', error);
            throw error;
        }
    }
}

export default new ApiService();
```

2. Vue de connexion (`/frontend/src/views/LoginView.js`)
```javascript
import ApiService from '../services/apiService.js';

class LoginView {
    constructor(router) {
        this.router = router;
        this.apiService = ApiService;
    }

    render() {
        const container = document.getElementById('app');
        container.innerHTML = `
            <div class="login-container">
                <form id="login-form">
                    <h2>Connexion</h2>
                    <input type="email" id="email" placeholder="Email" required>
                    <input type="password" id="password" placeholder="Mot de passe" required>
                    <button type="submit">Se connecter</button>
                    <div id="error-message" class="error"></div>
                </form>
            </div>
        `;

        this.attachEventListeners();
    }

    attachEventListeners() {
        const form = document.getElementById('login-form');
        const errorMessage = document.getElementById('error-message');

        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;

            try {
                await this.apiService.login({ email, password });
                // Redirection après connexion réussie
                this.router.navigate('/');
            } catch (error) {
                errorMessage.textContent = 'Identifiants incorrects';
            }
        });
    }
}

export default LoginView;
```

3. Gestionnaire d'authentification (`/frontend/src/services/authService.js`)
```javascript
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
```

4. Mise à jour du routeur (`/frontend/router.js`)
```javascript
import AuthService from './src/services/authService.js';
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
```

5. Mise à jour du point d'entrée (`/frontend/app.js`)
```javascript
import Router from './router.js';
import HomeView from './src/views/HomeView.js';
import UserView from './src/views/UserView.js';
import LoginView from './src/views/LoginView.js';
import UserController from './src/controllers/UserController.js';

const routes = [
    { path: '/', view: HomeView, requireAuth: true },
    { path: '/login', view: LoginView },
    { path: '/users', view: () => {
        const controller = new UserController();
        controller.listUsers();
        return UserView;
    }, requireAuth: true }
];

const router = new Router(routes);
```

Fonctionnalités ajoutées :
- Gestion du token JWT côté frontend
- Intercepteurs Axios pour ajouter le token aux requêtes
- Gestion des erreurs d'authentification
- Service d'authentification avec méthode de vérification
- Middleware de routage pour protéger les routes
- Vue de connexion avec gestion des erreurs
- Stockage du token dans le localStorage
- Redirection automatique en cas de token invalide

Améliorations possibles :
- Ajouter une vérification de l'expiration du token
- Implémenter un mécanisme de refresh token
- Ajouter des messages d'erreur plus détaillés
- Gérer le state de l'application de manière plus robuste

Recommendations de sécurité :
- Utilisez HTTPS
- Implémentez le httpOnly pour les cookies côté serveur
- Ajoutez des mécanismes de protection contre les attaques CSRF
- Limitez la durée de vie des tokens

Voulez-vous que je développe un aspect en particulier ou que je vous aide à intégrer cette solution ?