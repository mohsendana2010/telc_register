function importAll(r) {
    return r.keys().map(r);
}

// const images = importAll(require.context('../myModules', false, /\.(png|jpe?g|svg)$/));
const images = importAll(require.context('../myModules', false, /\.(js)$/));


module.exports = images;