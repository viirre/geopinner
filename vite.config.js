import { defineConfig } from 'vite';

export default defineConfig({
  build: {
    rollupOptions: {
      input: {
        main: './index.html',
      },
    },
  },
  // Ensure public assets are copied correctly
  publicDir: 'public',
});
