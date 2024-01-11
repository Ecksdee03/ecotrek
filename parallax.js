let text = document.getElementById('text');
let leaf = document.getElementById('leaf');
let hill1 = document.getElementById('hill1');
let hill4 = document.getElementById('hill4');
let hill5 = document.getElementById('hill5');
let sec = document.querySelector('.next'); // Get the reference to the next section
let maxScrollValue = sec.offsetTop;

window.addEventListener('scroll', () => {
    let value = window.scrollY;
    let screenWidth = window.innerWidth;
    let parallaxIntensity;

    // Calculate the maximum scroll value to stop parallax
    // if (value <= maxScrollValue) {
    //     text.style.marginTop = value * 1.5 + 'px';
    //     leaf.style.top = value * -1.5 + 'px';
    //     leaf.style.left = value * 1.5 + 'px';
    //     hill5.style.left = value * 1.5 + 'px';
    //     hill4.style.left = value * -1.5 + 'px';
    //     hill1.style.top = value * 1.5 + 'px';
    // }
    
    if (screenWidth < 576) {
        // Extra small devices
        parallaxIntensity = 0.3;
    } else if (screenWidth >= 576 && screenWidth < 768) {
        // Small devices
        parallaxIntensity = 0.5;
    } else if (screenWidth >= 768 && screenWidth < 992) {
        // Medium devices
        parallaxIntensity = 1.0;
    } else if (screenWidth >= 992 && screenWidth < 1200) {
        // Large devices
        parallaxIntensity = 1.5;
    } else if (screenWidth >= 1200 && screenWidth < 1400) {
        // Extra large devices
        parallaxIntensity = 2.0;
    } else {
        // Extra extra large devices
        parallaxIntensity = 2.5;
    }

    if (value <= maxScrollValue) {
        text.style.marginTop = (value * parallaxIntensity) + 'px';
        leaf.style.top = (value * -parallaxIntensity) + 'px';
        leaf.style.left = (value * parallaxIntensity) + 'px';
        hill5.style.left = (value * parallaxIntensity) + 'px';
        hill4.style.left = (value * -parallaxIntensity) + 'px';
        hill1.style.top = (value * parallaxIntensity) + 'px';
    }

});