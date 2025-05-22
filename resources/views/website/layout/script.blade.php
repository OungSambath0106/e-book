<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<script src="https://unpkg.com/aos@next/dist/aos.js"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
<script>
    AOS.init();

    AOS.init({
    // Global settings:
    disable: false, // accepts following values: 'phone', 'tablet', 'mobile', boolean, expression or function
    startEvent: 'DOMContentLoaded', // name of the event dispatched on the document, that AOS should initialize on
    initClassName: 'aos-init', // class applied after initialization
    animatedClassName: 'aos-animate', // class applied on animation
    useClassNames: false, // if true, will add content of `data-aos` as classes on scroll
    disableMutationObserver: false, // disables automatic mutations' detections (advanced)
    debounceDelay: 50, // the delay on debounce used while resizing window (advanced)
    throttleDelay: 99, // the delay on throttle used while scrolling the page (advanced)


    // Settings that can be overridden on per-element basis, by `data-aos-*` attributes:
    offset: 100, // offset (in px) from the original trigger point
    delay: 150, // values from 0 to 3000, with step 50ms
    duration: 1000, // values from 0 to 3000, with step 50ms
    easing: 'ease', // default easing for AOS animations
    once: false, // whether animation should happen only once - while scrolling down
    mirror: false, // whether elements should animate out while scrolling past them
    anchorPlacement: 'top-bottom', // defines which position of the element regarding to window should trigger the animation
    });
</script>
<script>
    // Animation on scroll
    document.addEventListener('DOMContentLoaded', function() {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = 1;
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, {
            threshold: 0.1
        });

        // Observe all section headers, features, and book cards
        document.querySelectorAll('.section-header, .feature, .book-card').forEach(element => {
            element.classList.add('fade-in');
            observer.observe(element);
        });

        // Add hover effects to navigation links
        const navLinks = document.querySelectorAll('nav a');
        navLinks.forEach(link => {
            link.addEventListener('mouseenter', () => {
                link.style.color = '#6c5ce7';
            });

            link.addEventListener('mouseleave', () => {
                if (link.classList.contains('active')) return;
                link.style.color = '#333';
            });
        });

        // Book card hover animations
        const bookCards = document.querySelectorAll('.book-card');
        bookCards.forEach(card => {
            card.addEventListener('mouseenter', () => {
                card.style.transform = 'translateY(-10px)';
                card.style.boxShadow = '0 15px 30px rgba(0,0,0,0.1)';
            });

            card.addEventListener('mouseleave', () => {
                card.style.transform = 'translateY(0)';
                card.style.boxShadow = '0 5px 15px rgba(0,0,0,0.08)';
            });
        });

        // Search button animation
        const searchBtn = document.querySelector('.search-btn-hero');
        const searchInput = document.querySelector('.search-input');

        searchBtn.addEventListener('click', () => {
            if (searchInput.value.trim() !== '') {
                searchBtn.style.transform = 'scale(0.9)';
                setTimeout(() => {
                    searchBtn.style.transform = 'scale(1)';
                }, 200);
            } else {
                searchInput.style.boxShadow = '0 0 0 2px #6c5ce7';
                setTimeout(() => {
                    searchInput.style.boxShadow = '0 5px 15px rgba(0,0,0,0.08)';
                }, 800);
            }
        });

        // Add loading animation for images
        const images = document.querySelectorAll('img');
        images.forEach(img => {
            img.style.opacity = '0';
            img.style.transition = 'opacity 0.5s ease';

            img.addEventListener('load', () => {
                img.style.opacity = '1';
            });
        });

        // Simulate a book being added to cart
        const cartBtn = document.querySelector('.add-to-cart');
        // cartBtn.addEventListener('click', () => {
        //     // Create notification element
        //     const notification = document.createElement('div');
        //     notification.style.position = 'fixed';
        //     notification.style.top = '80px';
        //     notification.style.right = '20px';
        //     notification.style.backgroundColor = '#6c5ce7';
        //     notification.style.color = 'white';
        //     notification.style.padding = '15px 20px';
        //     notification.style.borderRadius = '5px';
        //     notification.style.boxShadow = '0 5px 15px rgba(0,0,0,0.1)';
        //     notification.style.zIndex = '1001';
        //     notification.style.transform = 'translateX(120%)';
        //     notification.style.transition = 'transform 0.3s ease';
        //     notification.innerHTML = '<i class="fas fa-check-circle"></i> Book added to cart!';

        //     document.body.appendChild(notification);

        //     // Show notification
        //     setTimeout(() => {
        //         notification.style.transform = 'translateX(0)';
        //     }, 100);

        //     // Hide and remove notification
        //     setTimeout(() => {
        //         notification.style.transform = 'translateX(120%)';
        //         setTimeout(() => {
        //             document.body.removeChild(notification);
        //         }, 300);
        //     }, 3000);
        // });

        // Initialize active state for home link
        document.querySelector('nav ul li a.active').classList.add('active');
        document.querySelector('nav ul li a.active').style.color = '#6c5ce7';

        // Hero parallax effect
        document.addEventListener('mousemove', (e) => {
            const hero = document.querySelector('.hero');
            const xAxis = (window.innerWidth / 2 - e.pageX) / 50;
            const yAxis = (window.innerHeight / 2 - e.pageY) / 50;

            hero.style.backgroundPosition = `calc(50% + ${xAxis}px) calc(50% + ${yAxis}px)`;
        });

        // Contact button pulse animation
        // const contactBtn = document.querySelector('.contact-btn');

        // function pulseAnimation() {
        //     contactBtn.style.transform = 'scale(1.05)';
        //     contactBtn.style.boxShadow = '0 0 0 5px rgba(108, 92, 231, 0.3)';

        //     setTimeout(() => {
        //         contactBtn.style.transform = 'scale(1)';
        //         contactBtn.style.boxShadow = 'none';
        //     }, 1000);
        // }

        // Run pulse animation every 5 seconds
        // setInterval(pulseAnimation, 5000);

        // Run once on load
        // setTimeout(pulseAnimation, 2000);
    });
</script>
<script>
    document.getElementById('search-input').addEventListener('click', function () {
        window.location.href = "{{ route('books.search') }}";
    });
</script>
@stack('js')