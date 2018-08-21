'use strict';

/**
 * Just a basic example class to show that the ES6 transpiling works
 *
 */

// ES6 class definition
export default class Greet {

  constructor() {
    this.whatAmI = `I'm an ES6 class`;
  }

  say(theWords) {

    // ES6 string feature
    alert(`I say: ${theWords}
    ...and this is another line.`);

  }

  sayToConsole(theWords) {

    // ES6 string feature
    return `I say: ${theWords}
    ...and this is another line.`;

  }

  sayHello() {

    alert(`Hello World! ${this.whatAmI}`);

  }

  sayHelloToConsole() {

    return `Hello World! ${this.whatAmI}`;

  }

}
