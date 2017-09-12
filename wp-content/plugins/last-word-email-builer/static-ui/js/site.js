var LASTWORD = LASTWORD || {};

(function ($) {

  LASTWORD.app = {};

  LASTWORD.app.offscreeneditor = function() {
	 
    $('.offscreen').on('click', function(){
      $('#slider').toggleClass('open');
    });
  		
  }

  LASTWORD.app.editor = function() {
    
    $('.editor').summernote();
   
  }

  $(document).ready(function() {

    this.offscreeneditor();
    this.editor();
	
	}.bind(LASTWORD.app));

})(jQuery);