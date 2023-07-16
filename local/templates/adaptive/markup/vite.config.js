const path = require('path')
import handlebars from 'vite-plugin-handlebars';

export default {
  root: __dirname,
  base: './',
  build: {
    outDir: './dist',
    //При необходимости отладки кода билда, можно раскомментировать параметры ниже.
    // minify: false,
    // cssMinify: false,
    // sourcemap: true
    rollupOptions: {
      input: {
        main: path.resolve(__dirname, 'index.html'),
        index: path.resolve(__dirname, 'pages/index.html'),
        authorized: path.resolve(__dirname, 'pages/authorized.html'),
        text: path.resolve(__dirname, 'pages/text.html'),
        newsList: path.resolve(__dirname, 'pages/news-list.html'),
        newsCard: path.resolve(__dirname, 'pages/news-card.html'),
        productCard: path.resolve(__dirname, 'pages/product-card.html'),
        signin: path.resolve(__dirname, 'pages/signin.html'),
        signup: path.resolve(__dirname, 'pages/signup.html'),
        categories: path.resolve(__dirname, 'pages/categories.html'),
      },
    },
  },
  server: {
    port: 8080
  },
  plugins: [
    handlebars({
      partialDirectory: path.resolve(__dirname, 'partials'),
    }),
  ],
}
