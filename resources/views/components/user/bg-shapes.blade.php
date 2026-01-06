@php
    $shapes = isDarkMode()
        ? ['circle','square','triangle','blob']
        : ['circle','square','triangle','blob','diamond','hexagon','star','oval'];

    $isDark = isDarkMode();
@endphp

<div
    class="absolute inset-0 -z-10 overflow-hidden"
    x-show="open"
    x-data="{
        shapes: [],
        isDark: @js($isDark),
        init() { setTimeout(() => { this.generateShapes(); this.$nextTick(() => this.floatShapes()) }, 100) },
        generateShapes() {
            const types = @js($shapes);
            const positions = [];
            this.shapes = types.map(type => {
                const size = this.getRandomSize();
                const position = this.getRandomPosition(size, positions);
                positions.push(position);
                return { type, color: this.getRandomColor(), size, position };
            });
        },
        floatShapes() {
            this.$el.querySelectorAll('[data-shape]').forEach((el, i) => {
                const amp = 6 + Math.random() * 10;
                const ampX = Math.random() * 6;
                const rot = (Math.random() * 1.5);
                const dur = 5000 + Math.random() * 4000;
                const delay = Math.random() * 1000;

                el.animate(
                    [
                        { transform: `translate(0px, 0px) rotate(0deg)` },
                        { transform: `translate(${ampX}px, -${amp}px) rotate(${rot}deg)` },
                        { transform: `translate(0px, 0px) rotate(0deg)` },
                        { transform: `translate(-${ampX}px, ${amp}px) rotate(-${rot}deg)` },
                        { transform: `translate(0px, 0px) rotate(0deg)` },
                    ],
                    { duration: dur, iterations: Infinity, easing: 'ease-in-out', delay }
                );
            });
        },
        getRandomColor() {
            const colors = ['#FFB3C6','#C6D8FF','#FFE4B3','#B3FFC6','#D9B3FF','#FFDAC6','#C6FFF0','#FFD9F0'];
            return colors[Math.floor(Math.random() * colors.length)];
        },
        getRandomSize() {
            const sizes = [{w:60,h:60},{w:100,h:100},{w:150,h:150}];
            const s = sizes[Math.floor(Math.random() * sizes.length)];
            return { width: s.w, height: s.h };
        },
        getRandomPosition(size, existing = []) {
            const c = this.$el.parentElement;
            const W = c.offsetWidth, H = c.offsetHeight, minD = 400;
            let tries = 0, pos;
            do {
                const top = Math.floor(Math.random() * Math.max(0, H - size.height));
                const left = Math.floor(Math.random() * Math.max(0, W - size.width));
                pos = { top, left };
                tries++;
            } while (tries < 50 && existing.some(p =>
                Math.hypot(pos.left - p.left, pos.top - p.top) < minD
            ));
            return { top: `${pos.top}px`, left: `${pos.left}px` };
        }
    }"
>
    <template x-for="shape in shapes" :key="`${shape.type}-${shape.color}-${shape.position.top}-${shape.position.left}`">
        <div
            data-shape
            class="absolute will-change-transform"
            style="transform: translateZ(0);"
            :style="
                shape.type === 'circle'   ? `width:${shape.size.width}px;height:${shape.size.height}px;border-radius:50%;background:${shape.color};top:${shape.position.top};left:${shape.position.left};opacity:${isDark?'0.05':'0.3'};` :
                shape.type === 'square'   ? `width:${shape.size.width}px;height:${shape.size.height}px;background:${shape.color};top:${shape.position.top};left:${shape.position.left};opacity:${isDark?'0.05':'0.3'};` :
                shape.type === 'triangle' ? `width:0;height:0;border-left:${shape.size.width/2}px solid transparent;border-right:${shape.size.width/2}px solid transparent;border-bottom:${shape.size.height}px solid ${shape.color};top:${shape.position.top};left:${shape.position.left};opacity:${isDark?'0.05':'0.3'};` :
                shape.type === 'blob'     ? `width:${shape.size.width}px;height:${shape.size.height}px;background:${shape.color};border-radius:50% 40% 60% 40% / 40% 60% 40% 60%;top:${shape.position.top};left:${shape.position.left};opacity:${isDark?'0.05':'0.3'};` :
                shape.type === 'diamond'  ? `width:${shape.size.width}px;height:${shape.size.height}px;background:${shape.color};transform:rotate(45deg);top:${shape.position.top};left:${shape.position.left};opacity:${isDark?'0.05':'0.3'};` :
                shape.type === 'hexagon'  ? `width:${shape.size.width}px;height:${shape.size.height}px;background:${shape.color};clip-path:polygon(50% 0%,100% 25%,100% 75%,50% 100%,0% 75%,0% 25%);top:${shape.position.top};left:${shape.position.left};opacity:${isDark?'0.05':'0.3'};` :
                shape.type === 'star'     ? `width:${shape.size.width}px;height:${shape.size.height}px;background:${shape.color};clip-path:polygon(50% 0%,61% 35%,98% 35%,68% 57%,79% 91%,50% 70%,21% 91%,32% 57%,2% 35%,39% 35%);top:${shape.position.top};left:${shape.position.left};opacity:${isDark?'0.05':'0.3'};` :
                shape.type === 'oval'     ? `width:${shape.size.width}px;height:${shape.size.height}px;background:${shape.color};border-radius:50%;transform:scaleX(1.5);top:${shape.position.top};left:${shape.position.left};opacity:${isDark?'0.05':'0.3'};` : ''
            ">
        </div>
    </template>
</div>
