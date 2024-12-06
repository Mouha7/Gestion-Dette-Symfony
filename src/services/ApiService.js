import axios from 'axios';

class ApiService {
    constructor() {
        this.baseURL = 'https://localhost:8000/api';
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
            const response = await this.axios.post('/login_check', credentials);
            const { token } = response.data;
            // Stocker le token
            localStorage.setItem('jwt_token', token);
            localStorage.setItem('email', credentials.email);
            return response.data;
        } catch (error) {
            console.error('Erreur de connexion', error);
            throw error;
        }
    }

    logout() {
        localStorage.removeItem('jwt_token');
        localStorage.removeItem('email');
        localStorage.removeItem('user');
        localStorage.removeItem('role');
        // Rediriger vers la page de connexion
        window.location.href = '/login';
    }

    // Autres méthodes API (getUsers, createUser, etc.)
    async get(uri) {
        try {
            const response = await this.axios.get(uri);
            return response.data;
        } catch (error) {
            console.error('Erreur lors de la récupération des données', error);
            throw error;
        }
    }

    async post(uri, data) {
        try {
            const response = await this.axios.post(uri, data);
            return response.data;
        } catch (error) {
            console.error('Erreur lors de la envoie des données', error);
            throw error;
        }
    }

    async put(uri, data) {
        try {
            const response = await this.axios.put(uri, data);
            return response.data;
        } catch (error) {
            console.error('Erreur lors de la modification des données', error);
            throw error;
        }
    }
}

export default ApiService;