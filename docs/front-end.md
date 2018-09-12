# Frontend Information

## Technical

- [Tailwind CSS](https://tailwindcss.com/docs/installation/)
- [Laravel Mix](https://laravel.com/docs/5.6/mix)
- [JQuery](http://jquery.com/) v3

## Tailwind

We are using [tailwind css](https://tailwindcss.com/docs) as the CSS
framework for this project.

### Install

[Install doc](https://tailwindcss.com/docs/installation/)

```npm
# Using npm
npm install tailwindcss --save-dev

# Using Yarn
yarn add tailwindcss --dev
```

### Configuration

All Tailwind's CSS configuration is done by the [tailwind.js](crewcalls/blob/master/tailwind.js) file

### Adding CSS

First make sure that tailwind does not contain what you need.

- Add CSS classes to `resources/assets/css/styles.css`
- Compile using laravel mix
    - If pushing please compile a production build of the CSS assets

## Laravel Mix

We will be using Laravel Mix to compile all of the frontend assets

### Install

```npm
npm install
```

### Compiling

```npm
npm run dev

//OR

npm run production
```

If you are working on changes you can also run

```npm
npm run watch
```

This will watch for changes and compile to dev

## JQuery

### Adding JQuery

- Add any JQuery to `resources/assets/js/app.js`
- Run laravel mix

### Added packages

- [Tooltipster](http://iamceege.github.io/tooltipster/#demos)
- [Slick Carousel](http://kenwheeler.github.io/slick/)
