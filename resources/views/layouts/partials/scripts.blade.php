<script>
    window.onscroll = function() {
      const navbar = document.getElementById("navbar");
      const logo = document.querySelector(".navbar-logo-img");
      const navbarText = document.querySelectorAll(".navbar-text");
      const mobileMenu = document.getElementById("mobile-menu");
  
      // Scroll-based navbar effects
      if (document.body.scrollTop > 50 || document.documentElement.scrollTop > 50) {
        navbar.classList.remove("transparent");
        navbar.classList.add("scrolled");
        logo.classList.remove("large");
        logo.classList.add("small");
        navbarText.forEach((text) => {
          text.classList.remove("large");
          text.classList.add("small");
        });
  
        // Adjust mobile menu top position dynamically when navbar is small
        mobileMenu.style.top = `${navbar.offsetHeight}px`;
      } else {
        navbar.classList.remove("scrolled");
        navbar.classList.add("transparent");
        logo.classList.remove("small");
        logo.classList.add("large");
        navbarText.forEach((text) => {
          text.classList.remove("small");
          text.classList.add("large");
        });
  
        // Reset mobile menu top position to default when navbar is large
        mobileMenu.style.top = `4.5rem`; // Default top when navbar is not scrolled
      }
    };
  
    // Hamburger Menu Toggle
    const hamburger = document.getElementById('hamburger');
    const mobileMenu = document.getElementById('mobile-menu');
    
    hamburger.addEventListener('click', () => {
      mobileMenu.classList.toggle('hidden');
    });




     ScrollReveal().reveal('#logo-section', {
      duration: 1000,
      origin: 'bottom',
      distance: '50px',
      delay: 200,
      opacity: 0,
      easing: 'ease-in-out',
      reset: false
    });
  </script>
   <script>
    const images = document.getElementById('hero-images');
    const totalImages = images.children.length;
    let currentIndex = 0;

    setInterval(() => {
      currentIndex = (currentIndex + 1) % totalImages;
      images.style.transform = `translateX(-${currentIndex * 100}%)`;
    }, 4000);
  </script>
  <script>
    document.getElementById('tentangKami').addEventListener('click', function(e) {
      e.preventDefault();
      const parent = this.parentElement;
      parent.classList.toggle('active');
    });
  
    document.getElementById('mobileTentangKami').addEventListener('click', function(e) {
      e.preventDefault();
      const dropdown = this.nextElementSibling;
      dropdown.classList.toggle('hidden');
    });
  </script>