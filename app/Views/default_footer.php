
    <div id="footer" class="sticky bottom-0 left-0 w-full z-30 bg-white border-t border-gray-200 dark:bg-gray-700 dark:border-gray-600">
        <div class="grid h-full max-w-lg grid-cols-4 mx-auto font-medium">
            <a href="<?= esc(base_url('/')) ?>" class="inline-flex flex-col items-center justify-center px-5 hover:bg-gray-50 dark:hover:bg-gray-800 group">
                <svg class="w-10 h-10 text-gray-500 dark:text-gray-400 group-hover:text-blue-600 dark:group-hover:text-blue-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm14-7.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1Zm0 4a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1Zm-5-4a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1Zm0 4a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1Zm-5-4a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1Zm0 4a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1ZM20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4Z" />
                </svg>
                <span class="text-sm text-gray-500 dark:text-gray-400 group-hover:text-blue-600 dark:group-hover:text-blue-500">Calendrier</span>
            </a>
            <a href="<?= esc(base_url('Customers')) ?>" class="inline-flex flex-col items-center justify-center px-5 hover:bg-gray-50 dark:hover:bg-gray-800 group">
                <svg class="w-10 h-10 text-gray-500 dark:text-gray-400 group-hover:text-blue-600 dark:group-hover:text-blue-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 0a10 10 0 1 0 10 10A10.011 10.011 0 0 0 10 0Zm0 5a3 3 0 1 1 0 6 3 3 0 0 1 0-6Zm0 13a8.949 8.949 0 0 1-4.951-1.488A3.987 3.987 0 0 1 9 13h2a3.987 3.987 0 0 1 3.951 3.512A8.949 8.949 0 0 1 10 18Z" />
                </svg>
                <span class="text-sm text-gray-500 dark:text-gray-400 group-hover:text-blue-600 dark:group-hover:text-blue-500">Clients</span>
            </a>
            <a href="<?= esc(base_url('History')) ?>" class="inline-flex flex-col items-center justify-center px-5 hover:bg-gray-50 dark:hover:bg-gray-800 group">
                <svg class="w-10 h-10 text-gray-500 dark:text-gray-400 group-hover:text-blue-600 dark:group-hover:text-blue-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 18">
                    <path d="M15.977.783A1 1 0 0 0 15 0H3a1 1 0 0 0-.977.783L.2 9h4.239a2.99 2.99 0 0 1 2.742 1.8 1.977 1.977 0 0 0 3.638 0A2.99 2.99 0 0 1 13.561 9H17.8L15.977.783ZM6 2h6a1 1 0 1 1 0 2H6a1 1 0 0 1 0-2Zm7 5H5a1 1 0 0 1 0-2h8a1 1 0 1 1 0 2Z" />
                    <path d="M1 18h16a1 1 0 0 0 1-1v-6h-4.439a.99.99 0 0 0-.908.6 3.978 3.978 0 0 1-7.306 0 .99.99 0 0 0-.908-.6H0v6a1 1 0 0 0 1 1Z" />
                </svg>
                <span class="text-sm text-gray-500 dark:text-gray-400 group-hover:text-blue-600 dark:group-hover:text-blue-500">Historique</span>
            </a>
            <a href="<?= esc(base_url('Config')) ?>" class="inline-flex flex-col items-center justify-center px-5 hover:bg-gray-50 dark:hover:bg-gray-800 group">
                <svg class="w-10 h-10 text-gray-500 dark:text-gray-400 group-hover:text-blue-600 dark:group-hover:text-blue-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 12.25V1m0 11.25a2.25 2.25 0 0 0 0 4.5m0-4.5a2.25 2.25 0 0 1 0 4.5M4 19v-2.25m6-13.5V1m0 2.25a2.25 2.25 0 0 0 0 4.5m0-4.5a2.25 2.25 0 0 1 0 4.5M10 19V7.75m6 4.5V1m0 11.25a2.25 2.25 0 1 0 0 4.5 2.25 2.25 0 0 0 0-4.5ZM16 19v-2" />
                </svg>
                <span class="text-sm text-gray-500 dark:text-gray-400 group-hover:text-blue-600 dark:group-hover:text-blue-500">Réglage</span>
            </a>

        </div>
    </div>


</div>
<script>


    // Footer active page:
    document.addEventListener("DOMContentLoaded", function() {
        let currentPath = window.location.pathname.split('/').pop();
        let footerLinks = document.querySelectorAll('.grid a');
        footerLinks.forEach(link => {
            let linkPath = new URL(link.href).pathname.split('/').pop();
            if (currentPath === linkPath) {

                link.querySelector('svg').classList.add('text-blue-600');
                link.querySelector('span').classList.add('text-blue-600');
                link.querySelector('svg').classList.remove('text-gray-500');
                link.querySelector('span').classList.remove('text-gray-500');
            }
        });
    });

    //URL BASE pour requete AJAX
    const baseurl = <?= json_encode($baseurl); ?>;
    // Liste des services
    let services_list = <?= json_encode($services_list); ?>;
</script>
<script src="Assets/js/jquery.3.7.1.min.js"></script>
<script src="Assets/js/fullcalendar.6.1.9.min.js"></script>
<script src="Assets/js/select2.min.js"></script>
<script src="Assets/js/wd_function_toolbox.js"></script>
<script src="Assets/js/wd_modal_system.js"></script>
<script src="Assets/js/wd_html.js"></script>
<script src="Assets/js/wd_fullcalendar.js"></script>
<script src="Assets/js/wd_sidetools.js"></script>
<script>
// LOADER
document.addEventListener('DOMContentLoaded', function() {
    var loader = document.querySelector('.loader');
    loader.style.display = 'none';
});

if(!window.location.href.includes('Config')){

    // Initialisation du select recherche
    $(document).ready(function() {

        $('#ModaleventCustomer_id').select2({
            tags: true,
            tokenSeparators: [',', ' '],
            placeholder: "Recherchez ou ajoutez un nouveau client",
            createTag: function(params) {
                return {
                    id: params.term,
                    text: params.term,
                    newOption: true,
                    width: 'resolve',

                }
            }
        }).on("select2:select", function(e) {
            if (e.params.data.newOption) {
                ShowCreateCustomer(); // Ouvrir le popup d'ajout avec le texte prérempli
                document.getElementById('customer_name').value = e.params.data.text;
            }
        });
        
    });

    //SCROLL MAX BOTTOM
    let startY;
    let isBottomReached = false;
    let threshold = 400; // Distance en pixels pour déclencher l'action après avoir atteint le bas

    window.addEventListener('touchstart', (e) => {
    startY = e.touches[0].clientY;
    });

    window.addEventListener('touchmove', (e) => {
    let moveY = e.touches[0].clientY;
    let isScrollingDown = moveY < startY;

    if (isScrollingDown && (window.innerHeight + window.pageYOffset) >= document.body.offsetHeight) {
        // L'utilisateur atteint le bas de la page.
        isBottomReached = true;
    }

    if (isBottomReached) {
        let distanceScrolledAfterBottom = startY - moveY;
        if (distanceScrolledAfterBottom > threshold) {
        // L'utilisateur a continué à défiler de plus de 200px après avoir atteint le bas.
        closeModal();
        isBottomReached = false; // Réinitialiser le flag pour le prochain cycle de défilement
        }
    }
    });

    window.addEventListener('touchend', () => {
    isBottomReached = false; // Réinitialiser quand l'utilisateur lève le doigt
    });

} 
</script>
</body>

</html>