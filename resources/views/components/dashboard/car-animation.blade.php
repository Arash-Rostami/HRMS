<div class="hidden lg:block" id="report-car" title="Let's roll!"></div>


<script>
    /*car animation*/
    const carElement = document.getElementById('report-car');
    const pageWidth = window.innerWidth;
    const carWidth = carElement.getBoundingClientRect().width;
    const distance = pageWidth + carWidth;
    let isCarVisible = true;


    /*to trigger car movement*/
    carElement.addEventListener('click', () => {
        carElement.style.transform = `translateX(-${distance}px)`;
        carElement.removeEventListener('click', this);
        setTimeout(() => carElement.remove(), 3900);
    });
    /*to toggle car by scrolling*/
    window.addEventListener('scroll', () => {
        carElement.style.opacity = window.scrollY > 0 ? '0' : '1';
        isCarVisible = !window.scrollY > 0;
    });
</script>
