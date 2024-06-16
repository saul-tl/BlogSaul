document.addEventListener("DOMContentLoaded", function() {
    const cards = document.querySelectorAll('.card');

    cards.forEach(card => {
        card.addEventListener('mouseover', () => {
            card.style.transform = 'translateY(-5px)';
            card.style.boxShadow = '0 8px 16px rgba(0,0,0,0.4)';
        });

        card.addEventListener('mouseout', () => {
            card.style.transform = 'translateY(0)';
            card.style.boxShadow = '0 4px 8px rgba(0,0,0,0.2)';
        });
    });

    
    document.getElementById('contactForm').addEventListener('submit', function(event) {
        event.preventDefault();

        const sendButton = document.getElementById('sendButton');
        const buttonText = document.getElementById('buttonText');
        const planeIcon = document.getElementById('planeIcon');
        const form = this;

        
        planeIcon.style.opacity = '1';
        planeIcon.style.visibility = 'visible';

        
        buttonText.textContent = 'Enviando...';

        let distance = 0;
        const interval = setInterval(function() {
            if (distance < 900) {
                distance += 1;
                planeIcon.style.transform = `translateX(${distance}px) rotate(45deg)`;
            } else {
                clearInterval(interval);
                buttonText.textContent = 'Enviado';
                planeIcon.style.opacity = '0';
                planeIcon.style.visibility = 'hidden';  
                
                setTimeout(function() {
                    planeIcon.style.transform = 'translateX(0) rotate(0deg)';
                    buttonText.textContent = 'Enviar';
                    form.reset();
                }, 2000);
            }
        }, 1);
    });

    
    const testimonials = document.querySelectorAll('.testimonial');

    testimonials.forEach(testimonial => {
        testimonial.addEventListener('click', function() {
            testimonials.forEach(t => t.classList.remove('enlarged'));
            this.classList.add('enlarged');
        });
    });

    
    var testimonialsCarousel = document.getElementById('testimonialsCarousel');
    testimonialsCarousel.addEventListener('mouseover', function() {
        $('#testimonialsCarousel').carousel('pause');
    });
    testimonialsCarousel.addEventListener('mouseout', function() {
        $('#testimonialsCarousel').carousel('cycle');
    });
});
document.addEventListener('DOMContentLoaded', function() {
    var noticiasCarousel = document.getElementById('noticiasCarousel');
    var carousel = new bootstrap.Carousel(noticiasCarousel, {
        interval: 5000,
        ride: 'carousel'
    });

    noticiasCarousel.addEventListener('mouseover', function() {
        carousel.pause();
    });

    noticiasCarousel.addEventListener('mouseout', function() {
        carousel.cycle();
    });
});

