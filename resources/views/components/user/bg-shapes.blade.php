<div
    class="relative inset-0 -z-10"
    x-data="{
        shapes: [],
        init() {
            this.generateShapes();
        },
        generateShapes() {
             const types = ['circle', 'square', 'triangle', 'blob'];
             this.shapes = types.map(type => ({
                type: type,
                color: this.getRandomColor(),
                size: this.getRandomSize(),
                position: this.getRandomRandomizedPosition()
            }));
        },
        getRandomColor() {
            const colors = ['#FFB3C6', '#C6D8FF', '#FFE4B3', '#B3FFC6', '#D9B3FF', '#FFDAC6', '#C6FFF0', '#FFD9F0'];
            return colors[Math.floor(Math.random() * colors.length)];
        },
        getRandomSize() {
            const sizes = [
                { width: 60, height: 60 },
                { width: 100, height: 100 },
                { width: 150, height: 150 },
            ];
            return sizes[Math.floor(Math.random() * sizes.length)];
        },
        getRandomRandomizedPosition() {
            const maxWidth = window.innerWidth;
            const maxHeight = window.innerHeight;
            const randomTop = Math.floor(Math.random() * (maxHeight - 150)); // Adjust 150 to avoid overflow
            const randomLeft = Math.floor(Math.random() * (maxWidth - 150)); // Adjust 150 to avoid overflow
            return { top: `${randomTop}px`, left: `${randomLeft}px` };
        }
    }"
>
    <template x-for="shape in shapes" :key="`${shape.type}-${shape.color}-${shape.position.top}-${shape.position.left}`">
        <div
            class="absolute"
            :style="
            shape.type === 'circle'
                ? `width: ${shape.size.width}px; height: ${shape.size.height}px; border-radius: 50%; background-color: ${shape.color}; top: ${shape.position.top}; left: ${shape.position.left};  {{ isDarkMode() ? 'opacity:0.1' : 'opacity:0.3' }}`
                : shape.type === 'square'
                ? `width: ${shape.size.width}px; height: ${shape.size.height}px; background-color: ${shape.color}; top: ${shape.position.top}; left: ${shape.position.left}; {{ isDarkMode() ? 'opacity:0.1' : 'opacity:0.3' }}`
                : shape.type === 'triangle'
                ? `width: 0; height: 0; border-left: ${shape.size.width / 2}px solid transparent; border-right: ${shape.size.width / 2}px solid transparent; border-bottom: ${shape.size.height}px solid ${shape.color}; top: ${shape.position.top}; left: ${shape.position.left}; {{ isDarkMode() ? 'opacity:0.1' : 'opacity:0.3' }};`
                : shape.type === 'blob'
                ? `width: ${shape.size.width}px; height: ${shape.size.height}px; background-color: ${shape.color}; border-radius: 50% 40% 60% 40% / 40% 60% 40% 60%; top: ${shape.position.top}; left: ${shape.position.left}; {{ isDarkMode() ? 'opacity:0.1' : 'opacity:0.3' }};`
                : ''"
        ></div>
    </template>
</div>
