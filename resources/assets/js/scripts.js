jQuery(document).ready(function ($) {

	//Animate scroll
	$('.btn-skip').click(function () {
		$('html, body').animate({
			scrollTop: $("#content").offset().top - 15
		}, 800);
	})

	//Toggle Mobile Navigation
	$('.btn-nav').on('click', function (e) {
		$('body').toggleClass('nav-open');
		e.preventDefault();
	})

	//Toggle Menu
	$('.has-menu').click(function (e) {
		$(this).toggleClass('is-open');
		e.preventDefault();
	})

	//Testimonial slider
	$('.testimonial-slider').slick({
		dots: true,
		infinite: true,
		speed: 800,
		slidesToShow: 3,
		slidesToScroll: 3,
		swipeToSlide: true,
		responsive: [{
			breakpoint: 560,
			settings: {
				slidesToShow: 1,
				slidesToScroll: 1
			}
		}]
	});

	// Scroll Reveal
	window.sr = ScrollReveal({ 
		reset: false, //inverse animation for testing
		scale: 1,
		easing: 'cubic-bezier(0.6, 0.2, 0.1, 1)',
		mobile: true,
		viewFactor: 0.2,
		distance: '60px',
		duration: 800,
		origin: 'bottom',
		viewOffset: { top: 0, right: 0, bottom: 0, left: 0 }
	});

	// Custom Settings
	sr.reveal('.fade-up', { 		
		delay: 0,
		reset: false	
	});

	sr.reveal('.fade-up-1', { 		
		delay: 200,	
		reset: false
	});

	sr.reveal('.fade-up-2', { 		
		delay: 400,	
		reset: false
	});

	sr.reveal('.fade-up-3', { 		
		delay: 600,	
		reset: false
	});

	$('#removeManager').on('click', function(e){
        e.preventDefault();
		
		let id = $(this).data('id')
		let token = $(this).data('token')

		//Temporary confirmation dialog
		var toDelete = confirm('Are you sure you want to delete this manager?')

		if (toDelete){
			$.ajax({
				type: 'POST',
				url: '/account/manager/remove/'+id,
				data: {
					_token: token
				}
			})
			.done(function(res){
				location.reload()
			})
		}
    })

});

