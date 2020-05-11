$(document).ready(function(){
$('#manufacturers_logo_slider').slick({
  dots: true,
  accessibility: false,
  rtl: isRtl, 
  lazyLoad: iqit_carousel_load,
  speed: 600,
  autoplay: iqit_carousel_auto,
  autoplaySpeed: 4500,
  slidesToShow: 8,
  slidesToScroll: 8,
  responsive: [
    {
      breakpoint: 1320,
      settings: {
        slidesToShow: 6,
        slidesToScroll: 6,
      }
    },
    {
      breakpoint: 1000,
      settings: {
        slidesToShow: 5,
        slidesToScroll: 5
      }
    },
    {
      breakpoint: 768,
      settings: {
        slidesToShow: 3,
        slidesToScroll: 3
      }
    },
    {
      breakpoint: 480,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 2
      }
    }
  ]
});

});