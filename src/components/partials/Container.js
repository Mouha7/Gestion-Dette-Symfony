import Btn from "./Btn.js";
import Card from "./Card.js";
import Table from "./Table.js";
import UserController from "../../controllers/UserController.js";

class Container {
	constructor() {}

	static container(users) {
		const btn = Btn.btn({
			text: "Voir tous les articles",
			id: "user",
		});
		const card = Card.cardSlideTopLeft();
		const card_1 = Card.cardSlideTopRight();
		const card_2 = Card.cardManyBarHorizontal();
		const card_3 = Card.cardManyBar();
		console.log(users);
		const table = Table.table(
			users.headers,
			users.datas,
			users.limit,
			users.page,
			users.total
		);

		const render = `
            <div class="flex flex-col gap-4 mb-20">
                <div
                    class="bg-gray-100 text-gray-500 rounded-lg h-[200px] flex gap-2.5 shadow-md p-4 overflow-auto"
                >
                    ${card}
                    ${card_1}
                    ${card_2}
                    ${card_3}
                </div>
                <div
                class="bg-gray-100 rounded-lg h-[450px] flex flex-col gap-2.5 shadow-md p-4 overflow-auto"
                >
                    <h3 class="font-semibold text-lg flex-none mb-4">Liste</h3>
                    ${table}
                </div>
            </div>
        `;
		return render;
	}
}

export default Container;
