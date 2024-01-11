// Helper functions to determine movement and duration
function getMovementValue(width) {
    if (width >= 1200) { // xl
        return '150px';
      } else if (width >= 992) { // lg
        return '100px';
      } else if (width >= 768) { // md
        return '50px';
      } else if (width >= 576) { // sm
        return '25px';
      } else {
        return '10px'; // xs
      }
  }
  
  function getDuration(width) {
    if (width >= 1200) { // xl
        return 1.5;
      } else if (width >= 992) { // lg
        return 1.2;
      } else if (width >= 768) { // md
        return 1;
      } else if (width >= 576) { // sm
        return 0.8;
      } else {
        return 0.5; // xs
      }
  }
  
  // Function to set up or update animations
  function setupAnimations() {
    const viewportWidth = window.innerWidth;
  
    // Kill existing animations and ScrollTriggers if they exist
    if (window.myScrollTrigger) {
      window.myScrollTrigger.kill();
      window.myScrollTrigger = null;
    }
  
    // Navbar animation is separate since it's not part of the ScrollTrigger
    gsap.from('.navbar', { duration: 1, y: '-100%', ease: 'bounce' });
  
    let tl = gsap.timeline({
      scrollTrigger: {
        trigger: ".prob-sol", 
        start: "top center",
        end: "bottom bottom",
        toggleActions: "play none none none",
      }
    });
  
    tl.from(".prob-sol", {
      opacity: 0,
      x: getMovementValue(viewportWidth),
      duration: getDuration(viewportWidth),
      stagger: 0.3,
    }, "-=0.8")
    .from(".card", {
      opacity: 0,
      y: 50,
      duration: getDuration(viewportWidth),
      stagger: 0.3,
    }, "-=0.6")
    .from(".about-us-image", {
      duration: getDuration(viewportWidth),
      opacity: 0,
      x: getMovementValue(viewportWidth),
    }, "-=0.6");
  
    // Create a ScrollTrigger instance and store it on the window object
    window.myScrollTrigger = ScrollTrigger.create({
      animation: tl,
      trigger: ".prob-sol",
      start: "top center",
      end: "bottom bottom",
      toggleActions: "play none none none",
    });
  }
  
  setupAnimations();
  
  window.addEventListener('resize', () => {
    setupAnimations();
  });
  