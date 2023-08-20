(function ($) {
	currentSlide = 0;
	$("#mainmenu-phone .closer, #mainmenu-phone .overlay").click(function (e) {
		e.preventDefault();
		$("#navigation-phone").css("filter", "blur(0)");
		$("#mainmenu-phone").fadeOut(700);
	});
	$("#navigation-phone .menu").click(function (e) {
		e.preventDefault();
		$("#navigation-phone").css("filter", "blur(3px)");
		$("#mainmenu-phone").fadeIn(700);
	});
	if ($("#productRange").length) {
		new fullpage("#productRange", {
			anchors: ["product-range", "bmw", "bmw-specs", "audi", "audi-specs", "tesla", "tesla-specs", "ford", "ford-specs", "mercedes", "mercedes-specs", "volkswagen", "volkswagen-specs"],
			controlArrows: false,
			licenseKey: "6AFEDBE1-429D4305-B5E40137-5F4CCD17",
			loopBottom: true,
			loopTop: false,
			navigation: false,
			resetSliders: true,
			scrollHorizontally: true,
			scrollOverflow: true,
			scrollOverflowReset: true,
			touchSensitivity: 20,
			verticalCentered: false,
			scrollOverflowOptions: {
				scrollbars: false,
				shrinkScrollbars: "clip",
			},
			afterLoad: function (section, origin, destination, direction) {
				currentSlide = origin.index;
				$("#sliderNav a").removeClass("active");
				if (currentSlide == 0)
					$("#sliderNav a").eq(0).addClass("active");
				else {
					$("#sliderNav a").eq(Math.ceil(currentSlide / 2)).addClass("active");
				}
				$("#productRange .info").removeClass("on");
			},
		});
	}
	if ($("#ourStory").length) {
		new fullpage("#ourStory", {
			anchors: ["our-story", "company", "about-us", "team", "latest"],
			controlArrows: false,
			licenseKey: "6AFEDBE1-429D4305-B5E40137-5F4CCD17",
			loopBottom: true,
			loopTop: false,
			navigation: false,
			resetSliders: true,
			scrollHorizontally: true,
			scrollOverflow: true,
			scrollOverflowReset: true,
			touchSensitivity: 20,
			verticalCentered: false,
			scrollOverflowOptions: {
				scrollbars: false,
				shrinkScrollbars: "clip",
			},
			afterLoad: function (section, origin, destination, direction) {
				currentSlide = origin.index;
				$("#sliderNav a").removeClass("active");
				if (currentSlide >= 0)
					$("#sliderNav a").eq(currentSlide).addClass("active");
				/* RESET VIDEO BACKGROUND */
				$("#ourStory #slide1 .bg").removeClass("nobg");
				$("#ourStory #slide1 .content .play").removeClass("pause");
				$("#ourStory #slide1 .vid").css("opacity", "0");
				$("#ourStory #slide1 .vid video").get(0).pause();
				$("#ourStory #slide1 .mute svg").hide();
			},
		});
	}
	if ($("#tech").length) {
		new fullpage("#tech", {
			anchors: ["technology", "ride-adjuster", "benefits", "instant-performance", "world-class", "peace-of-mind", "download"],
			controlArrows: false,
			licenseKey: "6AFEDBE1-429D4305-B5E40137-5F4CCD17",
			loopBottom: true,
			loopTop: false,
			navigation: false,
			resetSliders: true,
			scrollHorizontally: true,
			scrollOverflow: true,
			scrollOverflowReset: true,
			touchSensitivity: 20,
			verticalCentered: false,
			scrollOverflowOptions: {
				scrollbars: false,
				shrinkScrollbars: "clip",
			},
			afterLoad: function (section, origin, destination, direction) {
				currentSlide = origin.index;
				$("#sliderNav a").removeClass("active");
				if (currentSlide >= 0)
					$("#sliderNav a").eq(currentSlide).addClass("active");
			},
		});
	}
	if ($("#homePage").length) {
		new fullpage("#homePage", {
			anchors: ["home", "featured-video", "triple-engineered", "products", "revolutionise", "contact", "testimonial"],
			controlArrows: false,
			licenseKey: "6AFEDBE1-429D4305-B5E40137-5F4CCD17",
			loopBottom: true,
			loopTop: false,
			navigation: false,
			resetSliders: true,
			scrollHorizontally: true,
			scrollOverflow: true,
			touchSensitivity: 20,
			verticalCentered: false,
			normalScrollElements: "#homePage #slide6 .content form textarea",
			scrollOverflowOptions: {
				scrollbars: false,
				shrinkScrollbars: "clip",
				scrollTo: "fromTop",
				animate: true,
			},
			afterLoad: function (section, origin, destination, direction) {
				currentSlide = origin.index;
				$("#sliderNav a").removeClass("active");
				if (currentSlide == 0)
					$("#sliderNav a").eq(0).addClass("active");
				else if (currentSlide >= 2)
					$("#sliderNav a").eq(eval(currentSlide - 1)).addClass("active");
				/* RESET VIDEO BACKGROUND */
				$("#homePage #slide5 .bg").removeClass("nobg");
				$("#homePage #slide5 .content .play").removeClass("pause");
				$("#homePage #slide5 .vid").css("opacity", "0");
				$("#homePage #slide5 .vid video").get(0).pause();
				$("#homePage #slide5 .content .mute svg").hide();
			},
		});
	}
	$("#mainmenu #rightmenu .closer, #mainmenu #overlay").click(function (e) {
		e.preventDefault();
		$("#mainmenu #rightmenu").animate({
			right: "-21vw"
		}, 500, function () {
			$("#mainmenu #overlay").fadeOut(500, function () {
				$("#mainmenu").hide();
			});
		});
		fullpage_api.setAllowScrolling(true);
	});
	$("#navigation #menu").click(function (e) {
		e.preventDefault();
		$("#mainmenu").show(function () {
			$("#mainmenu #overlay").fadeIn(500, function () {
				$("#mainmenu #rightmenu").animate({
					right: "0"
				});
			});
		});
		fullpage_api.setAllowScrolling(false);
	});
	$("#homePage #slide5 .content .play").click(function (e) {
		e.preventDefault();
		var $this = $(this);
		$("#homePage #slide5 .bg").addClass("nobg");
		$("#homePage #slide5 .vid").css("opacity", "1");
		$("#homePage #slide5 .content .mute svg").fadeIn(500);
		if ($this.hasClass("pause")) {
			$this.removeClass("pause");
			$("#homePage #slide5 video").get(0).pause();
		} else {
			$this.addClass("pause");
			$("#homePage #slide5 video").get(0).play();
		}
	});
	$("#homePage #slide5 .content .mute svg").click(function (e) {
		e.preventDefault();
		var $this = $(this);
		if ($this.hasClass("muted")) {
			$this.removeClass("muted");
			$("#homePage #slide5 video").prop('muted', false);
		} else {
			$this.addClass("muted");
			$("#homePage #slide5 video").prop('muted', true);
		}
	});
	$("#ourStory #slide1 .content .play").click(function (e) {
		e.preventDefault();
		var $this = $(this);
		$("#ourStory #slide1 .bg").addClass("nobg");
		$("#ourStory #slide1 .vid").css("opacity", "1");
		$("#ourStory #slide1 .mute svg").fadeIn(500);
		if ($this.hasClass("pause")) {
			$this.removeClass("pause");
			$("#ourStory #slide1 video").get(0).pause();
		} else {
			$this.addClass("pause");
			$("#ourStory #slide1 video").get(0).play();
		}
	});
	$("#ourStory #slide1 .mute svg").click(function (e) {
		e.preventDefault();
		var $this = $(this);
		if ($this.hasClass("muted")) {
			$this.removeClass("muted");
			$("#ourStory #slide1 video").prop('muted', false);
		} else {
			$this.addClass("muted");
			$("#ourStory #slide1 video").prop('muted', true);
		}
	});

	/* PERFORMENCE / SUV TAB CHANGE */
	$("#productRange .info .content .btns .btn").click(function (e) {
		e.preventDefault();
		var $this = $(this);
		if (!$this.hasClass("filled")) {
			var type = $this.attr("href");
			console.log("22");
			$("#productRange .info .content .btns .btn").removeClass("filled");
			$this.addClass("filled");
			$("#productRange .info .content .det").hide();
			$("#productRange .info .content ." + type).fadeIn(400);
		}
	});

	/* TESTIMONIAL CAROUSEL */
	var owl = $("#homePage #slide7 .content .owl-carousel");
	owl.owlCarousel({
		loop: true,
		margin: 0,
		dots: 0,
		nav: 0,
		items: true,
	});
	$("#homePage #slide7 .content #arrow .left").click(function () {
		owl.trigger("prev.owl.carousel");
	});
	$("#homePage #slide7 .content #arrow .right").click(function () {
		owl.trigger("next.owl.carousel");
	});

	/* VIDEO POPUP */
	$(".video-opener").click(function (e) {
		e.preventDefault();
		var link = $(this).attr("href");
		$("#videoPopup video source").attr("src", link);
		$("#videoPopup video")[0].load();
		$("#videoPopup").delay(200).fadeIn(700);
	});
	$("#videoPopup .closer, #videoPopup .overlay").click(function (e) {
		e.preventDefault();
		$("#videoPopup").fadeOut(700);
	});

	/* CONTACT FORM CHECKBOX HOVER */
	if ($(window).width() > 992) {
		$("#homePage #slide6 .content form .checkbox label").mouseenter(function () {
			if ($(this).attr("for") == "customer") {
				$("#homePage #slide6 .content .infos .info.customer").fadeIn(400);
			} else {
				$("#homePage #slide6 .content .infos .info.distributer").fadeIn(400);
			}
		});
		$("#homePage #slide6 .content form .checkbox label").mouseleave(function () {
			$("#homePage #slide6 .content .infos .info").stop().fadeOut(400);
		});
	};
})(jQuery);
$(window).on("load", function () {
	$(".section .content").css("opacity", "1");
});

