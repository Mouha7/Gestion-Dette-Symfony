import UserController from "../controllers/UserController.js";

class UserView {
    constructor(router) {
		this.router = router;
		this.controller = new UserController();
	}

    async render() {
        await this.controller.getOneBy();
    }
}

export default UserView;