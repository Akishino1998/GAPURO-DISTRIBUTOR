(function($){
	"use strict";
	jQuery(document).on("ready", function () {

        // Header Sticky
		$(window).on("scroll", function() {
            if ($(this).scrollTop() > 120){  
                $(".navbar-area").addClass("is-sticky");
            }
            else{
                $(".navbar-area").removeClass("is-sticky");
            }
        });

        // Navbar Menu JS
        $('.navbar .navbar-nav li a').on("click", function(e){
            var anchor = $(this);
            $('html, body').stop().animate({
                scrollTop: $(anchor.attr('href')).offset().top - 65
            }, 1500);
            e.preventDefault();
        });

        // Header Sticky Two
		$(window).on("scroll", function() {
            if ($(this).scrollTop() > 120){  
                $(".navbar-area-two").addClass("is-sticky");
            }
            else{
                $(".navbar-area-two").removeClass("is-sticky");
            }
        });
        
        // Search Popup JS
        $(".close-btn").on("click", function() {
            $('.search-overlay').fadeOut();
            $('.search-btn').show();
            $('.close-btn').removeClass('active');
        });
        $(".search-btn").on("click", function() {
            $(this).hide();
            $('.search-overlay').fadeIn();
            $('.close-btn').addClass('active');
        });
        
        // Mean Menu
		jQuery(".mean-menu").meanmenu({
			meanScreenWidth: "991"
        });

        // Odometer JS
        $(".odometer").appear(function(e) {
			var odo = $(".odometer");
			odo.each(function() {
				var countNumber = $(this).attr("data-count");
				$(this).html(countNumber);
			});
        });

        // Nice Select JS
        $("select").niceSelect();

        // Popup Video
		$(".popup-youtube").magnificPopup({
			disableOn: 320,
			type: 'iframe',
			mainClass: 'mfp-fade',
			removalDelay: 160,
			preloader: false,
			fixedContentPos: false
        });

        // Tabs
        $('.tab ul.tabs').addClass('active').find('> li:eq(0)').addClass('current');
        $('.tab ul.tabs li a').on('click', function (g) {
            var tab = $(this).closest('.tab'), 
            index = $(this).closest('li').index();
            tab.find('ul.tabs > li').removeClass('current');
            $(this).closest('li').addClass('current');
            tab.find('.tab_content').find('div.tabs_item').not('div.tabs_item:eq(' + index + ')').slideUp();
            tab.find('.tab_content').find('div.tabs_item:eq(' + index + ')').slideDown();
            g.preventDefault();
        });

        // Partner-slider
		$('.partner-slider').owlCarousel({
			loop: true,
			nav: false,
			dots: false,
			smartSpeed: 2000,
			margin: 30,
			autoplayHoverPause: true,
            autoplay: true,
			responsive: {
				0: {
					items: 2
				},
				576: {
					items: 3
				},
				768: {
					items: 4
				},
				1200: {
					items: 5
				}
			}
        });

        // Progress Bar JS
        $('.circlechart').circlechart();

        //Service-slides
        $('.productive-area-content').slick({
            dots: true,
            speed: 300,
            arrows: false,
            infinite: true,
            centerMode: true,
            centerPadding: '60px',
            slidesToShow: 4,
            slidesToScroll: 1,
            responsive: [{
                breakpoint: 2300,
                settings: {
                    slidesToShow: 5,
                    centerMode: false,
                    dots: false
                }
            },{ 
                breakpoint: 1750,
                settings: {
                    centerMode: true,
                    centerPadding: '160px',
                    slidesToShow: 3,
                }
            },{
                breakpoint: 1024,
                settings: {
                    centerMode: true,
                    centerPadding: '140px',
                    slidesToShow: 1,
                }
            },{ 
                breakpoint: 650,
                settings: {
                    centerMode: true,
                    centerPadding: '30px',
                    slidesToShow: 1
                }
            },{ 
                breakpoint: 550,
                settings: {
                    centerMode: true,
                    centerPadding: '20px',
                    slidesToShow: 1
                }
            },{
                breakpoint: 450,
                settings: {
                    centerMode: true,
                    centerPadding: '10px',
                    slidesToShow: 1,
                }
            }],
            customPaging : function(slider, i) {
                var title = $(slider.$slides[i]).data('title');
                return '<a class="pager-item"> '+title+' </a>';
            }
        });

        /* $('.productive-area-content').owlCarousel({
			loop: true,
			nav: false,
			dots: true,
            dotsData: true,
			smartSpeed: 2000,
            center: true,
            active: true,
            mergeFit:false,
            margin: 10,
			autoplayHoverPause: true,
            // autoplay: true,
            responsiveClass:true,
            responsive: {
                0: {
					items: 1
				},
				576: {
                    stagePadding:0,
                    margin: 50,
					items: 1.5
				},
				768: {
                    stagePadding:0,
                    margin: 0,
					items: 1.7
				},
				1200: {
					items: 3
				},
                1326: {
					items: 3
				},
                1700:{
                    items: 5
                }
            }
        }); */

        $('.grid-gallery-slider').slick({
            dots: true,
            slidesPerRow: 3,
            rows: 2,
            arrows: true,
            prevArrow: "<span class='slick-prev pull-left'><i class='fa fa-angle-left' aria-hidden='true'></i></span>",
            nextArrow: "<span class='slick-next pull-right'><i class='fa fa-angle-right' aria-hidden='true'></i></span>",
            responsive: [{
                breakpoint: 478,
                settings: {
                    slidesPerRow: 1,
                    rows: 1,
                }
            }]
			/* loop: true,
			nav: true,
            navText: ['<i class="fa fa-angle-left" aria-hidden="true"></i>','<i class="fa fa-angle-right" aria-hidden="true"></i>'],
			dots: true,
            items: 1,
			smartSpeed: 2000,
            margin: 10,
            center: true,
            active: true,
			autoplayHoverPause: true,
            autoplay: false */
        });

        // Testimonial-slides
		$('.saying-slides').owlCarousel({
			loop: true,
			nav: false,
			dots: true,
			smartSpeed: 2000,
            margin: 30,
            // center: true,
            active: true,
			autoplayHoverPause: true,
            autoplay: true,
			responsive: {
				0: {
					items: 1
				},
				576: {
					items: 1
				},
				768: {
					items: 2
				},
				1200: {
					items: 3
				}
			}
        });

        // Freelancer Project Slider
		$('.freelancer-project-slider').owlCarousel({
			loop: true,
			nav: false,
			dots: false,
			smartSpeed: 2000,
            margin: 30,
            center: true,
            active: true,
			autoplayHoverPause: true,
            autoplay: true,
			responsive: {
				0: {
					items: 1
				},
				576: {
					items: 1
				},
				768: {
					items: 2
				},
				1200: {
					items: 2
				}
			}
        });

        // Client Wrap Slider
		$('.client-wrap').owlCarousel({
            items: 1,
			loop: true,
			nav: true,
			dots: false,
			smartSpeed: 2000,
            margin: 30,
            center: true,
            active: true,
			autoplayHoverPause: true,
            autoplay: true,
            navText: [
                "<i class='fa fa-arrow-right'></i>"
            ],
        });

        // Freelancer Client Slider
		$('.freelancer-client-slider').owlCarousel({
			loop: true,
			nav: false,
            dots: true,
            items: 1,
			autoplayHoverPause: true,
            autoplay: true,
        });
        
        // FAQ Accordion
        $('.accordion').find('.accordion-title').on('click', function() {
            // Adds Active Class
            $(this).toggleClass('active');
            // Expand or Collapse This Panel
            $(this).next().slideToggle('fast');
            // Hide The Other Panels
            $('.accordion-content').not($(this).next()).slideUp('fast');
            // Removes Active Class From Other Titles
            $('.accordion-title').not($(this)).removeClass('active');
        });

        // Input Plus & Minus Number JS
        $('.input-counter').each(function() {
            var spinner = jQuery(this),
            input = spinner.find('input[type="text"]'),
            btnUp = spinner.find('.plus-btn'),
            btnDown = spinner.find('.minus-btn'),
            min = input.attr('min'),
            max = input.attr('max');
            
            btnUp.on('click', function() {
                var oldValue = parseFloat(input.val());
                if (oldValue >= max) {
                    var newVal = oldValue;
                } else {
                    var newVal = oldValue + 1;
                }
                spinner.find("input").val(newVal);
                spinner.find("input").trigger("change");
            });
            btnDown.on('click', function() {
                var oldValue = parseFloat(input.val());
                if (oldValue <= min) {
                    var newVal = oldValue;
                } else {
                    var newVal = oldValue - 1;
                }
                spinner.find("input").val(newVal);
                spinner.find("input").trigger("change");
            });
		});
		
		//made by vipul mirajkar thevipulm.appspot.com
		var TxtType = function(el, toRotate, period) {
			this.toRotate = toRotate;
			this.el = el;
			this.loopNum = 0;
			this.period = parseInt(period, 10) || 2000;
			this.txt = '';
			this.tick();
			this.isDeleting = false;
		};
		TxtType.prototype.tick = function() {
			var i = this.loopNum % this.toRotate.length;
			var fullTxt = this.toRotate[i];

			if (this.isDeleting) {
			this.txt = fullTxt.substring(0, this.txt.length - 1);
			} else {
			    this.txt = fullTxt.substring(0, this.txt.length + 1);
			}
			this.el.innerHTML = '<span class="wrap">'+this.txt+'</span>';
			var that = this;
			var delta = 200 - Math.random() * 100;
			if (this.isDeleting) { delta /= 2; }
			if (!this.isDeleting && this.txt === fullTxt) {
                delta = this.period;
                this.isDeleting = true;
			} else if (this.isDeleting && this.txt === '') {
                this.isDeleting = false;
                this.loopNum++;
                delta = 500;
			}
			setTimeout(function() {
			    that.tick();
			}, delta);
		};

		window.onload = function() {
			var elements = document.getElementsByClassName('typewrite');
			for (var i=0; i<elements.length; i++) {
				var toRotate = elements[i].getAttribute('data-type');
				var period = elements[i].getAttribute('data-period');
				if (toRotate) {
				    new TxtType(elements[i], JSON.parse(toRotate), period);
				}
			}
			// INJECT CSS
			var css = document.createElement("style");
			css.type = "text/css";
			css.innerHTML = ".typewrite > .wrap { border-right: 0.08em solid #fff}";
			document.body.appendChild(css);
        };
        
        // Subscribe form
		$(".newsletter-form").validator().on("submit", function (event) {
			if (event.isDefaultPrevented()) {
			// handle the invalid form...
				formErrorSub();
				submitMSGSub(false, "Please enter your email correctly.");
			} else {
				// everything looks good!
				event.preventDefault();
			}
		});
		function callbackFunction (resp) {
			if (resp.result === "success") {
				formSuccessSub();
			}
			else {
				formErrorSub();
			}
		}
		function formSuccessSub(){
			$(".newsletter-form")[0].reset();
			submitMSGSub(true, "Thank you for subscribing!");
			setTimeout(function() {
				$("#validator-newsletter").addClass('hide');
			}, 4000)
		}
		function formErrorSub(){
			$(".newsletter-form").addClass("animated shake");
			setTimeout(function() {
				$(".newsletter-form").removeClass("animated shake");
			}, 1000)
		}
		function submitMSGSub(valid, msg){
			if(valid){
				var msgClasses = "validation-success";
			} else {
				var msgClasses = "validation-danger";
			}
			$("#validator-newsletter").removeClass().addClass(msgClasses).text(msg);
        }
        // AJAX MailChimp
		$(".newsletter-form").ajaxChimp({
			url: "https://envytheme.us20.list-manage.com/subscribe/post?u=60e1ffe2e8a68ce1204cd39a5&amp;id=42d6d188d9", // Your url MailChimp
			callback: callbackFunction
        });

        // Count Time 
        function makeTimer() {
            var endTime = new Date("September 30, 2022 17:00:00 PDT");			
            var endTime = (Date.parse(endTime)) / 1000;
            var now = new Date();
            var now = (Date.parse(now) / 1000);
            var timeLeft = endTime - now;
            var days = Math.floor(timeLeft / 86400); 
            var hours = Math.floor((timeLeft - (days * 86400)) / 3600);
            var minutes = Math.floor((timeLeft - (days * 86400) - (hours * 3600 )) / 60);
            var seconds = Math.floor((timeLeft - (days * 86400) - (hours * 3600) - (minutes * 60)));
            if (hours < "10") { hours = "0" + hours; }
            if (minutes < "10") { minutes = "0" + minutes; }
            if (seconds < "10") { seconds = "0" + seconds; }
            $("#days").html(days + "<span>Days</span>");
            $("#hours").html(hours + "<span>Hours</span>");
            $("#minutes").html(minutes + "<span>Minutes</span>");
            $("#seconds").html(seconds + "<span>Seconds</span>");
        }
        setInterval(function() { makeTimer(); }, 1000);

        // Go to Top
        // Scroll Event
        $(window).on('scroll', function(){
            var scrolled = $(window).scrollTop();
            if (scrolled > 600) $('.go-top').addClass('active');
            if (scrolled < 600) $('.go-top').removeClass('active');
        });  
        // Click Event
        $('.go-top').on("click", function() {
            $("html, body").animate({ scrollTop: "0" },  500);
        });

        // WOW JS
        new WOW().init();
    });

    $(window).scroll(function () {
        var value = $(this).scrollTop();
        if (value > 100) {
            $("#tempatLogo").empty();
            $("#tempatLogoHP").empty();
            $(".meanmenu-reveal").empty();
            $(".meanmenu-reveal span").empty();
            $("#tempatLogo").append(`<img id="logo" src="../../profil/img/gapuro/GPA-WebAsset-02.svg" alt="logo" style="height: 6vmin">`);
            $("#tempatLogoHP").append(`<img id="logo" src="../../profil/img/gapuro/GPA-WebAsset-02.svg" alt="logo" style="height: 6vmin">`);
            $(".div-transparent").css("display", "none")
            $(".meanmenu-reveal").css("color", "#116530");
            $(".meanmenu-reveal span").css("background", "#116530");
            $(".mean-menu li a.active").css("color", "#116530");
        } else {
            $("#tempatLogo").empty();
            $("#tempatLogoHP").empty();
            $(".meanmenu-reveal").empty();
            $(".meanmenu-reveal span").empty();
            $("#tempatLogo").append(`<img id="logo" src="../../profil/img/gapuro/GPA-WebAsset-01.svg" alt="logo" style="height: 6vmin">`);
            $("#tempatLogoHP").append(`<img id="logo" src="../../profil/img/gapuro/GPA-WebAsset-01.svg" alt="logo" style="height: 6vmin">`);
            $(".div-transparent").css("display", "block")
            $(".meanmenu-reveal").css("color", "black");
            $(".meanmenu-reveal span").css("background", "black");
            $(".mean-menu li a.active").css("color", "black");
        }
    });
	
    // Preloader
    jQuery(window).on("load", function() {
        $('.preloader-area').fadeOut();
    });
}(jQuery));












