<script>

    (function startTypeWriter() {
        let app = document.getElementById('text-container');
        let head = document.getElementById('text-head').innerHTML;

        let typewriter = new Typewriter(app, {
            delay: 20
        });

        setTimeout(function () {
            typewriter.typeString(head)
                .pauseFor(500)
                .start();
        }, 2000);
    })();


    function openNav() {
        document.getElementById("mySidenav").style.height = "250px";
        document.getElementById("main").style.marginTop = "250px";
    }

    function closeNav() {
        document.getElementById("mySidenav").style.height = "0";
        document.getElementById("main").style.marginTop = "0";
    }

    function fakeLoad() {
        let animate = document.querySelectorAll(".animate");
        animate.forEach(function (element) {
            element.classList.add("run");
        });

        let timer = setTimeout(function () {
            var loader = document.querySelector(".loader");
            loader.remove();

            setTimeout(function () {
                document.getElementById('main').classList.remove('hidden');
            }, 1000);

            window.scrollTo({
                top: 100,
                behavior: "smooth"
            });
        }, 3000);
    }

    document.addEventListener("DOMContentLoaded", function (event) {
        fakeLoad();
    });

    setTimeout(function () {
        let bg = document.getElementById("bg");
        bg.style.display = "block";
        setTimeout(function () {
            bg.style.opacity = "1";
        }, 200);
    }, 2000);


</script>
