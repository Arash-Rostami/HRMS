$('document').ready(function () {
    let optionsLatin = {
        saveInterval: 2500,
        height: 250,
        placeholderText: 'Write your message ...',
        // direction: (Cookie.getCookie('googtrans')) ? 'rtl' : 'ltr',
        direction: 'ltr',
    };

    let optionsPersian = {
        saveInterval: 2500,
        height: 250,
        placeholderText: 'پیامتان را بنویسید ...',
        // direction: (Cookie.getCookie('googtrans')) ? 'ltr' : 'rtl',
        direction:  'rtl',
    };
    let editorLatin = new FroalaEditor('#latin', optionsLatin);
    let editorPersian = new FroalaEditor('#persian', optionsPersian);
});
