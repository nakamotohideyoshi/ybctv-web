;(function() {
    function async_load(script_url){
        var protocol = ('https:' == document.location.protocol ? 'https://' : 'http://');
        var s = document.createElement('script'); s.src = protocol + script_url;
        var x = document.getElementsByTagName('script')[0]; x.parentNode.insertBefore(s, x);
    }
    bm_website_code = 'D38BB14065BA4565';
    jQuery(document).ready(function(){async_load('asset.pagefair.com/measure.min.js')});
    jQuery(document).ready(function(){async_load('asset.pagefair.net/ads.min.js')});
})();
