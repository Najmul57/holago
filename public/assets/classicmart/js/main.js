// mobile menu 

(() => {

  const openNavMenu = document.querySelector(".open-nav-menu"),
    closeNavMenu = document.querySelector(".close-nav-menu"),
    navMenu = document.querySelector(".nav-menu"),
    menuOverlay = document.querySelector(".menu-overlay"),
    mediaSize = 991;

  openNavMenu.addEventListener("click", toggleNav);
  closeNavMenu.addEventListener("click", toggleNav);
  // close the navMenu by clicking outside
  menuOverlay.addEventListener("click", toggleNav);

  function toggleNav() {
    navMenu.classList.toggle("open");
    menuOverlay.classList.toggle("active");
    document.body.classList.toggle("hidden-scrolling");
  }



  navMenu.addEventListener("click", (event) => {
    if (event.target.hasAttribute("data-toggle") &&
      window.innerWidth <= mediaSize) {
      // prevent default anchor click behavior
      event.preventDefault();
      const menuItemHasChildren = event.target.parentElement;
      // if menuItemHasChildren is already expanded, collapse it
      if (menuItemHasChildren.classList.contains("active")) {
        collapseSubMenu();
      }
      else {
        // collapse existing expanded menuItemHasChildren
        if (navMenu.querySelector(".menu-item-has-children.active")) {
          collapseSubMenu();
        }
        // expand new menuItemHasChildren
        menuItemHasChildren.classList.add("active");
        let subMenu = menuItemHasChildren.querySelector(".sub-menu");
        subMenu.style.maxHeight = subMenu.scrollHeight + "px";
      }
    }
  });
  function collapseSubMenu() {
    navMenu.querySelector(".menu-item-has-children.active .sub-menu")
      .removeAttribute("style");
    navMenu.querySelector(".menu-item-has-children.active")
      .classList.remove("active");
  }
  function resizeFix() {
    // if navMenu is open ,close it
    if (navMenu.classList.contains("open")) {
      toggleNav();
    }
    // if menuItemHasChildren is expanded , collapse it
    if (navMenu.querySelector(".menu-item-has-children.active")) {
      collapseSubMenu();
    }
  }

  window.addEventListener("resize", function () {
    if (this.innerWidth > mediaSize) {
      resizeFix();
    }
  });

})();

// header sticky
$(window).on('scroll', function () {
  var scroll = $(window).scrollTop();
  if (scroll < 245) {
    $(".header-sticky").removeClass("sticky");
  } else {
    $(".header-sticky").addClass("sticky");
  }
});


// // search category toggle

// (() => {
//   const searchHeader = document.getElementById("search__header")
//   searchHeader.addEventListener("click", myFunction)

//   var x = document.getElementById("myDIV")

//   function myFunction() {
//     if (x.style.display === "block") {
//       x.style.display = "none";
//     } else {
//       x.style.display = "block";
//     }
//   }

//   window.addEventListener("click", function (event) {
//     let eventTarget = event.target
//     if (!eventTarget.closest("#search__header") && !eventTarget.closest("#myDIV")) {
//       x.style.display = "none";
//     }
//   })
// })()


// product quantity
$(document).ready(function () {
  const minus = $(".quantity__minus");
  const plus = $(".quantity__plus");

  [...minus].map((minusItem, index) =>{
    const input = document.getElementsByClassName("quantity__input")[index]
    console.log(input)
    minusItem.addEventListener("click", function (e){
      e.preventDefault()
      var value = input.value;
      if (value > 1) {
        value--;
      }
      input.value = value
    })
  })

  console.log([...plus])

  ;[...plus].map((plusItem, index) =>{
    const input = document.getElementsByClassName("quantity__input")[index]
    plusItem.addEventListener("click", function (e){
      e.preventDefault();
      var value = input.value;
      value++;
      input.value = value
    })
  })
});

// quick image slider
$('.quick_image').owlCarousel({
  loop: true,
  margin: 10,
  dots: false,
  items: 1,
  navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
  nav: true,
})

// quick image slider
$('.banner').owlCarousel({
  loop: true,
  margin: 10,
  autoplay: true,
  smartSpeed: 2000,
  autoplayTimeout: 2000,
  smartSpeed: 1000,
  animateOut: 'fadeOut',
  animateIn: 'fadeIn',
  dots: false,
  items: 1,
  navText: ['<i class="fa fa-arrow-left"></i>', '<i class="fa fa-arrow-right"></i>'],
  nav: true,
  responsive: {
    0: {
      items: 1,
      nav: false,
      dots: true,
    },
    600: {
      items: 1,
      nav: true,
      dots: false,
    },
    1000: {
      items: 1,
      nav: true,
    }
  }
})


// tolltip
$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})

// scroll up
$(function () {
  $.scrollUp({
    scrollName: "scrollUp",
    topDistance: "300",
    topSpeed: 300,
    animation: "fade",
    animationInSpeed: 200,
    animationOutSpeed: 200,
    scrollText: '<i class="fa fa-arrow-up"></i>',
    activeOverlay: false,
  });
});

// product details

// select element
const selectElement = {
  productSizeBtn: document.getElementsByClassName("product__size_btn"),
  productSize: document.getElementById("product__size"),
  productQuantity: document.getElementById("product__quantity")
}

// element
let { productSizeBtn: btn, productSize: size, productQuantity: quantity } = selectElement

// quantity childern
// let quantityItem = quantity.children

// array convert
let allSizeBtn = [...btn]

// activce
;[...btn].forEach((sizeItem) =>{
  sizeItem.addEventListener("click", function(event){
    ;[...btn].forEach(nestedSize => {
      nestedSize.classList.remove("active")
    });
    this.classList.add("active")
  })
})

// map looping in alsize btn
allSizeBtn.map((innerBtn, index) => {
  let indexWithQuantity = quantityItem[index]
  innerBtn.addEventListener("click", (event) => {
    size.innerText = event.target.textContent
    let showQuantityList = document.querySelector(".showQuantity")
    if (!indexWithQuantity.classList.contains("showQuantity") && showQuantityList) {
      showQuantityList.classList.remove("showQuantity")
    }
    indexWithQuantity.classList.add("showQuantity")
  })
});


// shop product sort select active
// let index = 1;

// const on = (listener, query, fn) => {
//   document.querySelectorAll(query).forEach(item => {
//     item.addEventListener(listener, el => {
//       fn(el);
//     })
//   })
// }

// on('click', '.selectBtn', item => {
//   const next = item.target.nextElementSibling;
//   next.classList.toggle('toggle');
//   next.style.zIndex = index++;
// });
// on('click', '.option', item => {
//   item.target.parentElement.classList.remove('toggle');

//   const parent = item.target.closest('.select').children[0];
//   parent.setAttribute('data-type', item.target.getAttribute('data-type'));
//   parent.innerText = item.target.innerText;
// })


// varient onclick active

let header__filter = document.getElementsByClassName("header__filter")
let varient = document.getElementsByClassName("varient-remove")

  ;[...header__filter].map((btnItem, i) => {
    let has_children = document.getElementsByClassName("has-children")[i]

    btnItem.addEventListener("click", function () {
      let classItem = document.querySelector(".activeFilter")
      if (!has_children.classList.contains("activeFilter") && classItem) {
        classItem.classList.remove("activeFilter")
      }
      has_children.classList.toggle("activeFilter")
    })
  })

  ;[...varient].map((closBtn, i) => {
    let has_children = document.getElementsByClassName("has-children")[i]
    closBtn.addEventListener("click", function () {
      has_children.classList.remove("activeFilter")
    })
  })
