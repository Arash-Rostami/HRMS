// initiation of translation
function googleTranslateElementInit() {
    new google.translate.TranslateElement({pageLanguage: 'en'},
        "google_translate_element");
}

// change the direction of page for Farsi font
document.getElementsByTagName("html")[0].addEventListener('change', (e) => {
    rearrangePage((e.target.value === 'fa'));
});


//Hide the Google powered by ... logo
setTimeout(function () {
    let google = document.getElementsByClassName('goog-te-gadget')[0];
    google.childNodes[1].textContent = ' ';
    google.childNodes[2].textContent = ' ';
}, 5000)


$(function () {
    const interval = setInterval(function () {
        const googtransCookie = Cookie.getCookie('googtrans');
        if (googtransCookie && googtransCookie.slice(-2) === 'fa') {
            rearrangePage(true);
        }
    }, 10);

    $(window).on('unload', function () {
        clearInterval(interval);
    });

    // google notification
    $('#interestModal').removeClass('invisible');

    $('.closeModal').on('click', function (e) {
        $('#interestModal').addClass('invisible');
        $('html, body').animate({
            scrollTop: $(document).height()
        }, 800);
    });
});

function rearrangePage(condition) {
    let body = $("body :not(#instantMessage)");
    let tabPane = $(".tab-pane");
    let surveySubmit = $(".survey-submit");
    let surveyDays = $(".survey-days");
    let backgrounds = $(".welcome-bg, .schedule-bg, .info-bg, .charts-bg, .files-bg");

    body.css('direction', condition ? 'rtl' : 'ltr');
    tabPane.removeClass('border-l-2').addClass('border-r-2');
    surveySubmit.css({
        'direction': 'ltr',
        'transform': 'scaleX(-1)'
    });
    surveyDays.css('margin', '0.5rem');
    backgrounds.css('background-position', condition ? '-200px' : 'right');
}
