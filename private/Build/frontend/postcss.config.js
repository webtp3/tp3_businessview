/**
 * Created by Jochen Rieger on 29.11.2017.
 *
 * PostCSS loader config for autoprefixing, etc.
 *
 */

// configuration for the plugins used via postcss-loader
module.exports = {

	plugins: {
		// adding the vendor prefixes, such as -moz, -ms, etc.
		autoprefixer: {
			browsers: ['last 3 versions', 'iOS >= 8']
		}
	}

};

// module.exports = {
// 	plugins: {
// 		'postcss-import': {
// 			addModulesDirectories: ['app'],
// 			resolve: function(id, base) {
// 				return glob.sync(path.join(base, id));
// 			}
// 		},
// 		precss: { },
// 		autoprefixer: { browsers: ['last 2 versions', 'iOS >= 8'] }
// 	},
// }
