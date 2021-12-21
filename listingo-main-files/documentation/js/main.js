/*--------------------------------------
		CUSTOM FUNCTION WRITE HERE		
--------------------------------------*/
"use strict";
jQuery(function() {
	/* -------------------------------------
			PRELOADER
	-------------------------------------- */
	jQuery(document).ready(function($){	   
	    jQuery(".preloader-outer").delay(1000).fadeOut();
		jQuery(".loader").delay(500).fadeOut("slow");		
	});
	/*--------------------------------------
			MOBILE MENU						
	--------------------------------------*/
	function collapseMenu(){
		jQuery('.jf-dashboardnav ul li.menu-item-has-children, .jf-dashboardnav ul li.page_item_has_children').prepend('<span class="jf-dropdowarrow"><i class="fa fa-angle-down"></i></span>');
		
		jQuery('.jf-dashboardnav > ul > li.menu-item-has-children a, .jf-dashboardnav > ul > li.page_item_has_children a').on('click', function() {
			jQuery(this).toggleClass('jf-open');
			jQuery(this).next('.sub-menu').slideToggle(300);
			console.log('data');
		});
	}
	collapseMenu();
	/*--------------------------------------
			DASHBOARD MENU					
	--------------------------------------*/
	if(jQuery('#jf-btnmenutoggle').length > 0){
		jQuery("#jf-btnmenutoggle").on('click', function(event) {
			event.preventDefault();
			jQuery('#jf-wrapper').toggleClass('jf-openmenu');
			jQuery('body').toggleClass('jf-noscroll');
			jQuery('.jf-dashboardnav ul.sub-menu').hide();
		});
	}
	/* -------------------------------------
			OPEN CLOSE
	-------------------------------------- */
	jQuery('#jf-languagesbutton').on('click', function(event){
		event.preventDefault();
		jQuery('.jf-langnotification li ul').slideToggle();
	});
	/*--------------------------------------
			Add And Remove Class			
	--------------------------------------*/
	jQuery(document).ready(function() {
		$('#jf-dashboardnav > ul > li').click(function(e) {
		    $('#jf-dashboardnav ul li.active').removeClass('active');
		    var $this = $(this);
		    if (!$this.hasClass('active')) {
		        $this.addClass('active');
		    }
		    e.preventDefault();
		});
	});
	/*--------------------------------------
			THEME VERTICAL SCROLLBAR		
	--------------------------------------*/
	if(jQuery('.jf-verticalscrollbar').length > 0){
		var _jf_verticalscrollbar = jQuery('.jf-verticalscrollbar');
		_jf_verticalscrollbar.mCustomScrollbar({
			axis:"y",
		});
	}
	if(jQuery('.jf-horizontalthemescrollbar').length > 0){
		var _jf_horizontalthemescrollbar = jQuery('.jf-horizontalthemescrollbar');
		_jf_horizontalthemescrollbar.mCustomScrollbar({
			axis:"x",
			advanced:{autoExpandHorizontalScroll:true},
		});
	}
	/*--------------------------------------
			Scrol Code			
	--------------------------------------*/
	$('a[href*="#"]')
  .not('[href="#"]')
  .not('[href="#0"]')
  .click(function(event) {
    if (
      location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') 
      && 
      location.hostname == this.hostname
    ) {
      var target = $(this.hash);
      target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
      if (target.length) {
        event.preventDefault();
        $('html, body').animate({
          scrollTop: target.offset().top
        }, 1000, function() {
          var $target = $(target);
          $target.focus();
          if ($target.is(":focus")) {
            return false;
          } else {
            $target.attr('tabindex','-1');
            $target.focus();
          };
        });
      }
    }
  });
});
	/*--------------------------------------
			MAGNIFIC POPUP GALLERY			
	--------------------------------------*/
	if(jQuery('#jf-tabgalleryimgs').length > 0){
		jQuery('#jf-tabgalleryimgs').magnificPopup({
			gallery: {
				enabled: true,
			},
			mainClass: 'mfp-with-zoom', // this class is for CSS animation below
			zoom: {
				enabled: true, // By default it's false, so don't forget to enable it
				duration: 300, // duration of the effect, in milliseconds
				easing: 'ease-in-out', // CSS transition easing function
				opener: function(openerElement) {
					return openerElement.is('img') ? openerElement : openerElement.find('img');
				}
			},
			delegate:'a',
			type:'image',
			midClick: true,
			removalDelay: 300,
			mainClass: 'mfp-fade',
		});
	}
	


