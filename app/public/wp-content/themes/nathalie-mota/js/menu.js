document.addEventListener('DOMContentLoaded', function() {
    const burgerIcon = document.querySelector('.burger-icon');
    const mobileMenu = document.querySelector('.mobile-menu');
    const closeIcon = document.querySelector('.close-icon');
  
    burgerIcon.addEventListener('click', function() {
      mobileMenu.classList.add('active');
    });
  
    closeIcon.addEventListener('click', function() {
      mobileMenu.classList.remove('active');
    });
  });
  