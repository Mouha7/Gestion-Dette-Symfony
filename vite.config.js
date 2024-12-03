import { defineConfig } from "vite";

export default defineConfig({
	css: {
		postcss: "./postcss.config.cjs",
	},
	server: {
		port: 8080,
		open: false, // Ouvre automatiquement dans le navigateur
		cors: true, // Active CORS si nécessaire
	},
	// Configuration pour les imports
	resolve: {
		alias: {
			"@": "/src", // Permet des imports plus courts
		},
	},
});
