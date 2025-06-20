<template>
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
</template>

<style>
    /* Your component-specific CSS styles */
    .example-component {
        /* Styles */
    }
</style>

<script>
    // Your component-specific JavaScript
    export default {
        data() {
            return {
                // Component data
            };
        },
        methods: {
            handleClick() {
                // Event handler
            }
        }
    }
</script>
