<?php
$modal_id = "LoginModal";
?>
<div id="<?= $modal_id ?>-shadow_modal" class="fixed inset-0 bg-black opacity-50 hidden" onclick="closeModalById('<?= $modal_id ?>')"></div>

<!-- ADD EVENTS - Modal Container -->
<div id="<?= $modal_id ?>" tabindex="-1" aria-hidden="true" class="fixed max-w-md lg:max-w-lg flex flex-grow hidden top-0 overflow-auto bg-white border border-gray-200 rounded-lg dark:bg-slate-800 dark:border-gray-800 shadow-2xl" >
<div class="relative  mx-auto">


    <!-- Modal Header -->
    <div class="px-6 py-6 lg:px-8 flex justify-between items-center">

        <div class="flex-grow text-center">
            <h3 id="addEventModal_title" class="text-center text-2xl font-bold text-gray-800 dark:text-white">Réservation</h3>
        </div>    
        <div>
            <button type="button" class=" text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="authentication-modal" onclick="closeModalById('<?= $modal_id ?>')">
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
                <span class=" sr-only">Fermer</span>
            </button>
        </div>
    </div>

    <!-- Modal Form -->
    <div class="px-6 py-6 lg:px-8 mb-20">
        <div class="login-container">
            <form id="loginForm">
                <input type="text" id="username" name="username" placeholder="Nom d'utilisateur" required>
                <input type="password" id="password" name="password" placeholder="Mot de passe" required>
                <button type="submit">Connexion</button>
            </form>
            <div id="loginResult"></div>
        </div>
    </div>
</div>
<script>
document.getElementById('loginForm').addEventListener('submit', function(e) {
    e.preventDefault();

    var username = document.getElementById('username').value;
    var password = document.getElementById('password').value;

    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'login.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
        // Traiter la réponse ici
        console.log(this.responseText);
        var response = JSON.parse(this.responseText);
        if (response.success) {
            window.location = baseurl;
        } else {
            document.getElementById('loginResult').textContent = response.message; // Affichez le message d'erreur
        }
    };
    xhr.send('username=' + encodeURIComponent(username) + '&password=' + encodeURIComponent(password));
});

</script>
