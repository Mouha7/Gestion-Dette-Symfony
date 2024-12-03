/** @type {import('tailwindcss').Config} */
module.exports = {
	content: ["./src/**/*.{html,js}", "./index.html"],
	theme: {
		extend: {},
		colors: {
			first: "#003049",
			two: "#6a994e",
			third: "#a7c957",
			info: "#F2E8CF",
			warning: "#FFB723",
			error: "#BC4749",
			gray: {
				100: "#F9FAFC",
				200: "#F3F4F6",
				300: "#E5E7EB",
				400: "#D1D3D8",
				500: "#A0A3A8",
				600: "#71717A",
				700: "#525356",
				800: "#3F4144",
				900: "#2D3033",
			},
		},
	},
	plugins: [require("daisyui")],
};
