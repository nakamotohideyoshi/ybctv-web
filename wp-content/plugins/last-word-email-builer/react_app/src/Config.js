/*

This class holds some config values. It could be removed soon and have the values moved to App.js.

*/

const Config = {
  BASE_URL: window.location.host.indexOf('localhost') !== -1 ? 'https://lastword.staging.wpengine.com' : (window.location.protocol + "//" + window.location.host),
  VERSION: 2
};

module.exports = Config;
