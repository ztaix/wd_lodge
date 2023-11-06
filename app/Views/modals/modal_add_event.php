<?php
$modal_id = "addEventModal";


?>
<!-- ADD EVENTS - Modal Container -->
<div id="<?= $modal_id ?>" tabindex="-1" aria-hidden="true" class="fixed w-full h-[calc(100vh)] inset-0 hidden z-50 overflow-auto ">
    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700  flex justify-center ">

        <!-- Modal content -->
        <div class=" max-w-4xl">


            <!-- Modal Header -->
            <div class="px-6 py-6 lg:px-8 flex justify-between items-center">
                <div>
                    <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 1v16M1 9h16" />
                    </svg>
                </div>
                <div class="flex-grow text-center">
                    <h3 id="addEventModal_title" class="text-center text-2xl font-bold text-gray-800 dark:text-white">Ajouter</h3>
                </div>
                <div>
                    <button type="button" class=" text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="authentication-modal" onclick="closeModalById('<?= $modal_id ?>')">
                        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class=" sr-only">Fermer</span>
                    </button>
                </div>
            </div>

            <div class="px-6 py-6 lg:px-8">
                <form id="eventForm" class="space-y-6">
                    <input type="hidden" id="id" name="id">
                    <div>
                        <select id="eventType_doc" name="eventType_doc" class="block w-full p-4 text-xl font-bold text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="Devis" selected>Devis</option>
                            <option value="Facture">Facture</option>
                        </select>
                    </div>

                    <div class="flex w-full items-center">
                        <div class="flex-grow">
                            <!-- Votre liste déroulante des clients -->
                            <label for="eventCustomer_id" class="block mb-2 text-md font-medium text-gray-900 dark:text-white">Client :</label>
                            <div class="flex">
                                <select id="eventCustomer_id" name="eventCustomer_id" class="w-full text-md text-gray-900 border border-gray-300 rounded-l-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <?php foreach ($options_customers_id as $id => $Name) : ?>
                                        <option value="<?php echo $id; ?>"><?php echo $Name; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <button type="button" onclick="ShowCreateCustomer()" class="px-4 text-xl font-bold text-gray-900 border-l-0 border border-gray-300 rounded-r-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">+</button>
                            </div>
                        </div>
                    </div>
                    <div>
                        <!-- Votre liste déroulante de services -->
                        <label for="eventService_id" class="block mb-2 text-md font-medium text-gray-900 dark:text-white">Service :</label>
                        <select id="eventService_id" name="eventService_id" class="block w-full   text-md text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <?php foreach ($options_services_id as $id => $title) : ?>
                                <option value="<?php echo $id; ?>"><?php echo $title; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div date-rangepicker id="dateranger" class="flex items-center justify-between">

                        <div class="relative">
                            <label for="startEvent" class="absolute text-md text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-900 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">Début</label>
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                                </svg>
                            </div>
                            <input id="startEvent" name="startEvent" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Date de début">
                        </div>
                        <span class="mx-4 text-gray-500"> 
                            <svg class="w-4 h-4  dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9" />
                            </svg> 
                        </span>
                        <div class="relative">
                            <label for="eventEnd" class="absolute text-md text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-900 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">Fin</label>
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                                </svg>
                            </div>
                            <input id="eventEnd" name="eventEnd" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Date de fin">
                        </div>
                    </div>
                    <div class="relative">
                        <input type="number" pattern="[0-9]*" value="1" inputmode="numeric" id="eventQt" name="eventQt" class="block w-full text-md text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer">
                        <label for="eventQt" class="absolute text-md text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-900 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">Nombre de nuit</label>
                    </div>
                    <div class="relative">
                        <input type="number" pattern="[0-9]*" inputmode="numeric" id="eventPrice" name="eventPrice" class="block w-full  text-md text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required>
                        <label for="eventPrice" class="absolute text-md text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-900 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">Prix Total</label>

                        <span id="numericIndicator" class="text-base" style="color: red; display: none;"><br>Seules des valeurs numériques sont autorisées.</span>
                    </div>
                    <div class="relative">
                        <input type="number" pattern="[0-9]*" value=0 inputmode="numeric" id="eventPaid" name="eventPaid" class="block w-full text-md text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer">
                        <label for="eventPaid" class="absolute text-md text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-900 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">Encaissé</label>
                    </div>
                    <div>
                        <label for="eventComment" class="block mb-2 text-md font-medium text-gray-900 dark:text-white">Commentaire :</label>
                        <textarea id="eventComment" name="eventComment" class="block p-2.5 w-full text-md text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Une chose à dire, c'est ici..."></textarea>
                    </div>

                    <div class="flex justify-between ">
                        <button id="add_submit_form" onclick="addEvent();" type="button" class="w-full mr-2 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg  text-xl px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Enregistrer</button>
                        <button id="cancel_submit_form" onclick="closeModalById('addEventModal'); console.log(count_row_found);" type="submit" class="w-full ml-2 text-white bg-slate-700 hover:bg-slate-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg  text-xl px-5 py-2.5 text-center dark:bg-slate-600 dark:hover:bg-slate-700 dark:focus:ring-slate-800">Annuler</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php
$discountRulesJSON  = json_encode($discountRules);  ?>

<script>
        var discountRules = <?= $discountRulesJSON ?>;
        var qtInput = document.getElementById("eventQt");
        var serviceSelect = document.getElementById("eventService_id");
        var priceInput = document.getElementById("eventPrice");
        var numericIndicator = document.getElementById("numericIndicator");
        var userChangedPrice = false; // Flag pour suivre si l'utilisateur a modifié le prix


        // Mettre à jour le prix initial
        priceInput.value = prices[serviceSelect.value];

        // Mettre à jour le prix lorsque le service sélectionné change
        serviceSelect.addEventListener("change", function() {
            if (!userChangedPrice) { // Mettre à jour uniquement si l'utilisateur n'a pas modifié le prix
                priceInput.value = prices[this.value];
                updatePrice(); // Appeler la fonction de mise à jour du prix
            }
        });

        // Lorsque l'utilisateur modifie manuellement le prix
        priceInput.addEventListener("input", function() {
            userChangedPrice = true; // Indiquer que l'utilisateur a changé le prix
            numericIndicator.style.display = isNaN(this.value) ? "inline" : "none"; // Afficher/Cacher l'indicateur si la valeur n'est pas un nombre
        });


        // Fonction pour mettre à jour le prix en fonction de la quantité
        function updatePrice() {
            var qt = parseInt(qtInput.value);
            if (!isNaN(qt)) {
                var servicePrice = prices[serviceSelect.value];
                var discountPercentage = 0;

                // Parcourez le tableau des réductions pour trouver la réduction la plus proche
                var closestQty = null;
                for (var qty in discountRules) {
                    if (qt >= parseInt(qty) && (closestQty === null || parseInt(qty) > closestQty)) {
                        closestQty = parseInt(qty);
                    }
                }

                if (closestQty !== null) {
                    discountPercentage = discountRules[closestQty];
                }

                // Calculez le prix avec réduction
                var prixCalculé = servicePrice * (1 - discountPercentage / 100) * qt;

                priceInput.value = prixCalculé.toFixed(0); // Prix sans décimales
            } else {
                priceInput.value = ""; // Effacez le champ de prix si la quantité n'est pas un nombre valide
            }
        }
        // Réinitialiser le flag lorsque la quantité change
        qtInput.addEventListener("input", function() {
            userChangedPrice = false; // Réinitialiser le flag si l'utilisateur modifie la quantité
            updatePrice();

        });



</script>