$(document).ready(function () {
	guideMake = "";
	$("#step1 .btn").click(function (e) {
		e.preventDefault();
		$("#step1 .btn").removeClass("active");
		$(this).addClass("active");
		guideMake = $(this).attr("href");
		if ($(window).width() > 992) {
			$("#installGuide .content p.view").show();
			$("#step3").html("");
			$.getJSON('install-guide.json', function (json) {
				$.each(json, function (key) {
					if (key == guideMake) {
						$("#step2").html("");
						$.each(this, function (k, v) {
							$("#step2").append('<a class="btn" data-guide="' + v.guide + '" data-video="' + v.video + '">MSS ' + guideMake + ' ' + k + '</a>');
						});
					}
				});
			});
		} else {
			$.getJSON('install-guide.json', function (json) {
				$.each(json, function (key) {
					if (key == guideMake) {
						$("#step1").slideUp(500);
						$("#stepPhone").html("");
						$.each(this, function (k, v) {
							$("#stepPhone").append('<p>MSS ' + guideMake + ' ' + k + '</p>');
							let guide = v.guide;
							let video = v.video;
							guide = (guide == "") ? "" : '<a class="btn pdf" target="_blank" href="' + guide + '">Download PDF</a>';
							video = (video == "") ? "" : '<a class="btn vid" target="_blank" href="' + video + '">Watch Video</a>';
							$("#stepPhone").append(guide + video);
						});
						$("#stepPhone").slideDown(500);
					}
				});
			});
		}
	});
	$(document).on("click", "#step2 .btn", function (e) {
		e.preventDefault();
		let $this = $(this);
		$("#step2 .btn").removeClass("active");
		$this.addClass("active");
		let guide = $this.attr("data-guide");
		let video = $this.attr("data-video");
		guide = (guide == "undefined") ? "" : '<a class="btn" target="_blank" href="' + guide + '">Download PDF</a>';
		video = (video == "undefined") ? "" : '<a class="btn" target="_blank" href="' + video + '">Watch Video</a>';
		$("#step3").html(guide + video);
	});
});
