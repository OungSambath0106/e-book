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
        cartBtn.addEventListener('click', () => {
            // Create notification element
            const notification = document.createElement('div');
            notification.style.position = 'fixed';
            notification.style.top = '80px';
            notification.style.right = '20px';
            notification.style.backgroundColor = '#6c5ce7';
            notification.style.color = 'white';
            notification.style.padding = '15px 20px';
            notification.style.borderRadius = '5px';
            notification.style.boxShadow = '0 5px 15px rgba(0,0,0,0.1)';
            notification.style.zIndex = '1001';
            notification.style.transform = 'translateX(120%)';
            notification.style.transition = 'transform 0.3s ease';
            notification.innerHTML = '<i class="fas fa-check-circle"></i> Book added to cart!';

            document.body.appendChild(notification);

            // Show notification
            setTimeout(() => {
                notification.style.transform = 'translateX(0)';
            }, 100);

            // Hide and remove notification
            setTimeout(() => {
                notification.style.transform = 'translateX(120%)';
                setTimeout(() => {
                    document.body.removeChild(notification);
                }, 300);
            }, 3000);
        });

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
@stack('js')