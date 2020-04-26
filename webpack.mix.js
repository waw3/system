let glob = require('glob');

require('./Modules/webpack.mix.js');

glob.sync('./Modules/*/webpack.mix.js').forEach(config => {
	require(config);
});

glob.sync('./Themes/*/webpack.mix.js').forEach(config => {
	require(config);
});

glob.sync('./Plugins/*/webpack.mix.js').forEach(config => {
	require(config);
});
