import AbstractDto from "../dto/AbstractDto.js";
import User from "../models/User.js";
import ApiService from "../services/ApiService.js";

class UserService extends ApiService {
	constructor() {
		super();
		this.users = null; // Initialisation lazy
		this.user = null; // Initialisation lazy
		this.email = localStorage.getItem("email");
		this.abstractDto = null; // Initialisation lazy
	}

	async getAll() {
		return await this.get("/user")
			.then((users_json) => {
				const headers = Object.keys(users_json.users[0]);
                headers.pop();
				this.users = users_json.users.map((u) => User.fromJSON(u));
				this.abstractDto = new AbstractDto(
					headers,
					this.users,
					users_json.limit,
					users_json.page,
					users_json.total
				);
				return this.abstractDto.getDto();
			})
			.catch((e) => {
				console.error(
					"Erreur lors du chargement des données dans UserService: " +
						e
				);
				return null;
			});
	}

	async getByUser() {
		if (this.user === null) {
			const user_json = await this.get(`/user/info/${this.email}`);
			this.user = User.fromJSON(user_json);
		}
		return this.user;
	}
}

export default UserService;
