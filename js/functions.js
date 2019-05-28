/***************************************************
 * BY: Randy S. Baker
 * ON: 15-DEC-2018
 * FILE: functions.js
 * NOTE: Global scripts & helpers...
 ***************************************************/

/**************************************
 * Helper scripts...
 **************************************/
const _0x53f5 = [
  "use strict",
  "fadeOut",
  '[data-loader="circle-side"]',
  "slow",
  "delay",
  "#preloader",
  "visible",
  "css",
  "body",
  "scroll",
  "load",
  "scrollTop",
  "sticky",
  "addClass",
  "header",
  "removeClass",
  "click",
  "show",
  "toggleClass",
  ".main-menu",
  "layer-is-visible",
  ".layer",
  "on",
  "a.open_close",
  "show_normal",
  "next",
  "a.show-submenu",
  "show_mega",
  "a.show-submenu-mega",
  "width",
  "active",
  ".cmn-toggle-switch",
  "tooltip",
  ".tooltip-1",
  "icon_set_1_icon-11 icon_set_1_icon-10",
  "i.indicator",
  "find",
  ".panel-heading",
  "prev",
  "target",
  "hidden.bs.collapse shown.bs.collapse",
  ".panel-group",
  "init",
  "iframe",
  "magnificPopup",
  ".video",
  "parallax",
  ".parallax-window",
  "a",
  "image",
  "each",
  ".magnific-gallery",
  "querySelectorAll",
  "length",
  "preventDefault",
  "contains",
  "classList",
  "remove",
  "add",
  "addEventListener",
  "fadeIn",
  "#toTop",
  "animate",
  "body,html",
  "name",
  "attr",
  "val",
  "input[name=",
  "]",
  ".qtyplus",
  ".qtyminus",
  "ul#cat_nav li a.active",
  "ul#cat_nav li a",
  "flipInX",
  "owlCarousel",
  ".carousel_testimonials"
];

$(window).on('load', function() {
  'use strict';
  $('[data-loader="circle-side"]').fadeOut();
  $('#preloader').delay(350).fadeOut('slow');
  $('body').delay(350).css({ overflow:'visible'});
  $(window).scroll();
});

$(window).scroll(function() {
  'use strict';
  if ($(this).scrollTop() > 1)
  {
    $("header").addClass("sticky");
  } else {
    $("header").removeClass("sticky");
  }
});

$("a.open_close").on("click", function() {
  'use strict';
  $(".main-menu").toggleClass("show");
  $(".layer").toggleClass("layer-is-visible");
});

$("a.show-submenu").on("click", function() {
  'use strict';
  $(this).next().toggleClass("show_normal");
});

$("a.show-submenu-mega").on("click", function() {
  'use strict';
  $(this).next().toggleClass("show_mega");
});

if ($(window).width() <= 480)
{
  $("a.open_close").on("click", function() {
    'use strict';
    $(".cmn-toggle-switch").removeClass("active");
  });
}

$(".tooltip-1").tooltip({ html: true });
function toggleChevron(_0x928bx2) {
  'use strict';
  $(_0x928bx2.target)
    .prev(".panel-heading")
    .find("i.indicator")
    .toggleClass("icon_set_1_icon-11 icon_set_1_icon-10");
}

$(".panel-group").on("hidden.bs.collapse shown.bs.collapse", toggleChevron);
new WOW().init();
$(function() {
  'use strict';
  $(".video").magnificPopup({ type: "iframe" });
  $(".parallax-window").parallax({});
  $(".magnific-gallery").each(function() {
    "use strict";
    $(this).magnificPopup({
      delegate: "a",
      type: "image",
      gallery: { enabled: true }
    });
  });
  const _0x928bx3 = document.querySelectorAll(".cmn-toggle-switch");

  for (var _0x928bx4 = _0x928bx3.length - 1; _0x928bx4 >= 0; _0x928bx4--) {
    const _0x928bx5 = _0x928bx3[_0x928bx4];
    _0x928bx6(_0x928bx5);
  }
  
  function _0x928bx6(_0x928bx5) {
    _0x928bx5.addEventListener("click", function(_0x928bx2) {
      _0x928bx2.preventDefault();
      this.classList.contains("active") === true
        ? this.classList.remove("active")
        : this.classList.add("active");
    });
  }

/*
  $(window).scroll(function() {
    if ($(this).scrollTop() != 0) {
      $("#toTop").fadeIn();
    } else {
      $("#toTop").fadeOut();
    }
  });
  $("#toTop").on("click", function() {
    $("body,html").animate({ scrollTop: 0 }, 500);
  });
  */
});

$(".qtyplus").on("click", function(_0x928bx2) {
  _0x928bx2.preventDefault();
  fieldName = $(this).attr("name");
  const _0x928bx7 = parseInt($("input[name=" + fieldName + "]").val(), 10);

  if (!isNaN(_0x928bx7)) {
    $("input[name=" + fieldName + "]").val(_0x928bx7 + 1);
  } else {
    $("input[name=" + fieldName + "]").val(1);
  }
});

$(".qtyminus").on("click", function(_0x928bx2) {
  _0x928bx2.preventDefault();
  fieldName = $(this).attr("name");
  const _0x928bx7 = parseInt($("input[name=" + fieldName + "]").val(), 10);

  if (!isNaN(_0x928bx7) && _0x928bx7 > 0) {
    $("input[name=" + fieldName + "]").val(_0x928bx7 - 1);
  } else {
    $("input[name=" + fieldName + "]").val(0);
  }
});

$("ul#cat_nav li a").on("click", function() {
  'use strict';
  $("ul#cat_nav li a.active").removeClass("active");
  $(this).addClass("active");
});

/*
$('.carousel_testimonialss').owlCarousel({
  items: 1,
  loop: true,
  autoplay: false,
  animateIn: 'flipInX',
  margin: 30,
  stagePadding: 30,
  smartSpeed: 450,
  responsiveClass: true,
  responsive: { 600: { items: 1 }, 1000: { items: 1, nav: false } }
});
*/