$('.hamburger').click(function () {
	if ($('.nav-left').length) {
		if ($('.nav-left').css('display') === 'block') {
			$('.nav-left').css('display', '')
		} else {
			$('.nav-left').css('display', 'block')
		}
	}

    if ($('.nav-right').length) {
		if ($('.nav-right').css('display') === 'block') {
			$('.nav-right').css('display', '')
		} else {
			$('.nav-right').css('display', 'block')
		}
	}
})

$(window).on('resize', function () {
	if ($('.hamburger').is(':visible')) {
		if ($('.nav-left').length) $('.nav-left').css('display', '')
		if ($('.nav-right').length) $('.nav-right').css('display', '')
	}
})

$('[modal]').click(function() {
	$('#' + $(this).attr('modal')).fadeIn()
})

$('.close-modal').click(function () {
    $(this).parents('.modal').fadeOut()
})

$('.modal').on('click', function(e) {
  if (e.target !== this) return
  $('.modal').hide()
});

$(document).on('click', '.close-alert',  function () {
    $(this).parents('.alert').fadeOut(function () { $(this).remove() })
})

$(document).on('click', '.close-callout',  function () {
    $(this).parents('.callout').fadeOut(function () { $(this).remove() })
})
