export default class TableGenerator {
    constructor() {}

    static table(
        headers = [],
        datas = [],
        page = 1,
        limit = 10,
        total = 0
    ) {
        // Génération dynamique des en-têtes
        const headerRows = headers.map(header => 
            `<th class="py-0 px-4">${header}</th>`
        ).join('');

        // Génération dynamique des lignes de données
        const dataRows = datas.map((item, index) => `
            <tr class="text-gray-500 border-b-first">
                <td class="py-0 px-4">${index + 1}</td>
                ${headers.map(header => 
                    `<td class="py-0 px-4">${item[header.toLowerCase()] || 'N/A'}</td>`
                ).join('')}
                <td>
                    <a class="btn btn-active btn-ghost" href="#">Détails</a>
                </td>
            </tr>
        `).join('');

        // Calcul de la pagination
        const totalPages = Math.ceil(total / limit);
        const paginationButtons = Array.from({length: totalPages}, (_, i) => `
            <a 
                href="#" 
                class="join-item btn ${page === i + 1 ? 'bg-first text-gray-100' : 'bg-gray-100 text-first'}"
            >
                ${i + 1}
            </a>
        `).join('');

        const render = `
            <div class="w-full flex-auto overflow-auto space-y-4">
                <div class="flex justify-between items-center mb-4">
                    <select id="limit-select" class="select select-bordered w-full max-w-xs">
                        <option value="10" ${limit === 10 ? 'selected' : ''}>10 éléments</option>
                        <option value="25" ${limit === 25 ? 'selected' : ''}>25 éléments</option>
                        <option value="50" ${limit === 50 ? 'selected' : ''}>50 éléments</option>
                        <option value="100" ${limit === 100 ? 'selected' : ''}>100 éléments</option>
                    </select>
                </div>
                
                <table class="bg-gray-100 rounded-lg w-full">
                    <thead>
                        <tr class="bg-gray-300 text-gray-600 text-left text-sm py-2.5">
                            <th class="py-0 px-4">#</th>
                            ${headerRows}
                            <th class="py-0 px-4">Action</th>
                        </tr>
                    </thead>
                    <tbody id="list">
                        ${dataRows}
                    </tbody>
                </table>

                <div class="join self-center flex-none">
                    <button 
                        class="join-item btn ${page > 1 ? 'bg-first text-gray-100' : 'bg-gray-100 text-gray-400'}" 
                        ${page > 1 ? '' : 'disabled'}
                    >
                        Précédent
                    </button>
                    ${paginationButtons}
                    <button 
                        class="join-item btn ${page < totalPages ? 'bg-first text-gray-100' : 'bg-gray-100 text-gray-400'}" 
                        ${page < totalPages ? '' : 'disabled'}
                    >
                        Suivant
                    </button>
                </div>
            </div>
        `;

        return render;
    }

    // Méthode pour attacher des écouteurs d'événements
    static attachEventListeners() {
        const limitSelect = document.getElementById('limit-select');
        if (limitSelect) {
            limitSelect.addEventListener('change', (e) => {
                // Logique de changement de limite
                console.log('Nouvelle limite:', e.target.value);
                // Vous pouvez appeler une méthode de rechargement des données ici
            });
        }
    }
}