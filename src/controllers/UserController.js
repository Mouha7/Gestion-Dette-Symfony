import UserView from '../views/UserView.js';
import ApiService from '../services/ApiService.js';
import User from '../models/User.js';

class UserController {
    constructor() {
        // this.view = new UserView();
        this.apiService = ApiService;
        this.email = localStorage.getItem('email');
    }

    async listUsers() {
        try {
            const users = await this.apiService.getUsers();
            // this.view.renderUserList(users);
        } catch (error) {
            this.view.showError('Impossible de charger les utilisateurs');
        }
    }

    async getOneBy() {
        try {
            const u = await this.apiService.get(`/user/info/${this.email}`);
            const user = new User();
            user.role = u.roles[0];
            user.surname = u.surname;
            localStorage.setItem('user', user);
        } catch (error) {
            this.view.showError('Impossible de charger l\'utilisateur');
        }
    }
}

export default UserController;