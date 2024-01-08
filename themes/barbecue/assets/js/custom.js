/*  jQuery Nice Select - v1.0
    https://github.com/hernansartorio/jquery-nice-select
    Made by Hernán Sartorio  */
!function (e) { e.fn.niceSelect = function (t) { function s(t) { t.after(e("<div></div>").addClass("nice-select").addClass(t.attr("class") || "").addClass(t.attr("disabled") ? "disabled" : "").attr("tabindex", t.attr("disabled") ? null : "0").html('<span class="current"></span><ul class="list"></ul>')); var s = t.next(), n = t.find("option"), i = t.find("option:selected"); s.find(".current").html(i.data("display") || i.text()), n.each(function (t) { var n = e(this), i = n.data("display"); s.find("ul").append(e("<li></li>").attr("data-value", n.val()).attr("data-display", i || null).addClass("option" + (n.is(":selected") ? " selected" : "") + (n.is(":disabled") ? " disabled" : "")).html(n.text())) }) } if ("string" == typeof t) return "update" == t ? this.each(function () { var t = e(this), n = e(this).next(".nice-select"), i = n.hasClass("open"); n.length && (n.remove(), s(t), i && t.next().trigger("click")) }) : "destroy" == t ? (this.each(function () { var t = e(this), s = e(this).next(".nice-select"); s.length && (s.remove(), t.css("display", "")) }), 0 == e(".nice-select").length && e(document).off(".nice_select")) : console.log('Method "' + t + '" does not exist.'), this; this.hide(), this.each(function () { var t = e(this); t.next().hasClass("nice-select") || s(t) }), e(document).off(".nice_select"), e(document).on("click.nice_select", ".nice-select", function (t) { var s = e(this); e(".nice-select").not(s).removeClass("open"), s.toggleClass("open"), s.hasClass("open") ? (s.find(".option"), s.find(".focus").removeClass("focus"), s.find(".selected").addClass("focus")) : s.focus() }), e(document).on("click.nice_select", function (t) { 0 === e(t.target).closest(".nice-select").length && e(".nice-select").removeClass("open").find(".option") }), e(document).on("click.nice_select", ".nice-select .option:not(.disabled)", function (t) { var s = e(this), n = s.closest(".nice-select"); n.find(".selected").removeClass("selected"), s.addClass("selected"); var i = s.data("display") || s.text(); n.find(".current").text(i), n.prev("select").val(s.data("value")).trigger("change") }), e(document).on("keydown.nice_select", ".nice-select", function (t) { var s = e(this), n = e(s.find(".focus") || s.find(".list .option.selected")); if (32 == t.keyCode || 13 == t.keyCode) return s.hasClass("open") ? n.trigger("click") : s.trigger("click"), !1; if (40 == t.keyCode) { if (s.hasClass("open")) { var i = n.nextAll(".option:not(.disabled)").first(); i.length > 0 && (s.find(".focus").removeClass("focus"), i.addClass("focus")) } else s.trigger("click"); return !1 } if (38 == t.keyCode) { if (s.hasClass("open")) { var l = n.prevAll(".option:not(.disabled)").first(); l.length > 0 && (s.find(".focus").removeClass("focus"), l.addClass("focus")) } else s.trigger("click"); return !1 } if (27 == t.keyCode) s.hasClass("open") && s.trigger("click"); else if (9 == t.keyCode && s.hasClass("open")) return !1 }); var n = document.createElement("a").style; return n.cssText = "pointer-events:auto", "auto" !== n.pointerEvents && e("html").addClass("no-csspointerevents"), this } }(jQuery);
$(document).ready(function () {
  /********* On scroll heder Sticky *********/
  $(window).scroll(function () {
    var scroll = $(window).scrollTop();
    if (scroll >= 50) {
      $("header").addClass("head-sticky");
    } else {
      $("header").removeClass("head-sticky");
    }
  });
  /********* Wrapper top space ********/
  var header_hright = $('header').outerHeight();
  $('header').next('.wrapper').css('margin-top', header_hright + 'px');
  /********* Announcebar hide ********/
  $('#announceclose').click(function () {
    $('.announcebar').slideUp();
  });
  /********* Mobile Menu ********/
  $(".mobile-menu-button").on("click", function () {
    $(".mobile-menu-wrapper, body").toggleClass("active-menu");
  });
  $(".menu-close-icon svg").on("click", function () {
    $(".mobile-menu-wrapper, body").toggleClass("active-menu");
  });
  /********* Cart Popup ********/
  $('.cart-header').on('click', function (e) {
    e.preventDefault();
    setTimeout(function () {
      $('body').addClass('no-scroll cartOpen');
      $('.overlay').addClass('cart-overlay');
    }, 50);
  });
  $('body').on('click', '.overlay.cart-overlay, .closecart', function (e) {
    e.preventDefault();
    $('.overlay').removeClass('cart-overlay');
    $('body').removeClass('no-scroll cartOpen');
  });

  /********* Wish Popup ********/
 $('.wish-header').on('click',function(e){
    e.preventDefault();
    setTimeout(function(){
    $('body').addClass('no-scroll wishOpen');
    $('.overlay').addClass('wish-overlay');
    }, 50);
});
$('body').on('click','.overlay.wish-overlay, .closewish', function(e){
    e.preventDefault();
    $('.overlay').removeClass('wish-overlay');
    $('body').removeClass('no-scroll wishOpen');
});

  /********* Mobile Filter Popup ********/
  $('.filter-title').on('click', function (e) {
    e.preventDefault();
    setTimeout(function () {
      $('body').addClass('no-scroll filter-open');
      $('.overlay').addClass('active');
    }, 50);
  });
  $('body').on('click', '.overlay.active, .close-filter', function (e) {
    e.preventDefault();
    $('.overlay').removeClass('active');
    $('body').removeClass('no-scroll filter-open');
  });
  /*********  Header Search Popup  ********/
  $(".search-header a").click(function () {
    $(".search-popup").toggleClass("active");
    $("body").toggleClass("no-scroll");
  });
  $(".close-search").click(function () {
    $(".search-popup").removeClass("active");
    $("body").removeClass("no-scroll");
  });
  /******* Cookie Js *******/
  $('.cookie-close').click(function () {
    $('.cookie').slideUp();
  });
  /******* Subscribe popup Js *******/
  $('.close-sub-btn').click(function () {
    $('.subscribe-popup').slideUp();
    $(".subscribe-overlay").removeClass("open");
});
  /********* qty spinner ********/
  var quantity = 0;
  $('.quantity-increment').click(function () {
    ;
    var t = $(this).siblings('.quantity');
    var quantity = parseInt($(t).val());
    $(t).val(quantity + 1);
  });
  $('.quantity-decrement').click(function () {
    var t = $(this).siblings('.quantity');
    var quantity = parseInt($(t).val());
    if (quantity > 1) {
      $(t).val(quantity - 1);
    }
  });
  /******  Nice Select  ******/
  $('select').niceSelect();
  /*********  Multi-level accordion nav  ********/
  $('.acnav-label').click(function () {
    var label = $(this);
    var parent = label.parent('.has-children');
    var list = label.siblings('.acnav-list');
    if (parent.hasClass('is-open')) {
      list.slideUp('fast');
      parent.removeClass('is-open');
    }
    else {
      list.slideDown('fast');
      parent.addClass('is-open');
    }
  });
  $('.home-right-slider').slick({
    dots: false,
    infinite: true,
    speed: 1000,
    loop: true,
    arrows: true,
    slidesToShow: 2,
    slidesToScroll: 2,
    asNavFor: '.home-left-slider',
    responsive: [
        {
            breakpoint: 991,
            settings: {
              slidesToShow: 3,
              slidesToScroll: 1,
            },
        },
        {
            breakpoint: 768 ,
            settings: {
              slidesToShow: 2,
              slidesToScroll: 1,
            },
        },
        {
            breakpoint: 576,
            settings: {
            slidesToShow: 1,
            slidesToScroll: 1,
        },
      }],
  });
  $('.home-left-slider').slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    arrows: false,
    asNavFor: '.home-right-slider',
    speed: 1000,
    dots: true,
    loop: true,
    infinite: true,
  });
  // logo slider
  $('.client-logo-slider').slick({
    slidesToShow: 5,
    dots: false,
    infinite: true,
    speed: 1000,
    loop: true,
    arrows: true,
    autoplay: true,
    centerMode: true,
    responsive: [
      {
        breakpoint: 991,
        settings: {
          slidesToShow: 3,
          slidesToScroll: 1,
        },
      },
      {
        breakpoint: 574,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1,
        },
      }],
  });
  // testimonials-slider
  $('.testimonials-slider').slick({
    slidesToShow: 2,
    slidesToScroll: 2,
    dots: false,
    infinite: true,
    speed: 1200,
    loop: true,
    arrows: true,
    autoplay: true,
    responsive: [
      {
        breakpoint: 767,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1,
        },
      }],
  });
  // blog-slider-main
  $('.blog-slider-main').slick({
    slidesToShow: 4,
    dots: false,
    infinite: true,
    speed: 1200,
    loop: true,
    arrows: true,
    slidesToScroll: 4,
    responsive: [
      {
        breakpoint: 1025,
        settings: {
          slidesToShow: 3,
        },
      },
      {
        breakpoint: 768,
        settings: {
          slidesToShow: 2,
        },
      },
      {
        breakpoint: 576,
        settings: {
          slidesToShow: 1,
        },
      }
    ],
  });
  // pro-card-slider
  $('.pro-card-slider').slick({
    slidesToShow: 4,
    dots: false,
    infinite: true,
    speed: 1200,
    loop: false,
    arrows: true,
    slidesToScroll: 4,
    responsive: [
      {
        breakpoint: 1024,
        settings: {
          slidesToShow: 3,
        },
      },
      {
        breakpoint: 768,
        settings: {
          slidesToShow: 2,
        },
      },
      {
        breakpoint: 540,
        settings: {
          slidesToShow: 1,
        },
      }
    ],
  });
  // product slider
  $('.product-main-slider').slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    arrows: true,
    dots: false,
    infinite: true,
    speed: 1500,
    loop: true,
    asNavFor: '.product-thumb-slider',
    autoplay: false,
  });
  $('.product-thumb-slider').slick({
    slidesToShow: 4,
    arrows: false,
    asNavFor: '.product-main-slider',
    dots: true,
    speed: 1500,
    slidesToScroll: 1,
    touchMove: true,
    focusOnSelect: true,
    loop: true,
    infinite: true,
  });
  // Tab js
  $('ul.tabs li').click(function () {
    var $this = $(this);
    var $theTab = $(this).attr('data-tab');
    if ($this.hasClass('active')) {
    } else {
      $this.closest('.tabs-wrapper').find('ul.tabs li, .tabs-container .tab-content').removeClass('active');
      $('.tabs-container .tab-content[id="' + $theTab + '"], ul.tabs li[data-tab="' + $theTab + ']').addClass('active');
    }
    $('.product-tab-slider').slick('refresh');
    $('ul.tabs li').removeClass('active');
    $(this).addClass('active');
  });
  if ($('.product-tab-slider').length > 0) {
    $('.product-tab-slider').slick({
      arrows: true,
      dots: false,
      speed: 800,
      slidesToShow: 4,
      slidesToScroll: 4,
      loop: false,
      responsive: [
        {
          breakpoint: 1050,
          settings: {
            slidesToShow: 3,
            slidesToScroll: 3,
          }
        },
        {
          breakpoint: 768,
          settings: {
            slidesToShow: 2,
            slidesToScroll: 1,
          }
        },
        {
          breakpoint: 575,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1,
          }
        }
      ]
    });
  }
  if ($(".my-acc-column").length > 0) {
    jQuery(function ($) {
      var topMenuHeight = $("#daccount-nav").outerHeight();
      $("#account-nav").menuScroll(topMenuHeight);
      $(".account-list li:first-child").addClass("active");
    });
    // COPY THE FOLLOWING FUNCTION INTO ANY SCRIPTS
    jQuery.fn.extend({
      menuScroll: function (offset) {
        // Declare all global variables
        var topMenu = this;
        var topOffset = offset ? offset : 0;
        var menuItems = $(topMenu).find("a");
        var lastId;
        // Save all menu items into scrollItems array
        var scrollItems = $(menuItems).map(function () {
          var item = $($(this).attr("href"));
          if (item.length) {
            return item;
          }
        });
        // When the menu item is clicked, get the #id from the href value, then scroll to the #id element
        $(topMenu).on("click", "a", function (e) {
          var href = $(this).attr("href");
          var offsetTop = href === "#" ? 0 : $(href).offset().top - topOffset;
          function checkWidth() {
            var windowSize = $(window).width();
            if (windowSize <= 767) {
              $('html, body').stop().animate({
                scrollTop: offsetTop - 200
              }, 300);
            }
            else {
              $('html, body').stop().animate({
                scrollTop: offsetTop - 100
              }, 300);
            }
          }
          // Execute on load
          checkWidth();
          // Bind event listener
          $(window).resize(checkWidth);
          e.preventDefault();
        });
        // When page is scrolled
        $(window).scroll(function () {
          function checkWidth() {
            var windowSize = $(window).width();
            if (windowSize <= 767) {
              var nm = $("html").scrollTop();
              var nw = $("body").scrollTop();
              var fromTop = (nm > nw ? nm : nw) + topOffset;
              // When the page pass one #id section, return all passed sections to scrollItems and save them into new array current
              var current = $(scrollItems).map(function () {
                if ($(this).offset().top - 250 <= fromTop)
                  return this;
              });
              // Get the most recent passed section from current array
              current = current[current.length - 1];
              var id = current && current.length ? current[0].id : "";
              if (lastId !== id) {
                lastId = id;
                // Set/remove active class
                $(menuItems)
                  .parent().removeClass("active")
                  .end().filter("[href='#" + id + "']").parent().addClass("active");
              }
            }
            else {
              var nm = $("html").scrollTop();
              var nw = $("body").scrollTop();
              var fromTop = (nm > nw ? nm : nw) + topOffset;
              // When the page pass one #id section, return all passed sections to scrollItems and save them into new array current
              var current = $(scrollItems).map(function () {
                if ($(this).offset().top <= fromTop)
                  return this;
              });
              // Get the most recent passed section from current array
              current = current[current.length - 1];
              var id = current && current.length ? current[0].id : "";
              if (lastId !== id) {
                lastId = id;
                // Set/remove active class
                $(menuItems)
                  .parent().removeClass("active")
                  .end().filter("[href='#" + id + "']").parent().addClass("active");
              }
            }
          }
          // Execute on load
          checkWidth();
          // Bind event listener
          $(window).resize(checkWidth);
        });
      }
    });
  }
});