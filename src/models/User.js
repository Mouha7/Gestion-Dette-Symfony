class User {
    constructor(id, surname, email, login, password, roles) {
        this.id = id ?? null;
        this.surname = surname?? null;
        this.email = email ?? null;
        this.login = login ?? null;
        this.password = password ?? null;
        this.role = roles[0] ?? null;
    }

    static fromJSON(data) {
        return new User(data.id, data.surname, data.email, data.login, data.password, data.roles);
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