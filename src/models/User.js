class User {
    constructor(id, email, login, password, role) {
        this.id = id;
        this.email = email;
        this.login = login;
        this.password = password;
        this.role = role;
    }

    static fromJSON(data) {
        return new User(data.id, data.email, data.login, data.password, data.role);
    }

    toJSON() {
        return {
            id: this.id,
            email: this.email,
            login: this.login,
            password: this.password
        };
    }
}

export default User;