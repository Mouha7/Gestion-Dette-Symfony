import NavbarInfo from "./partials/NavbarInfo.js";
import Footer from "./partials/Footer.js";
import Container from "./partials/Container.js";

class Main {
	static sideBarLeft() {
		const render = `
            <div class="flex h-screen">
			<!-- Side Menu -->
			<aside
				class="w-64 bg-first py-3 z-10 text-gray-100 flex flex-col hidden"
				id="side-menu"
			>
				<div class="p-6 text-xl font-semibold cursor-pointer">
					GESTION BOUTIQUE
				</div>
				<nav class="mt-4 flex-grow">
					<ul class="space-y-2 text-white">
						<li>
							<button
								class="w-full py-2 px-4 flex items-center gap-2.5 hover:bg-gray-300 hover:text-first"
							>
								<svg
									xmlns="http://www.w3.org/2000/svg"
									viewbox="0 0 24 24"
									fill="currentColor"
									class="inline-block h-5 w-5 stroke-current"
								>
									<path
										fillrule="evenodd"
										d="M2.25 2.25a.75.75 0 0 0 0 1.5H3v10.5a3 3 0 0 0 3 3h1.21l-1.172 3.513a.75.75 0 0 0 1.424.474l.329-.987h8.418l.33.987a.75.75 0 0 0 1.422-.474l-1.17-3.513H18a3 3 0 0 0 3-3V3.75h.75a.75.75 0 0 0 0-1.5H2.25Zm6.54 15h6.42l.5 1.5H8.29l.5-1.5Zm8.085-8.995a.75.75 0 1 0-.75-1.299 12.81 12.81 0 0 0-3.558 3.05L11.03 8.47a.75.75 0 0 0-1.06 0l-3 3a.75.75 0 1 0 1.06 1.06l2.47-2.47 1.617 1.618a.75.75 0 0 0 1.146-.102 11.312 11.312 0 0 1 3.612-3.321Z"
										cliprule="evenodd"
									/>
								</svg>
								Dashboard
							</button>
						</li>
						<li>
							<button
								class="w-full py-2 px-4 flex items-center gap-2.5 hover:bg-gray-300 hover:text-first"
							>
								<svg
									xmlns="http://www.w3.org/2000/svg"
									viewbox="0 0 24 24"
									fill="currentColor"
									class="inline-block h-5 w-5 stroke-current"
								>
									<path
										d="M4.5 3.75a3 3 0 0 0-3 3v.75h21v-.75a3 3 0 0 0-3-3h-15Z"
									/>
									<path
										fill-rule="evenodd"
										d="M22.5 9.75h-21v7.5a3 3 0 0 0 3 3h15a3 3 0 0 0 3-3v-7.5Zm-18 3.75a.75.75 0 0 1 .75-.75h6a.75.75 0 0 1 0 1.5h-6a.75.75 0 0 1-.75-.75Zm.75 2.25a.75.75 0 0 0 0 1.5h3a.75.75 0 0 0 0-1.5h-3Z"
										clip-rule="evenodd"
									/>
								</svg>
								Dettes
							</button>
						</li>
						<li>
							<button
								class="w-full py-2 px-4 flex items-center gap-2.5 hover:bg-gray-300 hover:text-first"
							>
								<svg
									xmlns="http://www.w3.org/2000/svg"
									viewbox="0 0 24 24"
									fill="currentColor"
									class="inline-block h-5 w-5 stroke-current"
								>
									<path
										fill-rule="evenodd"
										d="M8.25 6.75a3.75 3.75 0 1 1 7.5 0 3.75 3.75 0 0 1-7.5 0ZM15.75 9.75a3 3 0 1 1 6 0 3 3 0 0 1-6 0ZM2.25 9.75a3 3 0 1 1 6 0 3 3 0 0 1-6 0ZM6.31 15.117A6.745 6.745 0 0 1 12 12a6.745 6.745 0 0 1 6.709 7.498.75.75 0 0 1-.372.568A12.696 12.696 0 0 1 12 21.75c-2.305 0-4.47-.612-6.337-1.684a.75.75 0 0 1-.372-.568 6.787 6.787 0 0 1 1.019-4.38Z"
										clip-rule="evenodd"
									/>
									<path
										d="M5.082 14.254a8.287 8.287 0 0 0-1.308 5.135 9.687 9.687 0 0 1-1.764-.44l-.115-.04a.563.563 0 0 1-.373-.487l-.01-.121a3.75 3.75 0 0 1 3.57-4.047ZM20.226 19.389a8.287 8.287 0 0 0-1.308-5.135 3.75 3.75 0 0 1 3.57 4.047l-.01.121a.563.563 0 0 1-.373.486l-.115.04c-.567.2-1.156.349-1.764.441Z"
									/>
								</svg>
								Clients</
							>
						</li>
						<li>
							<button
								class="w-full py-2 px-4 flex items-center gap-2.5 hover:bg-gray-300 hover:text-first"
							>
								<svg
									xmlns="http://www.w3.org/2000/svg"
									viewbox="0 0 24 24"
									fill="currentColor"
									class="inline-block h-5 w-5 stroke-current"
								>
									<path
										d="M2.25 2.25a.75.75 0 0 0 0 1.5h1.386c.17 0 .318.114.362.278l2.558 9.592a3.752 3.752 0 0 0-2.806 3.63c0 .414.336.75.75.75h15.75a.75.75 0 0 0 0-1.5H5.378A2.25 2.25 0 0 1 7.5 15h11.218a.75.75 0 0 0 .674-.421 60.358 60.358 0 0 0 2.96-7.228.75.75 0 0 0-.525-.965A60.864 60.864 0 0 0 5.68 4.509l-.232-.867A1.875 1.875 0 0 0 3.636 2.25H2.25ZM3.75 20.25a1.5 1.5 0 1 1 3 0 1.5 1.5 0 0 1-3 0ZM16.5 20.25a1.5 1.5 0 1 1 3 0 1.5 1.5 0 0 1-3 0Z"
									/>
								</svg>
								Articles</
							>
						</li>
						<li>
							<button
								class="w-full py-2 px-4 flex items-center gap-2.5 hover:bg-gray-300 hover:text-first"
							>
								<svg
									xmlns="http://www.w3.org/2000/svg"
									viewbox="0 0 24 24"
									fill="currentColor"
									class="inline-block h-5 w-5 stroke-current"
								>
									<path
										fill-rule="evenodd"
										d="M5.478 5.559A1.5 1.5 0 0 1 6.912 4.5H9A.75.75 0 0 0 9 3H6.912a3 3 0 0 0-2.868 2.118l-2.411 7.838a3 3 0 0 0-.133.882V18a3 3 0 0 0 3 3h15a3 3 0 0 0 3-3v-4.162c0-.299-.045-.596-.133-.882l-2.412-7.838A3 3 0 0 0 17.088 3H15a.75.75 0 0 0 0 1.5h2.088a1.5 1.5 0 0 1 1.434 1.059l2.213 7.191H17.89a3 3 0 0 0-2.684 1.658l-.256.513a1.5 1.5 0 0 1-1.342.829h-3.218a1.5 1.5 0 0 1-1.342-.83l-.256-.512a3 3 0 0 0-2.684-1.658H3.265l2.213-7.191Z"
										clip-rule="evenodd"
									/>
									<path
										fill-rule="evenodd"
										d="M12 2.25a.75.75 0 0 1 .75.75v6.44l1.72-1.72a.75.75 0 1 1 1.06 1.06l-3 3a.75.75 0 0 1-1.06 0l-3-3a.75.75 0 0 1 1.06-1.06l1.72 1.72V3a.75.75 0 0 1 .75-.75Z"
										clip-rule="evenodd"
									/>
								</svg>
								Demandes</
							>
						</li>
						<li>
							<button
								class="w-full py-2 px-4 flex items-center gap-2.5 hover:bg-gray-300 hover:text-first"
							>
								<svg
									xmlns="http://www.w3.org/2000/svg"
									viewbox="0 0 24 24"
									fill="currentColor"
									class="inline-block h-5 w-5 stroke-current"
								>
									<path
										fill-rule="evenodd"
										d="M7.5 6a4.5 4.5 0 1 1 9 0 4.5 4.5 0 0 1-9 0ZM3.751 20.105a8.25 8.25 0 0 1 16.498 0 .75.75 0 0 1-.437.695A18.683 18.683 0 0 1 12 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 0 1-.437-.695Z"
										clip-rule="evenodd"
									/>
								</svg>
								Utilisateurs</
							>
						</li>
					</ul>
				</nav>
			</aside>

			<!-- Main Content + Footer -->
			<div class="flex-1">
				<!-- Main Content Area -->
				<div
					class="flex-1 flex flex-col h-screen bg-gray-300 text-first px-6 pt-4 overflow-auto"
				>
                <div id="container">${this.sideBarRight()}</div>
            </div>
			</div>

		</div>
        `;
        this.eventSlide();
        return render;
	}

	static sideBarRight(data) {
		const render = `
            ${NavbarInfo.navbar()}
			${Container.container(data)}
            ${Footer.footer()}
        `;
        return render;
	}

	static eventSlide() {
		document.addEventListener("DOMContentLoaded", () => {
			// Client configuration
			const menuBurger = document.querySelector("#menu-burger");
			const inputTitle = document.querySelector("#input-title a");
			const sideMenu = document.querySelector("#side-menu");
			const hiddenAddUser = document.querySelector("#hidden-add-user");
			const createUser = document.querySelector("#created-user");

			// Événement pour le menu burger
			if (menuBurger) {
				menuBurger.addEventListener("click", () => {
					sideMenu.classList.toggle("hidden");
					inputTitle.classList.toggle("hidden");
				});
			}

			// Événement pour créer un utilisateur
			if (createUser) {
				createUser.addEventListener("click", () => {
					hiddenAddUser.classList.toggle("hidden");
				});
			}
		});
	}
}

export default Main;
