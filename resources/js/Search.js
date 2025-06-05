export default class Search {

    closeNav() {
        document.getElementById("myNav").style.width = "0%";
    }

    openNav() {
        document.getElementById("myNav").style.width = "100%";
    }

    send() {
        let keyword = document.getElementById('search').value;
        let day = document.getElementById('day').value;
        this.query(keyword, day);
    }

    list() {
        // get persian day
        let today = new Date().toLocaleDateString('fa-IR-u-nu-latn').split('/')[2];
        // let day = document.getElementById('day').value;
        this.query('*', today);
    }

    print(data) {
        let result = document.getElementById('result');
        result.innerHTML = (typeof data.user == 'string')
            ? this.writeNoResponse(data)
            : this.writeResponse(data);
    }


    query(keyword, day) {
        $.post('/sms/reservations/search', {
            _token: document.querySelector('meta[name=csrf-token]').content,
            key: keyword,
            day: day
        })
            .done((data) => {
                this.print(data);
            })
            .fail((error) => {
                console.error('An error occurred:', error);
            });
    }

    writeNoResponse(data) {
        return `<span class="main-color">${data.user} ...</span>`;
    }

    writeResponse(data) {
        let response = '';
        data.user.forEach(user => {
            response +=
                `<span class="main-color" title="${user.email}">
                <a href="mailto:${user.email}">
                    ${user.surname}, ${user.forename} : ${user.location ? user.extension : user.number}
                </a>
            </span>`;
        });
        return response;
    }
}
