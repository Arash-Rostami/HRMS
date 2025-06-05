{{--Flower Effect--}}
<svg class="root" title="click to hide the effect">
    <defs>
        <filter id="f" width="200" height="200" x="-100" y="-100">
            <feGaussianBlur in="SourceAlpha" stdDeviation="3" result="blur"></feGaussianBlur>
            <feFlood flood-color="rgb(60,10,60)" result="color"/>
            <feComposite in="color" in2="blur" operator="in" result="shadow"/>
            <feOffset in="shadow" dx="3" dy="3" result="offset"></feOffset>
            <feMerge>
                <feMergeNode in="offset"/>
                <feMergeNode in="SourceGraphic"/>
            </feMerge>
        </filter>
        <symbol id="petal2" viewBox="0 -100 200 200">
            <!--<polygon points="0,0 120,80 200,0 120,-80 0,0" />-->
            <path transform="translate(0,-100)"
                  d="M25.91,-15.12 Q0,0 25.91,15.12L94.09,54.889 Q120,70 142.58,50.24L177.42,19.76 Q200,0 177.42,-19.756L142.58,-50.24 Q120,-70 94.087,-54.88Z"></path>
        </symbol>

        <symbol id="petal3" viewBox="0 -100 200 200">
            <!--<polygon points="0,0 120,50 200,0 120,-50 0,0" />-->
            <path transform="translate(0,-100)"
                  d="M27.69,-11.54  Q0,0 27.69,11.54  L92.3,38.46  Q120,50 145.44,34.1 L174.56,15.9  Q200,0 174.56,-15.9 L145.44,-34.1 Q120,-50 92.3,-38.46Z"></path>
        </symbol>

        <symbol id="petal4" viewBox="0 -100 200 200">
            <!--<polygon points="0,0 120,50 200,0 120,-50 0,0" />-->
            <path transform="translate(0,-100)"
                  d="M28.09,-10.53 Q0,0 28.09,10.53L91.91,34.47 Q120,45 146.147,30.29L173.85,14.7 Q200,0 173.85,-14.7L146.15,-30.29 Q120,-45 91.91,-34.467Z"></path>
        </symbol>
        <symbol id="petal5" viewBox="0 -100 200 200">
            <!--<polygon points="0,0 140,40 200,0 140,-40 0,0" />-->
            <path transform="translate(0,-100)"
                  d="M28.85,-8.24 Q0,0 28.85,8.24L111.15,31.76 Q140,40 164.96,23.36L175.04,16.64 Q200,0 175.038,-16.64L164.96,-23.36 Q140,-40 111.15,-31.76Z"></path>
        </symbol>
    </defs>
</svg>
<svg viewBox="0 0 10000 10000" id="svg" preserveAspectRatio="xMidYMid slice">
</svg>

{{--Butterfly Effect--}}
<div id="butterfly_wrapper" title="click to hide the effect">
    <div class="leftwings">
        <div class="perspective">
            <div class="upperwing upperwing_left"></div>
        </div>
        <div class="perspective">
            <div class="lowerwing lowerwing_left"></div>
        </div>
    </div>
    <div class="rightwings">
        <div class="perspective">
            <div class="upperwing upperwing_right"></div>
        </div>
        <div class="perspective">
            <div class="lowerwing lowerwing_right"></div>
        </div>
    </div>
</div>

