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
                $('.overlay').addClass('menu-overlay active');
            }, 50);
        });
        $('body').on('click', '.overlay.menu-overlay, .menu-close-icon svg', function (e) {
            e.preventDefault();
            $('body').removeClass('no-scroll active-menu');
            $(".mobile-menu-wrapper").removeClass("active-menu");
            $('.overlay').removeClass('menu-overlay active');
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
        /****  TAB Js ****/
        $('ul.tabs li').click(function () {
            var $this = $(this);
            var $theTab = $(this).attr('data-tab');
            // console.log($theTab);
            if ($this.hasClass('active')) {
                // do nothing
            } else {
                $this.closest('.tabs-wrapper').find('ul.tabs li, .tabs-container .tab-content').removeClass('active');
                $('.tabs-container .tab-content[id="' + $theTab + '"], ul.tabs li[data-tab="' + $theTab + '"]').addClass('active');
            }
            $('.product-tab-slider').slick('refresh');
            $('.cat-product-tab-slider').slick('refresh');
        });
        if ($('.product-tab-slider').length > 0) {
            $('.product-tab-slider').slick({
                arrows: true,
                dots: false,
                infinite: true,
                speed: 800,
                slidesToShow: 3,
                slidesToScroll: 3,
                adaptiveHeight: true,
                responsive: [
                    {
                        breakpoint: 991,
                        settings: {
                            slidesToShow: 2,
                        }
                    },
                    {
                        breakpoint: 480,
                        settings: {
                            slidesToShow: 1,
                        }
                    }
                ]
            });
        }

        // HOME BANNER SLIDER JS //
        var helpers = {
            addZeros: function (n) {
                return (n < 10) ? '0' + n : '' + n;
            }
        };
        var $slider = $('.banner-slider');
        $slider.each(function () {
            var $sliderParent = $(this).parent();
            $(this).slick({
                arrows: false,
                dots: false,
                infinite: true,
                loop: true,
                speed: 800,
                autoplay:true,
                slidesToShow: 1,
                slidesToScroll: 1,
                fade: true,
                cssEase: 'cubic-bezier(0.7, 0, 0.3, 1)',
                touchThreshold: 100,
                asNavFor: '.trending-slider',
            });

            if ($(this).find('.modern-cat-col').length > 1) {
                $(this).siblings('.slides-numbers').show();
            }

            $(this).on('afterChange', function (event, slick, currentSlide) {
                $sliderParent.find('.slides-numbers .active').html(helpers.addZeros(currentSlide + 1));
            });

            var sliderItemsNum = $(this).find('.slick-slide').not('.slick-cloned').length;
            $sliderParent.find('.slides-numbers .total').html(helpers.addZeros(sliderItemsNum));

        });
        if ($('.trending-slider').length > 0) {
            $('.trending-slider').slick({
                autoplay: false,
                slidesToShow: 1,
                speed: 1000,
                slidesToScroll: 1,
                arrows: false,
                dots: true,
                buttons: false,
                infinite: true,
                loop: true,
                asNavFor: '.banner-slider'
            });
        }

        if ($('.client-logo-slider').length > 0) {
            $('.client-logo-slider').slick({
                autoplay: true,
                slidesToShow: 4,
                speed: 1000,
                slidesToScroll: 1,
                arrows: false,
                dots: false,
                buttons: false,
                infinite: true,
                loop: true,
                responsive: [{
                    breakpoint: 1200,
                    settings: {
                        slidesToShow: 4,
                    }
                },
                {
                    breakpoint: 992,
                    settings: {
                        slidesToShow: 3,
                    }
                },
                {
                    breakpoint: 576,
                    settings: {
                        slidesToShow: 2,
                    }
                }
                ]
            });
        }
        // cat-product-tab-slider
        if ($('.cat-product-tab-slider').length > 0) {
            $('.cat-product-tab-slider').slick({
                autoplay: false,
                slidesToShow: 4,
                speed: 1000,
                slidesToScroll: 4,
                arrows: true,
                dots: false,
                infinite: true,
                loop: true,
                responsive: [
                    {
                        breakpoint: 1024,
                        settings: {
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
                        breakpoint: 450,
                        settings: {
                            slidesToShow: 1,
                        }
                    }
                ]
            });
        }
        // shop-products-slider
        if ($('.shop-products-slider').length > 0) {
            $('.shop-products-slider').slick({
                autoplay: false,
                slidesToShow: 4,
                speed: 1000,
                slidesToScroll: 4,
                arrows: true,
                dots: false,
                infinite: true,
                loop: true,
                responsive: [
                    {
                        breakpoint: 1024,
                        settings: {
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
                        breakpoint: 450,
                        settings: {
                            slidesToShow: 1,
                        }
                    }
                ]
            });
        }
        // testi-slider
        if ($('.testi-slider').length > 0) {
            $('.testi-slider').slick({
                autoplay: false,
                slidesToShow: 3,
                speed: 1000,
                slidesToScroll: 3,
                arrows: true,
                dots: false,
                infinite: true,
                loop: true,
                responsive: [
                    {
                        breakpoint: 768,
                        settings: {
                            slidesToShow: 2,
                        }
                    },
                    {
                        breakpoint: 500,
                        settings: {
                            slidesToShow: 1,
                        }
                    }
                ]
            });
        }
        //home blog-slider-main
        if ($('.blog-slider-main').length > 0) {
            $('.blog-slider-main').slick({
                autoplay: false,
                slidesToShow: 3,
                speed: 1000,
                slidesToScroll: 3,
                arrows: true,
                dots: false,
                infinite: true,
                loop: true,
                responsive: [
                    {
                        breakpoint: 992,
                        settings: {
                            slidesToShow: 2,
                        }
                    },
                    {
                        breakpoint: 500,
                        settings: {
                            slidesToShow: 1,
                        }
                    }
                ]
            });
        }
        /** PDP slider **/
        // $('.pdp-main-slider').slick({
        //     dots: false,
        //     infinite: false,
        //     speed: 1000,
        //     loop: true,
        //     slidesToShow: 1,
        //     arrows: false,
        //     asNavFor: '.pdp-thumb-slider',
        // });
        // $('.pdp-thumb-slider').slick({
        //     prevArrow: '<button class="slide-arrow slick-prev"><svg xmlns="http://www.w3.org/2000/svg" width="4" height="6" viewBox="0 0 4 6" fill="none"><path fill-rule="evenodd" clip-rule="evenodd" d="M0.65976 0.662719C0.446746 0.879677 0.446746 1.23143 0.65976 1.44839L2.18316 3L0.65976 4.55161C0.446747 4.76856 0.446747 5.12032 0.65976 5.33728C0.872773 5.55424 1.21814 5.55424 1.43115 5.33728L3.34024 3.39284C3.55325 3.17588 3.55325 2.82412 3.34024 2.60716L1.43115 0.662719C1.21814 0.445761 0.872773 0.445761 0.65976 0.662719Z" fill="white"></path></svg></button>',
        //     nextArrow: '<button class="slide-arrow slick-next"><svg xmlns="http://www.w3.org/2000/svg" width="4" height="6" viewBox="0 0 4 6" fill="none"><path fill-rule="evenodd" clip-rule="evenodd" d="M0.65976 0.662719C0.446746 0.879677 0.446746 1.23143 0.65976 1.44839L2.18316 3L0.65976 4.55161C0.446747 4.76856 0.446747 5.12032 0.65976 5.33728C0.872773 5.55424 1.21814 5.55424 1.43115 5.33728L3.34024 3.39284C3.55325 3.17588 3.55325 2.82412 3.34024 2.60716L1.43115 0.662719C1.21814 0.445761 0.872773 0.445761 0.65976 0.662719Z" fill="white"></path></svg></button>',
        //     dots: false,
        //     asNavFor: '.pdp-main-slider',
        //     speed: 1000,
        //     slidesToScroll: 1,
        //     touchMove: true,
        //     focusOnSelect: true,
        //     loop: true,
        //     // arrows: true,
        //     infinite: true,
        //     focusOnSelect: true,
        //     slidesToShow: 5,
        //     appendArrows:'.pdp-thumb-nav',
        //     responsive: [{
        //         breakpoint: 1100,
        //         settings: {
        //             slidesToShow: 4,
        //         }
        //     }
        //     ]
        // });
        $('.pdp-main-slider').slick({
            dots: false,
            infinite: false,
            speed: 1000,
            loop: true,
            slidesToShow: 1,
            arrows: false,
            asNavFor: '.pdp-thumb-slider',
        });
        $('.pdp-thumb-slider').slick({
            prevArrow: '<button class="slide-arrow slick-prev"><svg xmlns="http://www.w3.org/2000/svg" width="4" height="6" viewBox="0 0 4 6" fill="none"><path fill-rule="evenodd" clip-rule="evenodd" d="M0.65976 0.662719C0.446746 0.879677 0.446746 1.23143 0.65976 1.44839L2.18316 3L0.65976 4.55161C0.446747 4.76856 0.446747 5.12032 0.65976 5.33728C0.872773 5.55424 1.21814 5.55424 1.43115 5.33728L3.34024 3.39284C3.55325 3.17588 3.55325 2.82412 3.34024 2.60716L1.43115 0.662719C1.21814 0.445761 0.872773 0.445761 0.65976 0.662719Z" fill="white"></path></svg></button>',
            nextArrow: '<button class="slide-arrow slick-next"><svg xmlns="http://www.w3.org/2000/svg" width="4" height="6" viewBox="0 0 4 6" fill="none"><path fill-rule="evenodd" clip-rule="evenodd" d="M0.65976 0.662719C0.446746 0.879677 0.446746 1.23143 0.65976 1.44839L2.18316 3L0.65976 4.55161C0.446747 4.76856 0.446747 5.12032 0.65976 5.33728C0.872773 5.55424 1.21814 5.55424 1.43115 5.33728L3.34024 3.39284C3.55325 3.17588 3.55325 2.82412 3.34024 2.60716L1.43115 0.662719C1.21814 0.445761 0.872773 0.445761 0.65976 0.662719Z" fill="white"></path></svg></button>',
            dots: false,
            asNavFor: '.pdp-main-slider',
            speed: 1000,
            slidesToScroll: 1,
            touchMove: true,
            focusOnSelect: true,
            loop: true,
            infinite: false,
            focusOnSelect: true,
            slidesToShow: 3,
            appendArrows:'.pdp-thumb-nav',

        });
        // blog-slider-main
        if ($('.blog-slider-main-blog-page').length > 0) {
            $('.blog-slider-main-blog-page').slick({
                autoplay: false,
                slidesToShow: 4,
                speed: 1000,
                slidesToScroll: 4,
                arrows: true,
                dots: false,
                infinite: true,
                loop: true,
                responsive: [
                    {
                        breakpoint: 991,
                        settings: {
                            slidesToShow: 2,
                        }
                    },
                    {
                        breakpoint: 500,
                        settings: {
                            slidesToShow: 1,
                        }
                    }
                ]
            });
        }
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
