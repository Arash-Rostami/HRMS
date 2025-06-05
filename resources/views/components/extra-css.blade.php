<style>
    :root {
        --main: #718096;
        --bg-main: #1B232E;
        @if((Cookie::get('theme')))
                     --main: {{Cookie::get('theme')}};
        @endif
        @if((Cookie::get('mode')))
                    --bg-main: {{Cookie::get('mode')}};
        @endif
                  --red: #C82348;
        --blue: #1785FF;
        --purple: #673AB7;
        --green: #acf9a7;
        --oak: #c1a26b;
        --teal: #5EA1A1;
        --maroon: #a15e7f;
        --grey: #607D8B;
        --silver: #a9a9a9;
        --orange: #FFA500;
        --bg-dark: #1B232E;
        --bg-light: #e6e6e6;
    }

    .main-color-reverse {
        color: var(--bg-main);
    }

    body {
        background: linear-gradient(135deg, #E0EAFC, #CFDEF3, #ADCBE9, #91AFE3, #7393DC); /* Light blue/gray gradient */
        min-height: 100vh;
        margin: 0;
    }


    @if ( isDarkMode())

    .bg-weekend {
        background-color: var(--bg-main);
    }

    .fr-toolbar, .fr-wrapper, .fr-second-toolbar, .fr-more-toolbar {
        background-color: var(--bg-main) !important;
    }

    div.fr-btn-grp svg, .fr-more-toolbar svg {
        filter: invert(100%) sepia(1%) saturate(7097%) hue-rotate(178deg) brightness(75%) contrast(89%);
    }

    .user-panel, .main-user-accordion-panel {
        background: none;
    }

    .overlay {
        background-color: var(--bg-main);

    }

    .schedule tr:nth-child(odd) {
        background-color: var(--bg-main);
    }

    .dark-mode {
        background-color: #1F2937;
    }

    body {
        background: linear-gradient(90deg, #1A2027, #2D3748, #4A5568, #718096, #A0AEC0, #CBD5E0);
    }

    @endif

     html {
        scroll-behavior: smooth;
    }

    .scrollbar-hide {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }

    .scrollbar-hide::-webkit-scrollbar {
        display: none;
    }

    #navContainer {
        -webkit-overflow-scrolling: touch;
    }

    @media screen and (max-width: 767px) {
        #mainNav::before,
        #mainNav::after {
            content: '';
            position: absolute;
            top: 0;
            bottom: 0;
            width: 1rem;
            z-index: 1;
            pointer-events: none;
        }

        #mainNav::before {
            left: 0;
            background: linear-gradient(to right, rgb(255 255 255 / 1), rgb(255 255 255 / 0));
        }

        #mainNav::after {
            right: 0;
            background: linear-gradient(to left, rgb(255 255 255 / 1), rgb(255 255 255 / 0));
        }


        @if(isDarkMode())

         #mainNav::before {
            background: linear-gradient(to right, rgb(43 49 57 / 1), rgb(43 49 57 / 0));
        }

        #navContainer::before {
            background: linear-gradient(to right, rgb(43 49 57 / 1), rgb(43 49 57 / 0));
        }

        #navContainer::after {
            background: linear-gradient(to left, rgb(43 49 57 / 1), rgb(43 49 57 / 0));
        }

    @endif

    }

    /*to be edited in the css file*/

    .welcome-thumbnails-color,
    .charts-thumbnails-color,
    .files-thumbnails-color,
    .links-thumbnails-color,
    .product-thumbnails-color {
        /* Remove the border */
        border: none !Important;

        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24); /* Subtle shadow */
        transition: all 0.3s cubic-bezier(.25, .8, .25, 1); /* Smooth transition for hover effect */
    }

    .welcome-thumbnails-color:hover,
    .charts-thumbnails-color:hover,
    .files-thumbnails-color:hover,
    .links-thumbnails-color:hover,
    .product-thumbnails-color:hover {
        box-shadow: 0 3px 6px rgba(0, 0, 0, 0.16), 0 3px 6px rgba(0, 0, 0, 0.23); /* More pronounced shadow on hover */
    }
</style>
