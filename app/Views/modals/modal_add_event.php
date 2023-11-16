<?php
$modal_id = "addEventModal";


?>
<!-- ADD EVENTS - Modal Container -->
<div id="<?= $modal_id ?>" tabindex="-1" aria-hidden="true" class="fixed w-full h-[calc(100vh)] hidden z-50 overflow-auto ">
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

            <div class="px-6 py-6 lg:px-8 mb-20">
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
                                <select id="eventCustomer_id" name="eventCustomer_id" class="w-full text-md text-gray-900 border border-gray-300 rounded-l-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" style="width:100%;">
                                    <?php foreach ($options_customers_id as $id => $Name) : ?>
                                        <option value="<?php echo $id; ?>"><?php echo $Name; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="relative flex">
                            <span class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 border rounded-e-0 border-gray-300 rounded-s-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">
                                
                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 18">
                                    <path d="M14 2a3.963 3.963 0 0 0-1.4.267 6.439 6.439 0 0 1-1.331 6.638A4 4 0 1 0 14 2Zm1 9h-1.264A6.957 6.957 0 0 1 15 15v2a2.97 2.97 0 0 1-.184 1H19a1 1 0 0 0 1-1v-1a5.006 5.006 0 0 0-5-5ZM6.5 9a4.5 4.5 0 1 0 0-9 4.5 4.5 0 0 0 0 9ZM8 10H5a5.006 5.006 0 0 0-5 5v2a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-2a5.006 5.006 0 0 0-5-5Z"/>
                                </svg>
                            </span>
                            <input type="number" pattern="[0-9]*" value="1" inputmode="numeric" id="eventQtTraveller" name="eventQtTraveller" class="block w-full  rounded-none rounded-e-lg text-md text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer">
                            <label for="eventQtTraveller" class="absolute ml-10 text-md text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-700 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">Nombre de voyageur</label>
                        </div>

                        <!-- Liste déroulante de services -->

                        <label for="eventService_id" class="block mb-2 text-md font-medium text-gray-900 dark:text-white">Service :</label>
                        <select id="eventService_id" name="eventService_id" class="block w-full text-md text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <?php foreach ($options_services_id as $id => $title) : ?>
                                <option value="<?php echo $id; ?>"><?php echo $title; ?></option>
                            <?php endforeach; ?>
                        </select>


                        <!-- Case à cocher -->
                        <div id="container_eventFull_Blocked" class="w-fit mt-2 p-2 bg-transparent border border-red-200 dark:border-red-900 rounded-lg">
                            <input id="eventFull_Blocked" name="eventFull_Blocked" type="checkbox" class="w-4 h-4 text-red-600 bg-gray-100 border-gray-300 rounded focus:ring-red-500 dark:focus:ring-red-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="eventFull_Blocked" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Privatiser</label>
                        </div>
                    </div>
                    <div date-rangepicker id="dateranger" class="flex items-center justify-between">
                        <div class="relative">
                            <label for="startEvent" class="absolute text-md text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-700 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">Début</label>
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
                            <label for="eventEnd" class="absolute text-md text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-700 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">Fin</label>
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
                        <label for="eventQt" class="absolute text-md text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-700 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">Nombre de nuit</label>
                    </div>
                    <div class="relative">
                        <input type="number" pattern="[0-9]*" inputmode="numeric" id="eventPrice" name="eventPrice" class="block w-full  text-md text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required>
                        <label for="eventPrice" class="absolute text-md text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-700 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">Prix Total</label>

                        <span id="discountIndicator" class="text-base" style="color: orange; display: none;">Discount status</span>
                        <span id="numericIndicator" class="text-base" style="color: red; display: none;"><br>Seules des valeurs numériques sont autorisées.</span>
                    </div>
                    <div class="relative">
                        <input type="number" pattern="[0-9]*" value=0 inputmode="numeric" id="eventPaid" name="eventPaid" class="block w-full text-md text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer">
                        <label for="eventPaid" class="absolute text-md text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-700 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">Encaissé</label>
                    </div>

                    <div class="flex">


                    <select id="eventPaids_row" name="eventPaids_row" class="inline-flex items-center py-2.5 px-4 text-sm font-medium text-center text-gray-500 bg-gray-100 border border-gray-300 rounded-s-lg hover:bg-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 dark:focus:ring-gray-700 dark:text-white dark:border-gray-600" type="button">
                                <option value="ESPECE">ESPECE</option>
                                <option value="VIREMENT">VIREMENT</option>
                                <option value="VISA">VISA</option>
                                <option value="AMEX">AMEX</option>
                                <option value="CHEQUE">CHEQUE</option>
                        </select>
    
    <input type="number" pattern="[0-9]*" value=0 inputmode="numeric" id="eventPaid" name="eventPaid" 
    class="rounded-e-lg block w-full text-md text-gray-900 bg-transparent border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer">
    <label for="eventPaid" class="absolute text-md text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-700 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">Encaissé</label>
