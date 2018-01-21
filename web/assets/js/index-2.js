
//navbar offcanvas menu
$(document).ready(function ($) {
  
  // sidebars
  // open and close on link's click
  $('.rightOpen').on('click', function () {
    $('body').toggleClass('right-open');

    if (windowWidth <= mediaPoint2) {
      $('body').removeClass('left-open');
    }
    return false;
  });

  $('.rightClose').on('click', function () {
    $('body').removeClass('right-open');
    return false;
  });

  $('.leftOpen').on('click', function () {
    $('body').toggleClass('left-open');

    if (windowWidth <= mediaPoint2) {
      $('body').removeClass('right-open');
    }
    return false;
  });

  $('.leftClose').on('click', function () {
    $('body').removeClass('left-open');
    return false;
  });

  // close when mouse outside

  $('.rightSidebar').hover(function () {
    mouseInAside = true;
  }, function () {
    mouseInAside = false;
  });

  $('.leftSidebar').hover(function () {
    mouseInAside = true;
  }, function () {
    mouseInAside = false;
  });

  $('.rightOpen').hover(function () {
    mouseInAside = true;
  }, function () {
    mouseInAside = false;
  });

  $('.leftOpen').hover(function () {
    mouseInAside = true;
  }, function () {
    mouseInAside = false;
  });

  $('body').on('click', function () {
    if (!mouseInAside) {
      $('body').removeClass('right-open left-open');
    }
  });
});





//Script offcanvas height
$(document).ready(function() {

  //calculate the window height & add css properties for height 100%
  wh = $( window ).height();
  ww = $( window ).width();
  $(".rightSidebar").css({"height": wh});

});



//Script Owl Carousel

$(document).ready(function() {
 
  $("#owl-offer-slider").owlCarousel({
 
      navigation : true, // Show next and prev buttons
      slideSpeed : 300,
      paginationSpeed : 400,
      singleItem:true
 
      // "singleItem:true" is a shortcut for:
      // items : 1,
      // itemsDesktop : false,
      // itemsDesktopSmall : false,
      // itemsTablet: false,
      // itemsMobile : false
 
  });
 
});


//Script Owl Carousel 2
$(document).ready(function() {
 
  $("#owl-trending-products").owlCarousel({
 
      autoPlay: 3000, //Set AutoPlay to 3 seconds
 
      items : 4,
      itemsDesktop : [1199,3],
      itemsDesktopSmall : [979,3]
 
  });
 
});