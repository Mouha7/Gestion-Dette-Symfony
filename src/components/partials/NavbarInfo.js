import SecurityController from "../../controllers/SecurityController.js";

class NavbarInfo {
	constructor() {
		this.securityController = new SecurityController();
	}

	static navbar() {
		const render = `
            <div class="navbar bg-gray-100 rounded mb-6 flex-none shadow-md">
                <div class="flex-none" id="menu-burger">
                    <button class="btn btn-square btn-ghost">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewbox="0 0 24 24"
                            class="inline-block h-5 w-5 stroke-current"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"
                            ></path>
                        </svg>
                    </button>
                </div>
                <div class="flex-1" id="input-title">
                    <a class="btn btn-ghost text-xl">GESTION BOUTIQUE</a>
                </div>
                <div class="flex-none gap-2">
                    <div class="form-control">
                    </div>
                    <div class="dropdown dropdown-end">
                        <div
                            tabindex="0"
                            role="button"
                            class="btn btn-ghost btn-circle avatar"
                        >
                            <div class="w-10 rounded-full">
                                <img
                                    alt="Navbar component"
                                    src="https://img.daisyui.com/images/stock/photo-1534528741775-53994a69daeb.webp"
                                />
                            </div>
                        </div>
                        <ul
                            tabindex="0"
                            class="menu menu-sm dropdown-content bg-gray-100 rounded-box z-[1] mt-3 w-52 p-2 shadow"
                        >
                            <li>
                                <a class="justify-between"> Profile </a>
                            </li>
                            <li>
                                <a>Settings</a>
                            </li>
                            <li>
                                <a id="logout">Logout</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        `;
		this.attachEventListeners();
		return render;
	}

	static attachEventListeners() {
		document.addEventListener("DOMContentLoaded", () => {
			const logout = document.querySelector("#logout");
			if (logout) {
                logout.addEventListener("click", () => {
                    const navbarInfo = new NavbarInfo();
                    try {
                        navbarInfo.securityController.logoutCheck();
                    } catch (error) {
                        console.error("Erreur lors de la déconnexion", error);
                    }
                });
            }
		});
	}
}

export default NavbarInfo;
