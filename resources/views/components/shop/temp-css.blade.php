<style>
    body, html {
        height: 100%;
        position: relative;
    }

    .section {
        width: 100%;
        height: 100%;
        position: relative;
    }

    p {
        position: absolute;
        width: 100%;
        text-align: center;
        font: 40px/60px Arial;
        color: #fff;
        height: 60px;
        top: 50%;
        margin-top: -30px;
        text-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
    }

    .intro {
        background: #ccc
    }

    .content {
        background: #9DA2FF
    }

    .loader {
        position: relative;
        display: block;
        margin: 0 auto;
        width: 150px;
        top: 65%;
    }

    .loader .bar {
        display: block;
        background: #bbb;
        height: 10px;
        border-radius: 5px;
        box-shadow: inset 1px 1px 0px #999, 1px 1px 0 #ddd;
        overflow: hidden;
    }

    .loader .bar i {
        display: block;
        background: #9DA2FF;
        height: 10px;
        width: 0px;
        box-shadow: inset 1px 1px 0 #9DA2FF;
        border-radius: 5px;
        transition: width 1s linear;
        transition-delay: 1s;
    }

    .loader .tick {
        display: block;
        position: absolute;
        left: 100%;
        top: 15px;
        margin: -7px 0 0 7px;
        text-align: center;
        font-size: 20px;
        color: #9DA2FF !important; /* Update the color to #9DA2FF and add !important */
        opacity: 0;
        transition: opacity 0.25s, top 0.25s;
        transition-delay: 2s;
    }

    .loader .tick.run {
        color: #9DA2FF !important; /* Update the color to #9DA2FF and add !important */
        opacity: 1; /* Update the opacity to 1 */
        top: 0; /* Update the top value to 0 */
    }


    .bar i.run {
        width: 100%;
    }

    .tick.run {
        top: 0;
        opacity: 1;
    }

    #bg {
        background-color: black;
        opacity: 0;
        transition: opacity 1s ease-in;
    }


    /* The side navigation menu */
    .sidenav {
        width: 100%; /* 100% Full-height */
        height: 0; /* 0 width - change this with JavaScript */
        position: fixed; /* Stay in place */
        z-index: 1; /* Stay on top */
        top: 0;
        left: 0;
        background-color: #3b2d30; /* Black*/
        overflow-y: hidden; /* Disable horizontal scroll */
        /*padding-top: 60px; !* Place content 60px from the top *!*/
        transition: 0.5s; /* 0.5 second transition effect to slide in the sidenav */
        /*display:none;*/
    }

    /* The navigation menu links */
    .sidenav a {
        direction: rtl;
        padding: 32px 32px;
        text-decoration: none;
        font-size: 25px;
        color: #818181;
        display: inline-block;
        transition: 0.3s;
        float: right;
    }

    /* When you mouse over the navigation links, change their color */
    .sidenav a:hover {
        color: #f1f1f1;
    }

    /* Position and style the close button (top right corner) */
    .sidenav .closebtn {
        position: absolute;
        top: 0;
        left: 25px;
        font-size: 36px;
        margin-left: 50px;
    }

    /* Style page content - use this if you want to push the page content to the right when you open the side navigation */
    #main {
        transition: margin-top .5s;
        padding: 20px;
    }

    /* On smaller screens, where height is less than 450px, change the style of the sidenav (less padding and a smaller font size) */
    @media screen and (max-height: 450px) {
        .sidenav {
            padding-top: 15px;
        }

        .sidenav a {
            font-size: 18px;
        }
    }

    @font-face {
        font-family: 'persol-font';
        src: url('../public/fonts/Helvetica.ttf') format('truetype');
        font-weight: normal;
        font-style: normal;
    }

    @font-face {
        font-family: 'persol-farsi-font';
        src: url('../public/fonts/Kalameh-Light.ttf') format('truetype'), url('../../public/fonts/KalamehWeb-Light.woff') format('woff'), url('../../public/fonts/KalamehWeb-Light.woff2') format('woff2');
        font-weight: normal;
        font-style: normal;
    }

    .persol-farsi-font {
        font-family: 'persol-font', 'Nunito', sans-serif;
    }

    .main-btn {
        background-color: #9DA2FF;
        color: #2d3748;

    }

    .extra-btn {
        background-color: #3b2d30;
    }

    .direction-rtl {
        direction: rtl;
    }

    .scale-in-center {
        -webkit-animation: scale-in-center 0.5s cubic-bezier(0.250, 0.460, 0.450, 0.940) 10s both;
        animation: scale-in-center 0.5s cubic-bezier(0.250, 0.460, 0.450, 0.940) 10s both;
    }

    .persol-icon {
        position: absolute;
        opacity: 20%;
        z-index: -1;
        top: 50%;
        left: 50%;
        width: 250px;
        height: 250px;
        margin-top: -125px; /* Half the height */
        margin-left: -125px; /* Half the width */
    }

    @-webkit-keyframes scale-in-center {
        0% {
            -webkit-transform: scale(0);
            transform: scale(0);
            opacity: 1;
        }
        100% {
            -webkit-transform: scale(1);
            transform: scale(1);
            opacity: 1;
        }
    }

    @keyframes scale-in-center {
        0% {
            -webkit-transform: scale(0);
            transform: scale(0);
            opacity: 1;
        }
        100% {
            -webkit-transform: scale(1);
            transform: scale(1);
            opacity: 1;
        }
    }


    .rotate-clock {
        animation: rotation-clock 90s infinite linear;
    }

    .rotate-counter-clock {
        animation: rotation-counter-clock 30s infinite linear;
    }

    .btn-shadow:hover {
        box-shadow: 0 0 30px #9DA2FF;
    }

    .extra-btn-shadow:hover {
        box-shadow: 0 0 30px #3b2d30;
    }


    @keyframes rotation-clock {
        from {
            transform: rotate(0deg);
        }
        to {
            transform: rotate(359deg);
        }
    }

    @keyframes rotation-counter-clock {
        from {
            transform: rotate(0deg);
        }
        to {
            transform: rotate(-359deg);
        }
    }
</style>
