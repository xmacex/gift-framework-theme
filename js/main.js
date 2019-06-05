window.addEventListener('DOMContentLoaded', () => {

  let menuContainer = document.querySelector('.menu-container');

  // click / toggle functionality for menu
  let menuItems = document.querySelectorAll('.menu > .menu-item-has-children');
  menuItems.forEach(menuItem => {
    menuItem.addEventListener('click', function(e) {
      if (!menuContainer.classList.contains('open')) {
        e.stopPropagation();
        menuItems.forEach(menuItemWithSubmenuToHide => {
          if (menuItem !== menuItemWithSubmenuToHide) {
            menuItemWithSubmenuToHide.classList.remove('active');
          }
        });
        this.classList.toggle('active');
      }
    });
  });

  // close menu if the user clicks outside of it
  let body = document.querySelector('body');
  body.addEventListener('click', function(e) {
    menuItems.forEach(menuItem => menuItem.classList.remove('active'));
  });

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
