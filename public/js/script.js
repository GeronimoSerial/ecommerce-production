document.addEventListener('DOMContentLoaded', function() {
    // Selección de elementos del DOM
    const filterButtons = document.querySelectorAll('.filter-button-group button');
    const collectionItems = document.querySelectorAll('.collection-list .col-md-6');
    const collectionList = document.querySelector('.collection-list');


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