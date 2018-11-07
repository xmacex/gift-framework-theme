window.addEventListener('DOMContentLoaded', () => {

  // click / toggle functionality for menu
  let menuItems = document.querySelectorAll('.menu > .menu-item-has-children');
  menuItems.forEach(menuItem => {
    menuItem.addEventListener('click', function(e) {
      e.stopPropagation();
      menuItems.forEach(menuItemWithSubmenuToHide => {
        if (menuItem !== menuItemWithSubmenuToHide) {
          menuItemWithSubmenuToHide.classList.remove('active');
        }
      });
      this.classList.toggle('active');
    });
  });

  // close menu if the user clicks outside of it
  let body = document.querySelector('body');
  body.addEventListener('click', function(e) {
    menuItems.forEach(menuItem => menuItem.classList.remove('active'));
  });

});
