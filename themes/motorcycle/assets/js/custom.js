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
    /********* Mobile Menu ********/
    $('.mobile-menu-button').on('click', function (e) {
        e.preventDefault();
        setTimeout(function () {
            $('body').addClass('no-scroll active-menu');
            $(".mobile-menu-wrapper").toggleClass("active-menu");
            $('.overlay').addClass('menu-overlay');
        }, 50);
    });
    $('body').on('click', '.overlay.menu-overlay, .menu-close-icon svg', function (e) {
        e.preventDefault();
        $('body').removeClass('no-scroll active-menu');
        $(".mobile-menu-wrapper").removeClass("active-menu");
        $('.overlay').removeClass('menu-overlay');
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
    /****  TAB Js ****/
    $('ul.tabs li').click(function () {
        var $this = $(this);
        var $theTab = $(this).attr('data-tab');
        console.log($theTab);
        if ($this.hasClass('active')) {
            // do nothing
        } else {
            $this.closest('.tabs-wrapper').find('ul.tabs li, .tabs-container .tab-content').removeClass('active');
            $('.tabs-container .tab-content[id="' + $theTab + '"], ul.tabs li[data-tab="' + $theTab + '"]').addClass('active');
        }
        $('.product-tab-slider').slick('refresh');
        $('.bestseller-tab-slider').slick('refresh');
    });
    if ($('.bestseller-tab-slider').length > 0) {
        $('.bestseller-tab-slider').slick({
            arrows: true,
            dots: false,
            speed: 800,
            slidesToShow: 3,
            slidesToScroll: 1,
            loop: false,
            responsive: [
                {
                    breakpoint: 991,
                    settings: {
                        slidesToShow: 2,
                    }
                },
                {
                    breakpoint: 576,
                    settings: {
                        slidesToShow: 1,
                    }
                }
            ]
        });
    }
    if ($('.product-tab-slider').length > 0) {
        $('.product-tab-slider').slick({
            rows: 2,
            arrows: true,
            dots: false,
            speed: 800,
            slidesToShow: 3,
            slidesToScroll: 1,
            loop: false,
            responsive: [
                {
                    breakpoint: 991,
                    settings: {
                        slidesToShow: 2,
                    }
                },
                {
                    breakpoint: 576,
                    settings: {
                        slidesToShow: 1,
                    }
                }
            ]
        });
    }
    // HOME BANNER SLIDER JS //
    $('.home-slider').slick({
        infinite: true,
        slidesToShow: 1,
        slidesToScroll: 1,
        speed: 1200,
        fade: true,
        cssEase: 'linear',
        prevArrow: $('.left-arrow'),
        nextArrow: $('.right-arrow'),
        responsive: [
            {
                breakpoint: 991,
                settings: {
                    prevArrow: $('.left-arrow'),
                    nextArrow: $('.right-arrow'),
                }
            }
        ]
    });
    //   bike-slider-main
    $('.bike-slider-main').slick({
        infinite: true,
        slidesToShow: 2,
        slidesToScroll: 2,
        speed: 1200,
        centerMode: true,
        responsive: [
            {
                breakpoint: 992,
                settings: {
                    slidesToShow: 1,
                    centerMode: false,
                    slidesToScroll: 1
                }
            }
        ]
    });
    //   logo-slider-main
    $('.logo-slider-main').slick({
        infinite: true,
        slidesToShow: 7,
        slidesToScroll: 1,
        speed: 1200,
        centerMode: true,
        autoplay:true,
        responsive: [
            {
                breakpoint: 1200,
                settings: {
                    slidesToShow: 5,
                }
            },
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 3,
                }
            },
            {
                breakpoint: 574,
                settings: {
                    slidesToShow: 1,
                }
            }
        ]
    });
    //   testi-main-slider
    $('.testi-main-slider').slick({
        infinite: true,
        slidesToShow: 3,
        slidesToScroll: 1,
        speed: 1200,
        responsive: [
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 2,
                }
            },
            {
                breakpoint: 576,
                settings: {
                    slidesToShow: 1,
                }
            },
        ]
    });
    //   card-tab-main-slider
    $('.card-tab-main-slider').slick({
        infinite: true,
        rows: 2,
        slidesToShow: 2,
        slidesToScroll: 1,
        speed: 1200,
        responsive: [
            {
                breakpoint: 575,
                settings: {
                    rows: 1,
                    slidesToShow: 1,
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 1,
                }
            },
        ]
    });
    //   blog-main-slider
    $('.blog-main-slider').slick({
        infinite: true,
        slidesToShow: 4,
        slidesToScroll: 1,
        speed: 1200,
        responsive: [
            {
                breakpoint: 1200,
                settings: {
                    rows: 1,
                    slidesToShow: 3,
                }
            },
            {
                breakpoint: 991,
                settings: {
                    rows: 1,
                    slidesToShow: 3,
                }
            },
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 2,
                }
            },
            {
                breakpoint: 576,
                settings: {
                    slidesToShow: 1,
                }
            },
        ]
    });
    // product-cat-slider-main
    $('.product-cat-slider-main').slick({
        infinite: true,
        slidesToShow: 4,
        slidesToScroll: 1,
        speed: 1200,
        responsive: [
            {
                breakpoint: 1200,
                settings: {
                    rows: 1,
                    slidesToShow: 3,
                }
            },
            {
                breakpoint: 991,
                settings: {
                    rows: 1,
                    slidesToShow: 3,
                }
            },
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 2,
                }
            },
            {
                breakpoint: 481,
                settings: {
                    slidesToShow: 1,
                }
            },
        ]
    });
    // product slider
    $('.product-main-slider').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: false,
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
        responsive: [
            {
                breakpoint: 576,
                settings: {
                    dots: false,
                    slidesToShow: 3,
                    arrows: true,
                }
            },
        ]
    });
});
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
$(window).on('load resize orientationchange', function () {
    /********* Wrapper top space ********/
    var header_hright = $('header').outerHeight();
    $('header').next('.wrapper').css('margin-top', header_hright + 'px');
});
