$(document).ready(function () {
    $(window).on('load scroll', function () {
        var scrolled = $(this).scrollTop();
        $('#title').css({
            'transform': 'translate3d(0, ' + -(scrolled * 0.2) + 'px, 0)', // parallax (20% scroll rate)
            'opacity': 1 - scrolled / 400 // fade out at 400px from top
        });
        $('#hero-vid').css('transform', 'translate3d(0, ' + -(scrolled * 0.25) + 'px, 0)'); // parallax (25% scroll rate)
    });
    
    // video controls
    $('#state').on('click', function () {
        var video = $('#hero-vid').get(0);
        var icons = $('#state > span');
        $('#overlay').toggleClass('fade');
        if (video.paused) {
            video.play();
            icons.removeClass('fa-play').addClass('fa-pause');
        } else {
            video.pause();
            icons.removeClass('fa-pause').addClass('fa-play');
        }
    });
});


$(document).ready(function(){
      $('.parallax').parallax();
    });

//--Para aparecer ícone no toast
const Icon = '<i class="material-icons print">touch_app</i>';
const Message = 'Para +Interação';
const $toast = Icon +Message ;


//Scroll Fire
var options = [ 
{selector: '#vantagens', offset: 350, callback: function(el) { Materialize.toast($toast, 4000); } }, 

];
Materialize.scrollFire(options); 


//Scrollspy

  $(document).ready(function(){
    $('.scrollspy').scrollSpy();
  });


//Collapsible
  $(document).ready(function(){
    $('.collapsible').collapsible();
  });

//mapa
function initMap() {
        var uluru = {lat: -14.7237887, lng: -49.0856465};
        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 12,
          center: uluru
        });
        var marker = new google.maps.Marker({
          position: uluru,
          map: map
        });
      }