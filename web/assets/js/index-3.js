 
 //Script owl Carousel hero area
$(document).ready(function() {

  //calculate the window height & add css properties for height 100%
  wh = $( window ).height();
  ww = $( window ).width();
  $(".hero-carousel-wrapper").css({"height": wh, "width": ww});

  var time = 12; // time in seconds

  var $progressBar,
      $bar,
      $elem,
      isPause,
      tick,
      percentTime;

    //Init the carousel
    $("#owl-1").owlCarousel({
      slideSpeed : 500,
      paginationSpeed : 500,
      singleItem : true,
      afterInit : progressBar,
      afterMove : moved,
      startDragging : pauseOnDragging
    });

    //Init progressBar where elem is $("#owl-1")
    function progressBar(elem){
      $elem = elem;
      //build progress bar elements
      buildProgressBar();
      //start counting
      start();
    }

    //create div#progressBar and div#bar then prepend to $("#owl-1")
    function buildProgressBar(){
      $progressBar = $("<div>",{
        id:"progressBar"
      });
      $bar = $("<div>",{
        id:"bar"
      });
      $progressBar.append($bar).prependTo($elem);
    }
    function start() {
      //reset timer
      percentTime = 0;
      isPause = false;
      //run interval every 0.01 second
      tick = setInterval(interval, 10);
    };
    function interval() {
      if(isPause === false){
        percentTime += 1 / time;
        $bar.css({
           width: percentTime+"%"
         });
        //if percentTime is equal or greater than 100
        if(percentTime >= 100){
          //slide to next item
          $elem.trigger('owl.next')
        }
      }
    }
    //pause while dragging
    function pauseOnDragging(){
      isPause = true;
    }
    //moved callback
    function moved(){
      //clear interval
      clearTimeout(tick);
      //start again
      start();
    }
    //uncomment this to make pause on mouseover
    // $elem.on('mouseover',function(){
    //   isPause = true;
    // })
    // $elem.on('mouseout',function(){
    //   isPause = false;
    // })
});

//Script owl Carousel 2
$(document).ready(function() {
 
  $("#owl-2").owlCarousel({
 
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