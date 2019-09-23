window.addEventListener('DOMContentLoaded', () => {

  let menuContainer = document.querySelector('.menu-container');

  // click / toggle functionality for mobile menu
  let menuToggler = document.querySelector('.menu-container .menu-toggler');
  menuToggler.addEventListener('click', function(e) {
    menuContainer.classList.toggle('open');
  });

  // initialise smooth scroll functionality
  var scroll = new SmoothScroll('a[href*="#"]', {
    speed: 1000,
    speedAsDuration: true,
    easing: 'easeInOutCubic',
    offset: 100
  });

});
