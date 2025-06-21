document.addEventListener('DOMContentLoaded', function () {
    
    // Selección de elementos del DOM
    // const filterButtons = document.querySelectorAll('.filter-button-group button');
    // const collectionItems = document.querySelectorAll('.collection-list .col-md-6');
    // const collectionList = document.querySelector('.collection-list');


    document.addEventListener('DOMContentLoaded', function() {
        const triggerTabList = [].slice.call(document.querySelectorAll('#termsTab button'));
        triggerTabList.forEach(function(triggerEl) {
            const tabTrigger = new bootstrap.Tab(triggerEl);
            triggerEl.addEventListener('click', function(event) {
                event.preventDefault();
                tabTrigger.show();
            });
        });
    });
});

    document.querySelectorAll('.tilt-card').forEach(card => {
        card.addEventListener('mousemove', e => {
            if (window.innerWidth > 768) {
                const rect = card.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;
                const centerX = rect.width / 2;
                const centerY = rect.height / 2;
                const rotateX = (y - centerY) / 12;
                const rotateY = (centerX - x) / 12;
                
                card.querySelector('.tilt-card-inner').style.transform = 
                    `rotateX(${rotateX}deg) rotateY(${rotateY}deg) translateZ(15px) scale(1.03)`;
            }
        });

        card.addEventListener('mouseleave', () => {
            card.querySelector('.tilt-card-inner').style.transform = 'rotateX(0deg) rotateY(0deg) translateZ(0px) scale(1)';
        });

        card.addEventListener('click', () => {
            const cardInner = card.querySelector('.tilt-card-inner');
            cardInner.style.transform = 'scale(0.98)';
            setTimeout(() => {
                cardInner.style.transform = 'scale(1)';
            }, 150);
        });
    });