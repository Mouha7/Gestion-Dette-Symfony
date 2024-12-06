class Btn {
    static btn({
        text = 'Défaut',
        id = '',
        type = 'button',
        disabled = false,
        additionalClasses = ''
    } = {}) {
        const render = `
            <button
                class="btn btn-active bg-first text-gray-100 ${additionalClasses}"
                id="${id}"
                type="${type}"
                ${disabled ? 'disabled' : ''}
            >
                ${text}
            </button>
        `;
        return render;
    }
}

export default Btn;