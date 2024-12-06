import Router from './router.js';
import HomeView from './src/views/HomeView.js';
import UserView from './src/views/UserView.js';
import LoginView from './src/views/LoginView.js';

const routes = [
    { path: '/', view: HomeView, requireAuth: true },
    { path: '/login', view: LoginView },
    { path: '/users', view: UserView, requireAuth: true }
    // { path: '/users', view: () => {
    //     const controller = new UserController();
    //     // controller.listUsers();
    //     controller.getOneBy();
    //     return UserView;
    // }, requireAuth: true }
];

const router = new Router(routes);