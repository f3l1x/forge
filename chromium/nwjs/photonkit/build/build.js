const NwBuilder = require('nw-builder');

// Prepare NW.JS config
const config = {
    files: [
        __dirname + '/../node_modules/**',
        __dirname + '/../src/**',
        __dirname + '/../package.json',
        __dirname + '/../index.html',
    ],
    cacheDir: __dirname + '/../../tmp',
    platforms: ['osx64'],
    //platforms: ['osx64', 'linux64', 'win64'],
    flavor: 'normal',
    zip: false,
    buildDir: __dirname + '/../dist',
};

// Create NWJS builder
const nw = new NwBuilder(config);

//Log stuff you want
nw.on('log', console.log);

// Build returns a promise
console.log('Building NW.js');
nw.build().then(function () {
    console.log('Building done!');
}).catch(function (error) {
    console.log('Building failed!');
    console.error(error);
    process.exit(1);
});