<script>
    // Flower effect
    class Flower {
        constructor(n, pos, scale, parent, color) {
            this.n = n;
            this.scale = scale;
            this.pos = pos;
            this.width = 40;
            this.height = 40;
            this.color = color;
            this.parent = parent;
            this.SVG_NS = "http://www.w3.org/2000/svg";
            this.SVG_XLINK = "http://www.w3.org/1999/xlink";
            this.G = document.createElementNS(this.SVG_NS, "g");

            this.createMarkup();
        }

        createMarkup() {
            this.G.setAttribute("style", `--scale:${this.scale};`);
            this.G.setAttributeNS(null, "transform", `translate(${this.pos.x},${this.pos.y}) rotate(${Math.floor(Math.random() * 180)})`);
            this.G.setAttributeNS(null, "fill", this.color);
            let ga = document.createElementNS(this.SVG_NS, "g");
            ga.setAttribute("class", "a");

            for (let i = 0; i < 2; i++) {
                let g = document.createElementNS(this.SVG_NS, "g");
                for (let j = 0; j < this.n; j++) {
                    let use = document.createElementNS(this.SVG_NS, "use");
                    use.setAttributeNS(this.SVG_XLINK, "xlink:href", `#petal${this.n}`);
                    use.setAttributeNS(null, "width", this.width);
                    use.setAttributeNS(null, "height", this.height);
                    g.appendChild(use);
                }
                ga.appendChild(g);
            }
            this.G.appendChild(ga);
            this.parent.appendChild(this.G);
        }
    }

    // Butterfly effect
    class Butterfly {
        constructor() {
            this.positionX = 0;
            this.positionY = 0;
            this.size = 0;
            this.rotation = 0;
            this.transitionTimer = null;
            this.wingTimer = null;
            this.nextTimer = null;
        }

        startFlutterAnimation() {
            const wrapper = document.getElementById("butterfly_wrapper");
            this.animateFlutter(wrapper, 0);
        }

        animateFlutter(wrapper, currentTimer) {
            this.updateProperties();

            this.nextTimer = currentTimer + this.generateRandomNumber(-200, 200);
            this.nextTimer = (this.nextTimer < 1500 || this.nextTimer > 3000) ? 1500 : this.nextTimer;

            wrapper.style.marginLeft = this.positionX + "px";
            wrapper.style.marginTop = this.positionY + "px";
            wrapper.style.width = this.size + "px";
            wrapper.style.height = this.size + "px";
            wrapper.style.transform = "rotate(" + this.rotation + "deg)";
            wrapper.style.transition = "all " + this.transitionTimer + "s";

            this.updateWingAnimationDuration();

            setTimeout(() => {
                this.animateFlutter(wrapper, this.nextTimer);
            }, currentTimer);
        }

        updateProperties() {
            this.positionX += this.generateRandomNumber(-80, 80);
            this.positionY += this.generateRandomNumber(-80, 80);
            this.positionX = Math.max(30, Math.min(240, this.positionX));
            this.positionY = Math.max(30, Math.min(240, this.positionY));

            this.size += this.generateRandomNumber(-10, 10);
            this.size = Math.max(20, Math.min(40, this.size));

            this.rotation += this.generateRandomNumber(-10, 10);
            this.rotation = Math.max(-20, Math.min(20, this.rotation));

            this.transitionTimer = this.generateRandomNumber(20, 50) / 10;
            this.wingTimer = this.generateRandomNumber(1, 5);
        }

        updateWingAnimationDuration() {
            const upperWings = document.getElementsByClassName("upperwing");
            const lowerWings = document.getElementsByClassName("lowerwing");

            for (let k = 0; k <= 1; k++) {
                upperWings[k].style.animationDuration = "0." + this.wingTimer + "s";
                lowerWings[k].style.animationDuration = "0." + this.wingTimer + "s";
            }
        }

        generateRandomNumber(min, max) {
            return Math.floor((Math.random() * (max - min + 1)) + min);
        }
    }

    // Running all effects in sync
    class SpringEffect {

        constructor() {
            this.cssStyles = `
                    <style>
                    svg{width: 210%;height: auto;position: absolute; background:transparent;fill-opacity:0.40;}
                    symbol { overflow: visible; }
                    svg use { transform: rotate(0deg); transition: transform calc(var(--t) * 1s); }
                    svg g.a { transition: transform calc(var(--t) * 1s); }
                    svg g.a { transform: scale(var(--scale)) rotate(-90deg); filter: url('#f'); }
                    ._2 { --n: 2; }
                    ._3 { --n: 3; }
                    ._4 { --n: 4; }
                    ._5 { --n: 5; }
                    svg .a g:nth-of-type(1) { transform: rotate(calc(-.5 * 180deg / var(--n))); }
                    svg .a g:nth-of-type(2) { transform: rotate(calc(.5 * 180deg / var(--n))); }
                    svg .a g:nth-of-type(1) use:nth-of-type(2) { transform: rotate(calc(-1deg * 180 / var(--n))); }
                    svg .a g:nth-of-type(1) use:nth-of-type(3) { transform: rotate(calc(-2deg * 180 / var(--n))); }
                    svg .a g:nth-of-type(1) use:nth-of-type(4) { transform: rotate(calc(-3deg * 180 / var(--n))); }
                    svg .a g:nth-of-type(1) use:nth-of-type(5) { transform: rotate(calc(-4deg * 180 / var(--n))); }
                    svg .a g:nth-of-type(2) use:nth-of-type(2) { transform: rotate(calc(1deg * 180 / var(--n))); }
                    svg .a g:nth-of-type(2) use:nth-of-type(3) { transform: rotate(calc(2deg * 180 / var(--n))); }
                    svg .a g:nth-of-type(2) use:nth-of-type(4) { transform: rotate(calc(3deg * 180 / var(--n))); }
                    svg .a g:nth-of-type(2) use:nth-of-type(5) { transform: rotate(calc(4deg * 180 / var(--n))); }

                    #butterfly_wrapper {width: 18px;height: 18px;position: absolute;bottom: 50px;right: 30px;rotate: -20deg;}
                    .leftwings, .rightwings {position: absolute;width: 50%;height: 100%;top: 0;}
                    .leftwings {left: 0;}
                    .rightwings {right: 0;}
                    .perspective {position: relative;width: 100%;height: 50%;-webkit-perspective: 150px;-webkit-perspective-origin: 50% 50%;perspective: 150px;perspective-origin: 50% 50%;}
                    .upperwing, .lowerwing {background: #FF4400; background: -moz-radial-gradient(center, ellipse cover, #FF4400 0%, #FFEE00 50%, #FF4400 100%); /* FF3.6-15 */
                        background: -webkit-radial-gradient(center, ellipse cover, #FF4400 0%, #FFEE00 50%, #FF4400 100%); /* Chrome10-25,Safari5.1-6 */
                        background: radial-gradient(ellipse at center, #FF4400 0%, #FFEE00 50%, #FF4400 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
                        filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#FF4400', endColorstr='#FF4400', GradientType=1); /* IE6-9 fallback on horizontal gradient */
                        -webkit-animation-duration: 0.3s;-webkit-animation-iteration-count: infinite;-webkit-animation-direction: alternate;animation-duration: 0.3s;animation-iteration-count: infinite;animation-direction: alternate;}
                    .upperwing { position: absolute; width: 100%; height: 100%; }
                    .upperwing_left { border-top-left-radius: 10%; border-top-right-radius: 80%; border-bottom-right-radius: 0%; border-bottom-left-radius: 30%; -webkit-transform-origin: 100% 50%; transform-origin: 100% 50%; -webkit-animation-name: movewing_left; animation-name: movewing_left; }
                    .upperwing_right { border-top-left-radius: 80%; border-top-right-radius: 10%; border-bottom-right-radius: 30%; border-bottom-left-radius: 0%; -webkit-transform-origin: 0% 50%; transform-origin: 0% 50%; -webkit-animation-name: movewing_right; animation-name: movewing_right; }
                    .lowerwing { position: absolute; top: 0; width: 80%; height: 80%; }
                    .lowerwing_left { right: 0; border-top-left-radius: 30%; border-top-right-radius: 0%; border-bottom-right-radius: 80%; border-bottom-left-radius: 10%; -webkit-transform-origin: 100% 50%; transform-origin: 100% 50%; -webkit-animation-name: movewing_left; animation-name: movewing_left; }
                    .lowerwing_right { left: 0; border-top-left-radius: 0%; border-top-right-radius: 30%; border-bottom-right-radius: 10%; border-bottom-left-radius: 80%; -webkit-transform-origin: 0% 50%; transform-origin: 0% 50%; -webkit-animation-name: movewing_right; animation-name: movewing_right; }
                    @-webkit-keyframes movewing_left { from { -webkit-transform: rotateX(0deg); } to { -webkit-transform: rotateY(65deg); } }
                    @keyframes movewing_left { from { transform: rotateY(0deg); } to { transform: rotateY(65deg); } }
                    @-webkit-keyframes movewing_right { from { -webkit-transform: rotateX(0deg); } to { -webkit-transform: rotateY(-65deg); } }
                    @keyframes movewing_right { from { transform: rotateY(0deg); } to { transform: rotateY(-65deg); } }
                    @media only screen and (max-width: 600px) {  #butterfly_wrapper {right: 20px;width: 10px;height: 10px;}  svg {width: auto;height: 230%;} }
                     @media only screen and (min-width: 768px) and (max-width: 1024px) {svg {width: 300%;height: 150%;}}
                     </style>
                `;
        }

        // Function to add CSS styles to the document
        addCssStyles() {
            document.head.insertAdjacentHTML('afterend', this.cssStyles);
        }

        // Generate random flower colors
        generateRandomColor() {
            const colors = [
                "#ba3763", "#d34076", "#dbb0cc", "#fddafa",
                "#fef2fe", "#eec0db", "#ca809a", "#e9d8e8"
            ];
            return colors[Math.floor(Math.random() * colors.length)];
        }

        // Function to generate initial polygon points
        generatePolygonPoints(gon, R) {
            let points = [];
            for (let a = 0; a < 2 * Math.PI; a += 0.1) {
                let r = R * Math.cos(Math.PI / gon) / Math.cos(a % (2 * Math.PI / gon) - Math.PI / gon);
                let x = 5000 + r * Math.cos(a);
                let y = 5000 + r * Math.sin(a);
                points.push({x: x, y: y, r: 5});
            }
            return points;
        }

        // Function to animate flowers
        animateFlowers(points, svgElement) {
            let frames = 0;
            let rid = null;

            const animate = () => {
                if (frames >= points.length) {
                    cancelAnimationFrame(rid);
                    rid = null;
                    return;
                }

                let m = points[frames];
                let n = 2 + Math.floor(Math.random() * 4);
                let scale = Math.floor(Math.random() * 12) + 3;
                let color = this.generateRandomColor();
                let flower = new Flower(n, {x: m.x, y: m.y}, scale, svgElement, color);
                setTimeout(function () {
                    flower.G.setAttribute("class", `_${flower.n}`);
                }, 200);
                frames++;
                rid = requestAnimationFrame(animate);
            }
            animate();
        }

        hideSvgElement(svgElements) {
            function hide() {
                svgElements.forEach((svgElement) => {
                        svgElement.style.display = 'none';
                    }
                )
                document.removeEventListener('click', hide);
            }

            document.addEventListener('click', hide);
        }

        // Main function to initialize the animation
        initializeAnimation() {
            const svgElement = document.getElementById('svg');
            const allEffects = document.getElementById('butterfly_wrapper');
            const points = this.generatePolygonPoints(7, 2500);
            const butterflyAnimation = new Butterfly();

            this.addCssStyles();
            this.animateFlowers(points, svgElement);
            this.hideSvgElement([svgElement, allEffects]);
            butterflyAnimation.startFlutterAnimation();
        }
    }

    const spring = new SpringEffect();
    spring.initializeAnimation();
</script>

