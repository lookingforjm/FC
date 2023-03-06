const hamburger = document.querySelector(".hamburger");
hamburger.addEventListener(
    "click", () => {
        document.querySelector("body").classList.toggle("active");
    }
)

// enable bootstrap tooltips
const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))

function classToggle() {
    const navs = document.querySelectorAll('.toggleShow-items')
    
    navs.forEach(nav => nav.classList.toggle('toggleShow'));
  }
  
  document.querySelector('.myBurger')
    .addEventListener('click', classToggle);