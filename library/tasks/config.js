globalConfig = require('../../package.json').config;

/**
 * Notify error-template
 * @type {{title: string, message: string}}
 */
globalConfig.errorMsg = {
  title: 'Error, prkl!!',
  message: '<%= error.message %>'
};

module.exports = globalConfig;
