const Config = {
  BASE_URL: window.location.host.indexOf('localhost') != -1 ? 'https://lastword.staging.wpengine.com' : (window.location.protocol + "//" + window.location.host),
  VERSION: 1
};

console.log(Config.BASE_URL);

module.exports = Config;
