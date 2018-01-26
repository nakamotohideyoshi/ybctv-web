const Config = {
  BASE_URL: window.location.host.indexOf('localhost') !== -1 ? 'https://lastword.staging.wpengine.com' : (window.location.protocol + "//" + window.location.host),
  VERSION: 2
};

module.exports = Config;
