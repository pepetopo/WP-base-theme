const prompt = require('prompt');
const replace = require('replace-in-file');
const path = require('path');
const { snakeCase } = require('lodash');
const { blue } = require('chalk');

Object.assign(prompt, {
  colors: false,
  message: null,
});

// const schema =   {
//   description: 'Enter your password',     // Prompt displayed to the user. If not supplied name will be used.
//   type: 'string',                 // Specify the type of input to expect.
//   pattern: /^\w+$/,                  // Regular expression that input must be valid against.
//   message: 'Password must be letters', // Warning message to display if validation fails.
//   hidden: true,                        // If true, characters entered will either not be output to console or will be outputed using the `replace` string.
//   replace: '*',                        // If `hidden` is set it will replace each hidden character with the specified string.
//   default: 'lamepassword',             // Default value to use if no value is entered.
//   required: true                        // If true, value entered must be non-empty.
//   before: function(value) { return 'v' + value; } // Runs before node-prompt callbacks. It modifies user's input
// }

const schema = {
  properties: {
    packageName: {
      description: blue("Gimme the Project name =>"),
      type: 'string',
      pattern: /^[a-zA-Z0-9_ ]*$/,
      default: 'Digia WP-Base',
      message: 'Error, you must use alpha-numeric (a-z, 0-9) name',
      required: true
    },
    // TODO: Dis =>
    // framework: {
    //   description: blue("Select which CSS-framework to use: \n 1) Bootstrap \n 2) Foundation \n 3) None \n"),
    //   pattern: /^[123]+$/,
    //   default: '1',
    //   message: 'You must select atleast one option',
    //   required: true
    // },
  }
};

prompt.start();

prompt.get(schema, function (err, result) {

  const replaceOptions = {
    files: [
      path.resolve(__dirname, '../**/*.php'),
      path.resolve(__dirname, '../style.css'),
    ],
    from: [/Digia WP-Base/g, /digia_wp_base/g],
    to: [result.packageName, snakeCase(result.packageName)],
  };

  replace(replaceOptions)
    .then(changedFiles => {
      console.log('Added project-information to %s files', changedFiles.length);
    })
    .catch(error => {
      console.error('Dafug, here\'s the error:', error);
    });
});