</div>

                    <div>
                        <label for="eventComment" class="block mb-2 text-md font-medium text-gray-900 dark:text-white">Commentaire :</label>
                        <textarea id="eventComment" name="eventComment" class="block p-2.5 w-full text-md text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Une chose à dire, c'est ici..."></textarea>
                    </div>

                    <button type="button" id="cancel_submit_form" type="button" onclick="closeModalById('<?= $modal_id ?>');" class="sticky bottom-10 float-left mt-10 text-white bg-gray-700 hover:bg-gray-800 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-gray-600 dark:hover:bg-gray-700 focus:outline-none dark:focus:ring-gray-800 shadow-xl  z-50">Annuler</button>
                    <button type="button" id="add_submit_form" type="button" onclick="addEvent();" class="sticky bottom-10 float-right mt-10 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 shadow-xl z-50">Enregistrer</button>

                </form>


            </div>
        </div>
    </div>
</div>
<?php
$DiscountServices = json_encode($services_list);
$DiscountsValues = DiscountToArray($discountRules['Rules']['Data']) ? json_encode(DiscountToArray($discountRules['Rules']['Data'])) : false;
$DiscountsType = $discountRules['Type']['Data'];
$DiscountsScope = $discountRules['Scope']['Data'];
?>
<script>
    var eventFull_Blocked = document.getElementById("eventFull_Blocked");
    eventFull_Blocked.addEventListener("change", function() {
        var container_full_blocked = document.getElementById("container_eventFull_Blocked");
        if (eventFull_Blocked.checked) {
            // Appliquer un style lorsque la checkbox est cochée
            container_full_blocked.style.backgroundColor = "red"; // Exemple : Fond vert
            // Vous pouvez également changer le style d'autres éléments ici
        } else {
            // Appliquer un style différent lorsque la checkbox n'est pas cochée
            container_full_blocked.style.backgroundColor = "transparent"; // Exemple : Fond rouge
            // Vous pouvez également réinitialiser le style d'autres éléments ici
        }
    });

    var discountScope = '<?= $DiscountsScope ?>';
    var GlobaldiscountValues = <?= $DiscountsValues !== false ? $DiscountsValues : "'false'" ?>;
    var Discount_type = '<?= $DiscountsType ?>';
    var qtInput = document.getElementById("eventQt");
    var serviceSelect = document.getElementById("eventService_id");
    var priceInput = document.getElementById("eventPrice");
    var discountIndicator = document.getElementById("discountIndicator");
    var numericIndicator = document.getElementById("numericIndicator");
    var userChangedPrice = false; // Flag pour suivre si l'utilisateur a modifié le prix
    var discountservice = <?= $DiscountServices ?>;
    var serviceDiscount = false;

    // Mettre à jour le prix initial
    priceInput.value = prices[serviceSelect.value];
    service = discountservice.find(service => service.Service_id === serviceSelect.value);
    serviceDiscount = service.Discount;
    // Mettre à jour le prix lorsque le service sélectionné change
    serviceSelect.addEventListener("change", function() {
        //Get service détails from select
        service = discountservice.find(service => service.Service_id === this.value);

        loadAndInitDatepicker(this.value);
        if (!userChangedPrice) { // Mettre à jour uniquement si l'utilisateur n'a pas modifié le prix
            priceInput.value = prices[this.value];
            updatePrice(); // Appeler la fonction de mise à jour du prix
        }
        serviceDiscount = service.Discount;
    });
    
    
    // Lorsque l'utilisateur modifie manuellement le prix
    priceInput.addEventListener("input", function() {
        userChangedPrice = true; // Indiquer que l'utilisateur a changé le prix
        numericIndicator.style.display = isNaN(this.value) ? "inline" : "none"; // Afficher/Cacher l'indicateur si la valeur n'est pas un nombre
    });
    
    
    // Fonction pour mettre à jour le prix en fonction de la quantité
    function updatePrice() {
        
        var qt = parseInt(qtInput.value);
        var prixCalculé = 0;
        if (!isNaN(qt)) {
            var servicePrice = prices[serviceSelect.value];
            var discountValue = 0;
            
            if(discountScope == "Both" ){
                // Initialisation des variables.
                var discountValues;
                var prixUnitaireAvecReduction;
                
                // Appliquez d'abord la réduction unitaire.
                if (serviceDiscount) {
                    discountValues = discountToArray(serviceDiscount);
                    // Trouvez la réduction unitaire la plus proche.
                    var closestUnitQty = null;
                    for (var qty in discountValues) {
                        if (qt >= parseInt(qty) && (closestUnitQty === null || parseInt(qty) > closestUnitQty)) {
                            closestUnitQty = parseInt(qty);
                        }
                    }
                    
                    // Calculez le prix unitaire avec réduction.
                    if (closestUnitQty !== null) {
                        var unitDiscountValue = discountValues[closestUnitQty];
                        
                        if (Discount_type == "Pourcentage") {
                            prixUnitaireAvecReduction = servicePrice * (1 - unitDiscountValue / 100);
                        } else if (Discount_type == "Fixe") {
                            prixUnitaireAvecReduction = unitDiscountValue * qt;
                        }
                    } else {

                        prixUnitaireAvecReduction = servicePrice * qt;
                    }
                    
                } else {
                    prixUnitaireAvecReduction = servicePrice * qt;
                }
                
                // Appliquez ensuite la réduction globale sur le total.
                if (GlobaldiscountValues) {
                    discountValues = discountToArray(serviceDiscount);
                    console.log('GlobaldiscountValues Both')
                    
                    // Trouvez la réduction unitaire la plus proche.
                    var closestUnitQty = null;
                    for (var qty in discountValues) {
                        if (qt >= parseInt(qty) && (closestUnitQty === null || parseInt(qty) > closestUnitQty)) {
                            closestUnitQty = parseInt(qty);
                        }
                    }
                    
                    // Calculez le prix unitaire avec réduction.
                    if (closestUnitQty !== null) {
                        console.log('closestUnitQty OK')
                        var unitDiscountValue = discountValues[closestUnitQty];
                        
                        if (Discount_type == "Pourcentage") {
                            prixCalculé = prixUnitaireAvecReduction * (1 - unitDiscountValue / 100);
                        } else if (Discount_type == "Fixe") {

                            prixCalculé = (prixUnitaireAvecReduction * qt)  - unitDiscountValue ;
                        }
                    }
                    else{
                        prixCalculé = prixUnitaireAvecReduction;

                    }
                } else {
                    prixCalculé = prixUnitaireAvecReduction;
                }

            }
                
            else if(discountScope == "Unit" || discountScope == "Global" ){
                // Déclaration initiale des variables.
                var discountValues;
                
                // Détermine les valeurs de réduction en fonction du contexte de remise.
                if (serviceDiscount && discountScope == "Unit") {
                    discountValues = discountToArray(serviceDiscount);
                } else if (GlobaldiscountValues && discountScope == "Global") {
                    discountValues = GlobaldiscountValues;
                }
                
                // Calcul du prix si des réductions sont applicables.
                if (discountValues) {
                    // Simplification de l'affectation de discountValues.
                    discountValues = discountScope == "Global" ? GlobaldiscountValues : discountToArray(serviceDiscount);
                    
                    // Trouver la quantité la plus proche pour laquelle une réduction est applicable.
                    var closestQty = null;
                    for (var qty in discountValues) {
                        if (qt >= parseInt(qty) && (closestQty === null || parseInt(qty) > closestQty)) {
                            closestQty = parseInt(qty);
                        }
                    }
                    
                    // Application de la réduction si une quantité appropriée est trouvée.
                    if (closestQty !== null) {
                        var discountValue = discountValues[closestQty];

                        // Calcul du prix avec réduction basé sur le type de réduction.
                        if (Discount_type == "Pourcentage") {
                            prixCalculé = (servicePrice * qt) * (1 - discountValue / 100);
                        } else if (Discount_type == "Fixe") {
                            if(discountScope == "Global"){
                                prixCalculé = (servicePrice * qt) - discountValue;
                            }else{
                                prixCalculé = discountValue * qt;
                            }
                        }
                    } else {
                        // Prix sans réduction.
                        prixCalculé = servicePrice * qt;
                    }
                    
                            discountIndicator.style.display = discountValue > 0 ? "inline" : "none"; // Afficher/Cacher l'indicateur si la valeur n'est pas un nombre
                            discountIndicator.innerHTML = `Total des réduction: ${Discount_type == 'Pourcentage' ? discountValue + '%': '-'+discountValue}  Fr` ; 
                } else {
                    // Prix standard si aucune réduction n'est disponible.
                    prixCalculé = servicePrice * qt;
                }
            }
            else {
                
                prixCalculé = servicePrice * qt;
            }
            
                
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

    function discountToArray(input) {
        let result = {};
        let lines = input.trim().split("\n");

        for (let line of lines) {
            let [keyStr, valueStr] = line.split(":");
            let key = parseInt(keyStr.trim(), 10);
            let value = parseInt(valueStr.trim().replace('%', ''), 10);
            result[key] = value;
        }

        return result;
    }
</script>