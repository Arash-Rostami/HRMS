<div id="leaves">
    @for ($i = 0; $i < 15; $i++)
        <i></i>
    @endfor
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(function() {
            let styles = `
            #leaves {
                position: absolute;
                top: -50px;
                left: 0;
                width: 100%;
                text-align: center;
            }

            #leaves i {
                display: inline-block;
                width: 30px;
                height: 23px;
                background: linear-gradient(to bottom right, orange, yellow);
                transform: skew(20deg) rotate(180deg);
                border-radius: 5% 40% 70%;
                box-shadow: inset 0 0 1px #222;
                border: 1px solid #333;
                z-index: 1;
                opacity: 0.7;
                animation: falling 5s infinite ease-in-out;
                position: relative;
            }

            #leaves i:nth-of-type(2n) {
                animation: falling2 5s infinite ease-in-out;
            }

            #leaves i:nth-of-type(3n) {
                animation: falling3 5s infinite ease-in-out;
            }

            #leaves i:nth-of-type(2n+1) {
                width: 16px;
                height: 11px;
                opacity: 0.5;
            }

            #leaves i:nth-of-type(3n+2) {
                width: 23px;
                height: 17px;
                opacity: 0.3;
            }

            #leaves i::before,
            #leaves i::after {
                content: '';
                position: absolute;
                background: linear-gradient(to right, rgba(0, 0, 0, 0.15), transparent);
                border-radius: 50%;
            }

            #leaves i::after {
                transform: rotate(125deg);
            }

            #leaves i:nth-of-type(n)::before {
                width: 7px;
                height: 5px;
                top: 17px;
                right: 1px;
                transform: rotate(49deg);
                border-radius: 0% 15% 15% 0%;
                border: 1px solid #222;
                border-left: none;
                background: linear-gradient(to right, rgba(0, 100, 0, 1), yellow);
                z-index: 1;
            }

            #leaves i:nth-of-type(n)::after {
                width: 2px;
                height: 17px;
                top: 0;
                left: 12px;
            }

            #leaves i:nth-of-type(2n+1)::before {
                width: 4px;
                height: 3px;
                top: 7px;
                right: 0;
            }

            #leaves i:nth-of-type(2n+1)::after {
                width: 2px;
                height: 6px;
                top: 1px;
                left: 5px;
            }

            #leaves i:nth-of-type(3n+2)::before {
                width: 4px;
                height: 4px;
                top: 12px;
                right: 1px;
            }

            #leaves i:nth-of-type(3n+2)::after {
                width: 2px;
                height: 10px;
                top: 1px;
                left: 8px;
            }

            #leaves i:nth-of-type(2n+2) {
                background: linear-gradient(to bottom right, yellowgreen, #2b5600);
            }

            #leaves i:nth-of-type(4n+1) {
                background: linear-gradient(to bottom right, #999900, #564500);
            }

            #leaves i:nth-of-type(1)  { animation-delay: 1.9s; }
            #leaves i:nth-of-type(2)  { animation-delay: 3.9s; }
            #leaves i:nth-of-type(3)  { animation-delay: 2.3s; }
            #leaves i:nth-of-type(4)  { animation-delay: 4.4s; }
            #leaves i:nth-of-type(5)  { animation-delay: 5s;   }
            #leaves i:nth-of-type(6)  { animation-delay: 3.5s; }
            #leaves i:nth-of-type(7)  { animation-delay: 2.8s; }
            #leaves i:nth-of-type(8)  { animation-delay: 1.5s; }
            #leaves i:nth-of-type(9)  { animation-delay: 3.3s; }
            #leaves i:nth-of-type(10) { animation-delay: 2.5s; }
            #leaves i:nth-of-type(11) { animation-delay: 1.2s; }
            #leaves i:nth-of-type(12) { animation-delay: 4.1s; }
            #leaves i:nth-of-type(13) { animation-delay: 1s;   }
            #leaves i:nth-of-type(14) { animation-delay: 4.7s; }
            #leaves i:nth-of-type(15) { animation-delay: 3s;   }

            @keyframes falling {
                0% {
                    transform: translate3d(300px, 0, 0) rotate(0deg);
                }
                100% {
                    transform: translate3d(-350px, 700px, 0) rotate(90deg);
                    opacity: 0;
                }
            }

            @keyframes falling2 {
                0% {
                    transform: translate3d(0, 0, 0) rotate(90deg);
                }
                100% {
                    transform: translate3d(-400px, 680px, 0) rotate(0deg);
                    opacity: 0;
                }
            }

            @keyframes falling3 {
                0% {
                    transform: translate3d(0, 0, 0) rotate(-20deg);
                }
                100% {
                    transform: translate3d(-230px, 640px, 0) rotate(-70deg);
                    opacity: 0;
                }
            }
            `;

            let styleSheet = document.createElement("style");
            styleSheet.type = "text/css";
            styleSheet.appendChild(document.createTextNode(styles));
            document.head.appendChild(styleSheet);
        }, 2000);
    });
</script>
