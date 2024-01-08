/*  jQuery Nice Select - v1.0
    https://github.com/hernansartorio/jquery-nice-select
    Made by Hernán Sartorio  */
    !function(e){e.fn.niceSelect=function(t){function s(t){t.after(e("<div></div>").addClass("nice-select").addClass(t.attr("class")||"").addClass(t.attr("disabled")?"disabled":"").attr("tabindex",t.attr("disabled")?null:"0").html('<span class="current"></span><ul class="list"></ul>'));var s=t.next(),n=t.find("option"),i=t.find("option:selected");s.find(".current").html(i.data("display")||i.text()),n.each(function(t){var n=e(this),i=n.data("display");s.find("ul").append(e("<li></li>").attr("data-value",n.val()).attr("data-display",i||null).addClass("option"+(n.is(":selected")?" selected":"")+(n.is(":disabled")?" disabled":"")).html(n.text()))})}if("string"==typeof t)return"update"==t?this.each(function(){var t=e(this),n=e(this).next(".nice-select"),i=n.hasClass("open");n.length&&(n.remove(),s(t),i&&t.next().trigger("click"))}):"destroy"==t?(this.each(function(){var t=e(this),s=e(this).next(".nice-select");s.length&&(s.remove(),t.css("display",""))}),0==e(".nice-select").length&&e(document).off(".nice_select")):console.log('Method "'+t+'" does not exist.'),this;this.hide(),this.each(function(){var t=e(this);t.next().hasClass("nice-select")||s(t)}),e(document).off(".nice_select"),e(document).on("click.nice_select",".nice-select",function(t){var s=e(this);e(".nice-select").not(s).removeClass("open"),s.toggleClass("open"),s.hasClass("open")?(s.find(".option"),s.find(".focus").removeClass("focus"),s.find(".selected").addClass("focus")):s.focus()}),e(document).on("click.nice_select",function(t){0===e(t.target).closest(".nice-select").length&&e(".nice-select").removeClass("open").find(".option")}),e(document).on("click.nice_select",".nice-select .option:not(.disabled)",function(t){var s=e(this),n=s.closest(".nice-select");n.find(".selected").removeClass("selected"),s.addClass("selected");var i=s.data("display")||s.text();n.find(".current").text(i),n.prev("select").val(s.data("value")).trigger("change")}),e(document).on("keydown.nice_select",".nice-select",function(t){var s=e(this),n=e(s.find(".focus")||s.find(".list .option.selected"));if(32==t.keyCode||13==t.keyCode)return s.hasClass("open")?n.trigger("click"):s.trigger("click"),!1;if(40==t.keyCode){if(s.hasClass("open")){var i=n.nextAll(".option:not(.disabled)").first();i.length>0&&(s.find(".focus").removeClass("focus"),i.addClass("focus"))}else s.trigger("click");return!1}if(38==t.keyCode){if(s.hasClass("open")){var l=n.prevAll(".option:not(.disabled)").first();l.length>0&&(s.find(".focus").removeClass("focus"),l.addClass("focus"))}else s.trigger("click");return!1}if(27==t.keyCode)s.hasClass("open")&&s.trigger("click");else if(9==t.keyCode&&s.hasClass("open"))return!1});var n=document.createElement("a").style;return n.cssText="pointer-events:auto","auto"!==n.pointerEvents&&e("html").addClass("no-csspointerevents"),this}}(jQuery);
    $(document).ready(function() {
        /********* On scroll heder Sticky *********/
        $(window).scroll(function() {
            var scroll = $(window).scrollTop();
            if (scroll >= 50) {
                $("header").addClass("head-sticky");
            } else {
                $("header").removeClass("head-sticky");
            }
        });
        /********* Mobile Menu ********/
        $('#menu').on('click',function(e){
            e.preventDefault();
            setTimeout(function(){
                $('body').addClass('no-scroll active-menu');
                $(".mobile-menu-wrapper").toggleClass("active-menu");
                $('.overlay').addClass('menu-overlay');
            }, 50);
        });
        $('body').on('click','.overlay.menu-overlay, .menu-close-icon svg', function(e){
            e.preventDefault();
            $('body').removeClass('no-scroll active-menu');
            $(".mobile-menu-wrapper").removeClass("active-menu");
            $('.overlay').removeClass('menu-overlay');
        });
        /********* Cart Popup ********/
        $('.cart-header').on('click',function(e){
            e.preventDefault();
            setTimeout(function(){
                $('body').addClass('no-scroll cartOpen');
                $('.overlay').addClass('cart-overlay');
            }, 50);
        });
        $('body').on('click','.overlay.cart-overlay, .closecart', function(e){
            e.preventDefault();
            $('.overlay').removeClass('cart-overlay');
            $('body').removeClass('no-scroll cartOpen');
        });
        /********* Mobile Filter Popup ********/
        $('.filter-title').on('click',function(e){
            e.preventDefault();
            setTimeout(function(){
                $('body').addClass('no-scroll filter-open');
                $('.overlay').addClass('active');
            }, 50);
        });
        $('body').on('click','.overlay.active, .close-filter', function(e){
            e.preventDefault();
            $('.overlay').removeClass('active');
            $('body').removeClass('no-scroll filter-open');
        });
        /*********  Header Search Popup  ********/
        $(".search-header a").click(function() {
            $(".search-popup").toggleClass("active");
            $("body").toggleClass("no-scroll");
        });
        $(".close-search").click(function() {
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
        $('.quantity-increment').click(function(){;
            var t = $(this).siblings('.quantity');
            var quantity = parseInt($(t).val());
            $(t).val(quantity + 1);
        });
        $('.quantity-decrement').click(function(){
            var t = $(this).siblings('.quantity');
            var quantity = parseInt($(t).val());
            if(quantity > 1){
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
        $('ul.tabs li').click(function(){
            var $this = $(this);
            var $theTab = $(this).attr('data-tab');
            if($this.hasClass('active')){
              // do nothing
            } else{
              $this.closest('.tabs-wrapper').find('ul.tabs li, .tabs-container .tab-content').removeClass('active');
              $('.tabs-container .tab-content[id="'+$theTab+'"], ul.tabs li[data-tab="'+$theTab+'"]').addClass('active');
            }
            $('.bestseller-slider').slick('refresh');
            $('.bestseller-slider').slick('refresh');
            $('.testimonial-slider').slick('refresh');
        });
        // HOME PAGE SLIDER //

        $(document).ready(function () {
            var $slider = $('.home-banner-slider');
            var $progressBar = $('.progress');
            var $progressBarLabel = $('.slider__label');

            $slider.on('beforeChange', function (event, slick, currentSlide, nextSlide) {
                var calc = ((nextSlide) / (slick.slideCount - 1)) * 100;

                $progressBar
                    .css('background-size', calc + '% 100%')
                    .attr('aria-valuenow', calc);

                $progressBarLabel.text(calc + '% completed');
            });

            $slider.slick({
                slidesToShow: 1,
                slidesToScroll: 1,
                autoplay: false,
            });
        });
        var $slider = $('.home-banner-slider');
        if ($slider.length) {
            var currentSlide;
            var slidesCount;
            var sliderCounter = document.createElement('div');
            sliderCounter.classList.add('slider__counter');

            var updateSliderCounter = function (slick, currentIndex) {
                currentSlide = slick.slickCurrentSlide() + 1;
                slidesCount = slick.slideCount;
                $(sliderCounter).text(currentSlide + '-' + slidesCount)
            };

            $slider.on('init', function (event, slick) {
                $slider.append(sliderCounter);
                updateSliderCounter(slick);
            });

            $slider.on('afterChange', function (event, slick, currentSlide) {
                updateSliderCounter(slick, currentSlide);
            });
        }
        var $status = $('.pagingInfo');
        var $slickElement = $('.slideshow');

        // $slickElement.on('init reInit afterChange', function (event, slick, currentSlide, nextSlide) {
        //     //currentSlide is undefined on init -- set it to 0 in this case (currentSlide is 0 based)
        //     var i = (currentSlide ? currentSlide : 0) + 1;
        //     $status.text(i + '/' + slick.slideCount);
        // });
        $slickElement.slick({
            slide: '.slide-placeholder',
            autoplay: true,
            dots: true
        });


        if($('.partner-slider').length > 0 ){
            $('.partner-slider').slick({
                autoplay: true,
                slidesToShow: 5,
                speed: 1000,
                slidesToScroll: 1,
                centerMode: true,
                centerPadding: 0,
                prevArrow: '<button class="slick-prev slick-arrow"><span class="slickbtn"><svg><use xlink:href="#slickarrow"></use></svg></span></button>',
                nextArrow: '<button class="slick-next slick-arrow"><span class="slickbtn"><svg><use xlink:href="#slickarrow"></use></svg></span></button>',
                dots: false,
                buttons: true,
                responsive: [
                    {
                        breakpoint:992,
                            settings: {
                                slidesToShow:3,
                                slidesToScroll: 2
                            }
                        } ,
                    {
                        breakpoint: 576,
                        settings: {
                        slidesToShow: 2,
                        slidesToScroll: 1
                        }
                    } ,
                    {
                        breakpoint: 421,
                        settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                        }
                    }
                ]
            });
        }

        if($('.bestseller-slider').length > 0 ){
            $('.bestseller-slider').slick({
                autoplay: false,
                slidesToShow: 4,
                speed: 1000,
                slidesToScroll: 4,
                arrows:true,
                prevArrow: '<button class="slick-prev slick-arrow"><span class="slickbtn"><svg><use xlink:href="#slickarrow"></use></svg></span></button>',
                nextArrow: '<button class="slick-next slick-arrow"><span class="slickbtn"><svg><use xlink:href="#slickarrow"></use></svg></span></button>',
                dots: false,
                buttons: false,
                responsive: [
                    {
                    breakpoint:1200,
                        settings: {
                            slidesToShow: 3,
                            slidesToScroll: 1
                        }
                    },
                    {
                    breakpoint:768,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 1
                        }
                    } ,
                    {
                    breakpoint:576,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1
                        }
                    },
                ]
            });
        }

        if($('.reiview-slider').length > 0 ){
            $('.reiview-slider').slick({
                autoplay: false,
                slidesToShow: 2,
                speed: 1000,
                slidesToScroll: 1,
                arrows:false,
                prevArrow: '<button class="slick-prev slick-arrow"><span class="slickbtn"><svg><use xlink:href="#slickarrow"></use></svg></span></button>',
                nextArrow: '<button class="slick-next slick-arrow"><span class="slickbtn"><svg><use xlink:href="#slickarrow"></use></svg></span></button>',
                dots: true,
                buttons: false,
                responsive: [
                    {
                    breakpoint:992,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1
                        }
                    },
                    {
                    breakpoint:768,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 1
                        }
                    } ,
                    {
                    breakpoint:576,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1
                        }
                    },
                ]
            });
        }

        if($('.testimonials-slider').length > 0 ){
            $('.testimonials-slider').slick({
                autoplay: false,
                slidesToShow: 3,
                speed: 1000,
                slidesToScroll: 3,
                arrows:true,
                prevArrow: '<button class="slick-prev slick-arrow"><span class="slickbtn"><svg><use xlink:href="#slickarrow"></use></svg></span></button>',
                nextArrow: '<button class="slick-next slick-arrow"><span class="slickbtn"><svg><use xlink:href="#slickarrow"></use></svg></span></button>',
                dots: false,
                buttons: true,
                responsive: [
                    {
                    breakpoint:992,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 1
                        }
                    },
                    {
                    breakpoint:576,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1
                        }
                    },
                ]
            });
        }

        if($('.bestpro-slider').length > 0 ){
            $('.bestpro-slider').slick({
                autoplay: true,
                slidesToShow: 4,
                speed: 1000,
                slidesToScroll: 3,
                centerMode: true,
                centerPadding: 0,
                prevArrow: '<button class="slick-prev slick-arrow"><span class="slickbtn"><svg><use xlink:href="#slickarrow"></use></svg></span></button>',
                nextArrow: '<button class="slick-next slick-arrow"><span class="slickbtn"><svg><use xlink:href="#slickarrow"></use></svg></span></button>',
                dots: false,
                buttons: true,
                responsive: [
                    {
                    breakpoint:992,
                        settings: {
                            slidesToShow: 3,
                            slidesToScroll: 1
                        }
                    },
                    {
                    breakpoint:768,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 1
                        }
                    } ,
                    {
                    breakpoint:576,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1
                        }
                    },
                ]
            });
        }

        if($('.blog-slider').length > 0 ){
            $('.blog-slider').slick({
                autoplay: false,
                slidesToShow: 4,
                speed: 1000,
                slidesToScroll: 4,
                prevArrow: '<button class="slick-prev slick-arrow"><span class="slickbtn"><svg><use xlink:href="#slickarrow"></use></svg></span></button>',
                nextArrow: '<button class="slick-next slick-arrow"><span class="slickbtn"><svg><use xlink:href="#slickarrow"></use></svg></span></button>',
                dots: false,
                buttons: false,
                responsive: [
                    {
                        breakpoint: 1400,
                        settings: {
                        slidesToShow: 4,
                        slidesToScroll: 1
                        }
                    },
                    {
                        breakpoint: 1200,
                        settings: {
                        slidesToShow: 3,
                        slidesToScroll: 1
                        }
                    },
                    {
                    breakpoint: 992,
                        settings: {
                            slidesToShow: 3,
                            slidesToScroll: 1
                        }
                    },
                    {
                    breakpoint: 768,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 1
                        }
                    },
                    {
                    breakpoint: 576,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 1
                        }
                    },
                    {
                    breakpoint: 575,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1
                        }
                    }
                ]
            });
        }

        if($('.pdp-reiview-slider').length > 0 ){
            $('.pdp-reiview-slider').slick({
                autoplay: false,
                slidesToShow: 4,
                speed: 1000,
                slidesToScroll: 1,
                arrows:true,
                prevArrow: '<button class="slick-prev slick-arrow"><span class="slickbtn"><svg><use xlink:href="#slickarrow"></use></svg></span></button>',
                nextArrow: '<button class="slick-next slick-arrow"><span class="slickbtn"><svg><use xlink:href="#slickarrow"></use></svg></span></button>',
                dots: false,
                buttons: true,
                responsive: [
                    {
                    breakpoint:1200,
                        settings: {
                            slidesToShow: 3,
                            slidesToScroll: 1
                        }
                    },
                    {
                    breakpoint:768,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 1
                        }
                    } ,
                    {
                    breakpoint:576,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1
                        }
                    },
                ]
            });
        }
        // PDP SLIDER //

        $(document).ready(function () {
            $('.pdp-main-slider').slick({
                dots: false,
                infinite: true,
                speed: 500,
                loop: true,
                slidesToShow: 1,
                arrows: false,
                asNavFor: '.pdp-thumb-slider',
            });
            var $slider = $('.pdp-thumb-slider');
            var $progressBar = $('.progress');
            var $progressBarLabel = $('.slider__label');
            $slider.on('beforeChange', function (event, slick, currentSlide, nextSlide) {
                var calc = ((nextSlide) / (slick.slideCount - 1)) * 100;
                // $(calc).css('height','10px')
                if ($slider.length) {
                    var currentSlide;
                    var slidesCount;
                    var sliderCounter = document.createElement('div');
                    sliderCounter.classList.add('slider__label');
                    var updateSliderCounter = function (slick, currentIndex) {
                        currentSlide = slick.slickCurrentSlide() + 1;
                        slidesCount = slick.slideCount;
                        $(sliderCounter).text(currentSlide + '-' + slidesCount)
                    };
                    $slider.on('init', function (event, slick) {
                        $slider.append(sliderCounter);
                        updateSliderCounter(slick);
                    });
                    $slider.on('afterChange', function (event, slick, currentSlide) {
                        updateSliderCounter(slick, currentSlide);
                    });
                }
                $progressBar
                    .css('background-size', calc + '% 100%')
                    .attr('aria-valuenow', calc)
                // .css('height','5px');
                $progressBarLabel.text(calc + '% completed');
            });
            });
            var $status = $('.pagingInfo-pdp');
            var $slickElement = $('.pdp-thumb-slider');

            $slickElement.on('init reInit afterChange', function (event, slick, currentSlide, nextSlide) {
            //currentSlide is undefined on init -- set it to 0 in this case (currentSlide is 0 based)
            var i = (currentSlide ? currentSlide : 0) + 1;
            $status.text(i + '-' + slick.slideCount);
            });

        $slickElement.slick({
            prevArrow: '<button class="slide-arrow slick-prev"><svg viewBox="0 0 10 5"><path d="M2.37755e-08 2.57132C-3.38931e-06 2.7911 0.178166 2.96928 0.397953 2.96928L8.17233 2.9694L7.23718 3.87785C7.07954 4.031 7.07589 4.28295 7.22903 4.44059C7.38218 4.59824 7.63413 4.60189 7.79177 4.44874L9.43039 2.85691C9.50753 2.78197 9.55105 2.679 9.55105 2.57146C9.55105 2.46392 9.50753 2.36095 9.43039 2.28602L7.79177 0.69418C7.63413 0.541034 7.38218 0.544682 7.22903 0.702329C7.07589 0.859976 7.07954 1.11192 7.23718 1.26507L8.1723 2.17349L0.397965 2.17336C0.178179 2.17336 3.46059e-06 2.35153 2.37755e-08 2.57132Z"></path></svg></button>',
            nextArrow: '<button class="slide-arrow slick-next"><svg viewBox="0 0 10 5"><path d="M2.37755e-08 2.57132C-3.38931e-06 2.7911 0.178166 2.96928 0.397953 2.96928L8.17233 2.9694L7.23718 3.87785C7.07954 4.031 7.07589 4.28295 7.22903 4.44059C7.38218 4.59824 7.63413 4.60189 7.79177 4.44874L9.43039 2.85691C9.50753 2.78197 9.55105 2.679 9.55105 2.57146C9.55105 2.46392 9.50753 2.36095 9.43039 2.28602L7.79177 0.69418C7.63413 0.541034 7.38218 0.544682 7.22903 0.702329C7.07589 0.859976 7.07954 1.11192 7.23718 1.26507L8.1723 2.17349L0.397965 2.17336C0.178179 2.17336 3.46059e-06 2.35153 2.37755e-08 2.57132Z"></path></svg></button>',
            dots: false,
            asNavFor: '.pdp-main-slider',
            speed: 500,
            slidesToScroll: 1,
            touchMove: true,
            focusOnSelect: true,
            loop: true,
            arrows: false,
            infinite: true,
            focusOnSelect: true,
            slidesToShow: 3,
            responsive: [{
                    breakpoint: 475,
                    settings: {
                        slidesToShow: 2
                    }
                }
            ]
        });




        //video-play
        $('.play-vid').on('click',function(){
            if($(this).attr('data-click') == 1) {
            $(this).attr('data-click', 0)
            $('#img-vid')[0].pause();
            $(".play-vid").css("opacity", "1");
            } else {
            $(this).attr('data-click', 1)
            $('#img-vid')[0].play();
            $(".play-vid").css("opacity", "1");
            $(".play-vid").css("opacity", "0");
            }
        });
        $('.play-btn').click(function (m) {
            $('body,html').addClass('no-scroll popupopen');
            $('.overlay-popup').addClass('popup-show');
        });
        $('.close-popup').click(function (m) {
            $('body,html').removeClass('no-scroll popupopen');
            $('.overlay-popup').removeClass('popup-show');
        });

          // Slick lightbox
      if ($('.lightbox').length > 0) {
        $('.lightbox').slickLightbox({
          itemSelector: 'a.open-lightbox',
          caption: 'caption',
          prevArrow: '<button class="slide-arrow slick-prev"><svg viewBox="0 0 10 5"><path d="M2.37755e-08 2.57132C-3.38931e-06 2.7911 0.178166 2.96928 0.397953 2.96928L8.17233 2.9694L7.23718 3.87785C7.07954 4.031 7.07589 4.28295 7.22903 4.44059C7.38218 4.59824 7.63413 4.60189 7.79177 4.44874L9.43039 2.85691C9.50753 2.78197 9.55105 2.679 9.55105 2.57146C9.55105 2.46392 9.50753 2.36095 9.43039 2.28602L7.79177 0.69418C7.63413 0.541034 7.38218 0.544682 7.22903 0.702329C7.07589 0.859976 7.07954 1.11192 7.23718 1.26507L8.1723 2.17349L0.397965 2.17336C0.178179 2.17336 3.46059e-06 2.35153 2.37755e-08 2.57132Z"></path></svg></button>',
          nextArrow: '<button class="slide-arrow slick-next"><svg viewBox="0 0 10 5"><path d="M2.37755e-08 2.57132C-3.38931e-06 2.7911 0.178166 2.96928 0.397953 2.96928L8.17233 2.9694L7.23718 3.87785C7.07954 4.031 7.07589 4.28295 7.22903 4.44059C7.38218 4.59824 7.63413 4.60189 7.79177 4.44874L9.43039 2.85691C9.50753 2.78197 9.55105 2.679 9.55105 2.57146C9.55105 2.46392 9.50753 2.36095 9.43039 2.28602L7.79177 0.69418C7.63413 0.541034 7.38218 0.544682 7.22903 0.702329C7.07589 0.859976 7.07954 1.11192 7.23718 1.26507L8.1723 2.17349L0.397965 2.17336C0.178179 2.17336 3.46059e-06 2.35153 2.37755e-08 2.57132Z"></path></svg></button>',
          navigateByKeyboard: true,
          layouts: {
            closeButton: '<button class="close"><svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 50 50" fill="none"><path d="M27.7618 25.0008L49.4275 3.33503C50.1903 2.57224 50.1903 1.33552 49.4275 0.572826C48.6647 -0.189868 47.428 -0.189965 46.6653 0.572826L24.9995 22.2386L3.33381 0.572826C2.57102 -0.189965 1.3343 -0.189965 0.571605 0.572826C-0.191089 1.33562 -0.191186 2.57233 0.571605 3.33503L22.2373 25.0007L0.571605 46.6665C-0.191186 47.4293 -0.191186 48.666 0.571605 49.4287C0.952952 49.81 1.45285 50.0007 1.95275 50.0007C2.45266 50.0007 2.95246 49.81 3.3339 49.4287L24.9995 27.763L46.6652 49.4287C47.0465 49.81 47.5464 50.0007 48.0463 50.0007C48.5462 50.0007 49.046 49.81 49.4275 49.4287C50.1903 48.6659 50.1903 47.4292 49.4275 46.6665L27.7618 25.0008Z" fill="white"></path></svg></button>'
          }
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

    $(window).on('load resize orientationchange', function() {
        /********* Wrapper top space ********/
        var header_hright = $('header').outerHeight();
        $('header').next('.wrapper').css('margin-top', header_hright + 'px');
    });
