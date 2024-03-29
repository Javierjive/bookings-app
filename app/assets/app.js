/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './sass/app.scss';

// start the Stimulus application
import './bootstrap';

require('bootstrap/scss/bootstrap.scss');
window.bootstrap = require('bootstrap/dist/js/bootstrap.bundle.js');

require('../assets/controllers/cardFreeRoomTpl');

require('@fortawesome/fontawesome-free/css/all.min.css');
require('@fortawesome/fontawesome-free/js/all.js');
