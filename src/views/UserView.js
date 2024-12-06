import UserController from "../controllers/UserController.js";

class UserView {
    constructor(router) {
		this.router = router;
		this.userController = new UserController();
	}

    async render() {
        const users = await this.userController.getOneBy();
    }
}

export default UserView;