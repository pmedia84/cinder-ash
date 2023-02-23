//nav button active states
const navBtn = document.querySelector('.nav-btn');
const navLinks = document.querySelector('.nav-links');

navBtn.addEventListener('click', ()=>{
    const isOpened = navBtn.getAttribute('aria-expanded') ==="true";

    if (isOpened ? closenavLinks() : opennavLinks());
})

function opennavLinks(){
    navBtn.setAttribute('aria-expanded', "true");
    navLinks.setAttribute('data-state', "opened");
}
function closenavLinks(){
    navBtn.setAttribute('aria-expanded', "false");
    navLinks.setAttribute('data-state', "closing");
    navLinks.addEventListener('animationend', ()=> {
        navLinks.setAttribute('data-state', "closed");
        
    }, {once:true})
}
window.onscroll = function() {returntop()};
var returnbtn = document.querySelector(".return");
var sectionone = document.getElementById("section-one");
var position = sectionone.offsetTop;
function returntop(){
    
    if(window.scrollY>= position){
        
        $(".return").addClass("return-active");
    }else{
        $(".return").removeClass("return-active");
    }
}

// When the user clicks on the button, scroll to the top of the document
function scrolltotop() {
    document.body.scrollTop = 0; // For Safari
    document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
  }

// cookie policy
$(window).on('load', function() {
    if (document.cookie.indexOf("accepted_cookies=") < 0) {
      $('.cookie-overlay').fadeIn(400);
    }
    
    $('.accept-cookies').on('click', function() {
      document.cookie = "accepted_cookies=yes;"
      $('.cookie-overlay').fadeOut(400);
    })
  
   
    $('.close-cookies').on('click', function() {
      $('.cookie-overlay').fadeOut(400);
    })
})