import SecurityController from "../controllers/SecurityController.js";

class LoginView {
	constructor(router) {
		this.router = router;
		this.securityController = new SecurityController();
	}

	render() {
		const container = document.getElementById("app");
		container.innerHTML = `
			<div class="flex flex-col bg-first py-3 items-center justify-center h-screen relative">
				<div class="w-full max-w-md bg-gray-100 rounded-lg shadow-md p-6">
					<div class="w-full flex justify-between items-center mb-4">
						<h2 class="text-2xl font-bold text-first">Login</h2>
						<img src="./assets/images/logo.png" alt="Logo App" class="w-[15%] aspect-square" >
					</div>
					<div role="alert" id="error-message">
					</div>
					<form class="flex flex-col" id="login-form">
						<input type="email" id="email" class="bg-gray-300 text-gray-900 border-0 rounded-md p-2 mb-4 focus:bg-gray-200 focus:outline-none focus:ring-1 focus:ring-first transition ease-in-out duration-150" placeholder="Email">
						<input type="password" id="password" class="bg-gray-300 text-gray-900 border-0 rounded-md p-2 mb-4 focus:bg-gray-200 focus:outline-none focus:ring-1 focus:ring-first transition ease-in-out duration-150" placeholder="Password">
						<div class="flex items-center justify-between flex-wrap">
							<label for="remember-me" class="text-sm text-gray-900 cursor-pointer">
							<input type="checkbox" id="remember-me" class="mr-2">
							Remember me
							</label>
							<a href="#" class="text-sm text-blue-500 hover:underline mb-0.5">Forgot password?</a>
							<p class="text-gray-900 mt-4"> Don't have an account? <a href="#" class="text-sm text-blue-500 -200 hover:underline mt-4">Signup</a></p>
						</div>
						<button class="bg-gradient-to-r from-first to-first text-gray-100 font-bold py-2 px-4 rounded-md mt-4 hover:bg-indigo-600 hover:to-blue-600 transition ease-in-out duration-150" type="submit">Se connecter</button>
					</form>
				</div>
				<footer class="bg-gray-200 p-4 text-center flex-none absolute bottom-0 rounded-t w-screen">
					<p>SMRS &copy; 2024 Gestion Boutique. Tous droits réservés.</p>
				</footer>
			</div>
        `;

		this.attachEventListeners();
	}

	attachEventListeners() {
		const form = document.getElementById("login-form");
		const errorMessage = document.getElementById("error-message");

		form.addEventListener("submit", async (e) => {
			e.preventDefault();

			const email = document.getElementById("email").value;
			const password = document.getElementById("password").value;

			try {
				await this.securityController.loginCheck({ email, password });
				// Redirection après connexion réussie
				this.router.navigate("/");
			} catch (error) {
				errorMessage.classList.add("alert", "alert-warning", "mb-4");
				errorMessage.innerHTML = `
					<svg
						xmlns="http://www.w3.org/2000/svg"
						class="h-6 w-6 shrink-0 stroke-current"
						fill="none"
						viewBox="0 0 24 24">
						<path
						stroke-linecap="round"
						stroke-linejoin="round"
						stroke-width="2"
						d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
					</svg>
					<span>Identifiants incorrects</span>
				`;
				setTimeout(() => {
					errorMessage.classList.remove("alert", "alert-warning");
                    errorMessage.innerHTML = "";
				}, 2000);
			}
		});
	}
}

export default LoginView;
