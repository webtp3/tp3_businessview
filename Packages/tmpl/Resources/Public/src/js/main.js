'use strict';

// to check if main.js is loaded in the browser at all
// console.info('Let the games begin - Hello main.js! :)');

// import some (vendor) libs
import $ from 'jquery';
// import Foundation from 'foundation-sites';


// import / include the class definition
import myGreeter from './modules/Greet.js';

// let's create our own instance and say something
let start = new myGreeter();


/**
 *
 * Let the games begin! This is the very entry point of our app / website js.
 *
 *
 */

// see http://gregfranko.com/jquery-best-practices/#/4 - TODO: maybe try an IIFE (Immediately Invoked Function Expression) approach
$(function () {

	// initialize foundation
	// $(document).foundation();

});


/**
 * Do our class methods and vars work?
 * Let's check the browser console:
 */
console.log(start.sayToConsole('yo!'));
// Expected console output:
// I say: yo!
//     ...and this is another line.

console.log(start.sayHelloToConsole());
// Expected console output:
// Hello World! I'm an ES6 class

console.log('Using jQuery version ' + $.fn.jquery);
