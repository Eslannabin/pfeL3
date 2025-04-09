document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('search-input');
    const filterDiplome = document.getElementById('filter-diplome');
    const memoireCards = document.querySelectorAll('.memoire-card');

    function filterMemoires() {
        const searchTerm = searchInput.value.toLowerCase();
        const diplomeValue = filterDiplome.value.toLowerCase();

        memoireCards.forEach(card => {
            const title = card.querySelector('h3').textContent.toLowerCase();
            const author = card.querySelector('.memoire-body p:first-child').textContent.toLowerCase();
            const diplome = card.getAttribute('data-diplome').toLowerCase();

            const matchesSearch = title.includes(searchTerm) || author.includes(searchTerm);
            const matchesDiplome = diplomeValue === '' || diplome === diplomeValue;

            card.style.display = (matchesSearch && matchesDiplome) ? 'block' : 'none';
        });
    }

    searchInput.addEventListener('input', filterMemoires);
    filterDiplome.addEventListener('change', filterMemoires);
});