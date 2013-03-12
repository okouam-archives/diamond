// remap jQuery to $
(function($){})(window.jQuery);

$(document).ready(function (){
	 $('.select-box').customSelect();
});

(function($) {
      $(window).load(function(){
      $('#carousel').flexslider({
        animation: "slide",
        controlNav: false,
        animationLoop: false,
        slideshow: false,
        itemWidth: 130,
        itemMargin: 5,
        asNavFor: '#slider'
      });
       
      $('#slider').flexslider({
        animation: "slide",
        controlNav: false,
        animationLoop: false,
        slideshow: false,
        sync: "#carousel"
      });
    });
   })(jQuery);
