<?php
$modal_id = "addEventModal";
?>
<div id="<?= $modal_id ?>-shadow_modal" class="fixed inset-0 bg-black opacity-50 hidden" onclick="closeModalById('<?= $modal_id ?>')"></div>

<!-- ADD EVENTS - Modal Container -->
<div id="<?= $modal_id ?>" tabindex="-1" aria-hidden="true" class="fixed min-w-fit max-w-md lg:max-w-lg flex flex-grow hidden top-0 overflow-scroll-y bg-white border border-gray-200 dark:bg-slate-800 dark:border-gray-800">
    <div class="relative  mx-auto">

        <!-- Modal Header -->
        <div id="addEventModal_header" class="px-6 py-6 lg:px-8 flex justify-between items-center">

            <div class="flex-grow text-center">
                <h3 id="addEventModal_title" class="text-center text-2xl font-bold text-gray-800 dark:text-white">Réservation</h3>
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

        <!-- Modal Form -->
        <div id="body_<?= $modal_id ?>" class="w-full px-6 py-6 lg:px-8 mb-20 rounded-lg">
            <form id="eventForm" class="space-y-6">
                <input type="hidden" id="Modaleventid" name="id">
                <input type="hidden" id="ModaleventTax" name="Tax">
                <input type="hidden" id="ModaleventFee" name="Fee">
                <div>
                    <div class="relative flex items-center justify-center text-white text-md font-bold">
                        <label for="ModaleventType_doc" class="flex items-center cursor-pointer overflow-hidden">
                            <!-- Le conteneur du toggle -->
                            <div class="relative">
                                <!-- Le toggle lui-même -->
                                <input type="checkbox" id="ModaleventType_doc" value="Devis" class="sr-only" onchange="updateToggleLabel()">
                                <!-- Le chemin du toggle -->
                                <div id="ModaleventType_doc_bgtoggle" class="block bg-gray-600 w-28 h-10 rounded-full shadow-inner shadow-slate-800"></div>
                                <!-- Le cercle à bouger -->
                                <div id="ModaleventType_doc_bgtoggleDot" class="dot absolute left-1 top-1 bg-white dark:bg-slate-700 w-8 h-8 rounded-full transition transform ">
                                    <div class="flex items-center justify-center h-full">
                                        <!-- Les étiquettes Devis et Facture -->
                                        <span class="relative ml-2 left-16 " id="label-devis">Devis</span>
                                        <span class="relative mr-2 right-16 opacity-0" id="label-facture">Facture</span>
                                    </div>
                                </div>
                            </div>
                        </label>
                    </div>

                </div>
                <script>
                    function updateToggleLabel(value = null) {
                        const isChecked = document.getElementById('ModaleventType_doc').checked;
                        document.getElementById('ModaleventType_doc').value = isChecked ? 'Facture' : 'Devis';
                        document.getElementById('ModaleventType_doc_bgtoggleDot').classList.add(!isChecked ? 'bg-white' : 'bg-blue-400');
                        document.getElementById('ModaleventType_doc_bgtoggleDot').classList.remove(isChecked ? 'bg-white' : 'bg-blue-400');
                        document.getElementById('label-devis').style.opacity = isChecked ? '0' : '100';
                        document.getElementById('label-facture').style.opacity = isChecked ? '100' : '0';
                    }
                </script>

                <!-- Customer id -->
                <div class="py-2 px-3 bg-white border border-gray-200 rounded-lg dark:bg-slate-900 dark:border-gray-700">
                    <div id="Modalevent_Container_Customer_id" class="w-full flex justify-between items-center gap-x-5">
                        <svg class="w-6 h-6 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" d="M12 20a8 8 0 0 1-5-1.8v-.6c0-1.8 1.5-3.3 3.3-3.3h3.4c1.8 0 3.3 1.5 3.3 3.3v.6a8 8 0 0 1-5 1.8ZM2 12a10 10 0 1 1 10 10A10 10 0 0 1 2 12Zm10-5a3.3 3.3 0 0 0-3.3 3.3c0 1.7 1.5 3.2 3.3 3.2 1.8 0 3.3-1.5 3.3-3.3C15.3 8.6 13.8 7 12 7Z" clip-rule="evenodd" />
                        </svg>
                        <div class="grow">
                            <select id="ModaleventCustomer_id" name="ModaleventCustomer_id" class="w-full py-1 bg-white border-0 rounded-lg dark:bg-slate-900" style="width:100%;">
                                <?php foreach ($options_customers_id as $id => $Name) : ?>
                                    <option value="<?php echo $id; ?>"><?php echo $Name; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>


                <!-- Input Number QtTraveller -->
                <div class="py-2 px-3 bg-white border border-gray-200 rounded-lg dark:bg-slate-900 dark:border-gray-700" data-hs-input-number>
                    <div class="w-full flex justify-between items-center gap-x-5">
                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 18">
                            <path d="M14 2a3.963 3.963 0 0 0-1.4.267 6.439 6.439 0 0 1-1.331 6.638A4 4 0 1 0 14 2Zm1 9h-1.264A6.957 6.957 0 0 1 15 15v2a2.97 2.97 0 0 1-.184 1H19a1 1 0 0 0 1-1v-1a5.006 5.006 0 0 0-5-5ZM6.5 9a4.5 4.5 0 1 0 0-9 4.5 4.5 0 0 0 0 9ZM8 10H5a5.006 5.006 0 0 0-5 5v2a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-2a5.006 5.006 0 0 0-5-5Z" />
                        </svg>
                        <div class="grow">
                            <span class="block text-xs text-gray-500 dark:text-gray-400">
                                Nombre de voyageur
                            </span>
                            <input id="ModaleventQtTraveller" class="w-full p-0 bg-transparent border-0 text-gray-800 focus:ring-0 dark:text-white
                        focus:outline-none" type="text" value="1" inputmode="numeric" pattern="[0-9]*" data-hs-input-number-input>
                        </div>
                        <div class="flex justify-end items-center gap-x-1.5">
                            <button type="button" class="w-6 h-6 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-full border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-white dark:hover:bg-gray-800 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" data-hs-input-number-decrement>
                                <svg class="flex-shrink-0 w-3.5 h-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M5 12h14" />
                                </svg>
                            </button>
                            <button type="button" class="w-6 h-6 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-full border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-white dark:hover:bg-gray-800 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" data-hs-input-number-increment>
                                <svg class="flex-shrink-0 w-3.5 h-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M5 12h14" />
                                    <path d="M12 5v14" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
                <!-- End Input Number -->



                <!-- Liste déroulante de services -->
                <div class="py-2 px-3 bg-white border border-gray-200 rounded-lg dark:bg-slate-900 dark:border-gray-700">
                    <div class="w-full flex justify-between items-center gap-x-5">
                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M5 7h14M5 12h14M5 17h14" />
                        </svg>
                        <div class="grow">
                            <select id="ModaleventService_id" name="ModaleventService_id" class="w-full py-1 bg-white border-0 rounded-lg text-gray-900 dark:text-gray-300 dark:bg-slate-900 ">
                                <?php foreach ($options_services_id as $id => $title) : ?>
                                    <option class="bg-white  dark:bg-slate-900" value="<?php echo $id; ?>"><?php echo $title; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <!-- Case à cocher -->
                        <div id="container_eventfullblocked" class="flex items-center w-fit p-2 bg-transparent   rounded-lg" onclick="toggleTooltip(this)">
                            <input disabled id="Modaleventfullblocked" name="Modaleventfullblocked" type="checkbox" class="w-4 h-4 text-red-600 bg-gray-100  rounded focus:ring-red-500 dark:focus:ring-red-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-slate-800">
                            <label for="Modaleventfullblocked" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Privatiser</label>
                            <span class="tooltiptext tooltip-hidden absolute bg-black text-white text-xs rounded py-1 px-2 z-10 left-1/2 transform  -translate-y-6">Sélectionner "Maison" pour privatiser</span>
                        </div>
                    </div>
                </div>


                <div date-rangepicker id="dateranger" class="py-2 px-3 bg-white border border-gray-200 rounded-lg dark:bg-slate-900 dark:border-gray-700" data-hs-input-number>
                    <div class="w-full flex justify-between items-center gap-x-5">
                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 8v10a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0Zm12 7h-1v1a1 1 0 0 1-2 0v-1H8a1 1 0 0 1 0-2h1v-1a1 1 0 1 1 2 0v1h1a1 1 0 0 1 0 2Z" />
                        </svg>

                        <div class="grow">
                            <span class="block text-xs text-gray-500 dark:text-gray-400">
                                Période
                            </span>
                            <input id="ModaleventDatepicker" class="w-full p-0 bg-transparent border-0 text-gray-800 focus:ring-0 dark:text-white
                        focus:outline-none" type="text" value="1" inputmode="numeric" pattern="[0-9]*" data-hs-input-number-input>
                        </div>
                        <div class="flex justify-end items-center gap-x-1.5">
                            <input hidden type="number" pattern="[0-9]*" value="1" inputmode="numeric" id="ModaleventQt" name="ModaleventQt">
                            <span class="flex flex-col justify-center items-center mx-4 text-gray-500">
                                <div id="ModaleventNights" class="flex text-center text-xs ">
                                    2 Nuits
                                </div>
                            </span>
                        </div>
                    </div>
                </div>


                <!-- Input Number -->
                <div class="py-2 px-3 bg-white border border-gray-200 rounded-t-lg dark:bg-slate-900 dark:border-gray-700" data-hs-input-number>
                    <div class="w-full flex justify-between items-center gap-x-5">

                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 17.3a5 5 0 0 0 2.6 1.7c2.2.6 4.5-.5 5-2.3.4-2-1.3-4-3.6-4.5-2.3-.6-4-2.7-3.5-4.5.5-1.9 2.7-3 5-2.3 1 .2 1.8.8 2.5 1.6m-3.9 12v2m0-18v2.2" />
                        </svg>
                        <div class="grow">
                            <span class="block text-xs text-gray-500 dark:text-gray-400">
                                Prix total
                            </span>
                            <input id="ModaleventPrice" class="w-full p-0 bg-transparent border-0 text-gray-800 focus:ring-0 dark:text-white
                        focus:outline-none" type="text" value="1" inputmode="numeric" pattern="[0-9]*" data-hs-input-number-input>
                        </div>
                        <!-- TODO, fix init value of increment && decrement
                        <div class="flex justify-end items-center gap-x-1.5">
                        <button type="button" class="w-6 h-6 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-full border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-white dark:hover:bg-gray-800 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" data-hs-input-number-decrement>
                            <svg class="flex-shrink-0 w-3.5 h-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/></svg>
                        </button>
                        <button type="button" class="w-6 h-6 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-full border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-white dark:hover:bg-gray-800 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" data-hs-input-number-increment>
                            <svg class="flex-shrink-0 w-3.5 h-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
                        </button>
                        </div>-->
                    </div>
                </div>
                <!-- End Input Number -->


                <div class="relative z-0">
                    <div id="totalIndicator" class="-mt-6 p-2 border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 rounded-b-lg border-t-0 text-sm text-slate-600 dark:text-slate-400"></div>
                    <div id="discountIndicator" class="-mt-2 p-2 border border-dashed border-gray-400 dark:border-yellow-600 bg-yellow-200 dark:bg-yellow-800 rounded-b-lg border-t-0 text-md text-yellow-500 dark:text-yellow-200 hidden"></div>
                    <div id="numericIndicator" class="absolute -top-4 left-0 text-sm text-red-600 hidden">Seules des valeurs numériques sont autorisées.</div>
                </div>



                <div id="payments-container" class="relative">
                    <div id="payments-subcontainer"></div>
                </div>
                <div class="flex justify-end">
                    <div onclick="addPaymentRow()" class="flex w-fit p-2 cursor-pointer rounded-lg text-gray-600 dark:text-white bg-slate-400 hover:bg-slate-300 focus:ring-4 focus:ring-slate-300 font-medium text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-slate-600 dark:hover:bg-slate-500 focus:outline-none dark:focus:ring-slate-800 shadow-sm dark:shadow-black" style="margin-top: 0.5rem;">Ajouter un encaissement</div>
                </div>
                <div position="relative">
                    <label for="ModaleventComment" class="block mb-2 text-md font-medium text-gray-900 dark:text-white">Commentaire :</label>
                    <textarea id="ModaleventComment" name="ModaleventComment" class="block p-2.5 w-full text-md text-gray-900 bg-gray-50 rounded-lg border border-gray-300  dark:bg-slate-800 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Une chose à dire, c'est ici..."></textarea>
                </div>

                <button type="button" id="cancel_submit_form" type="button" onclick="closeModalById('<?= $modal_id ?>');" class="sticky bottom-4 float-left mt-10 text-gray-600 dark:text-gray-200 bg-slate-200 hover:bg-gray-300 focus:ring-4 focus:ring-gray-300 font-bold rounded-full text-md px-5 py-2.5 mr-2 mb-2 dark:bg-gray-600 dark:hover:bg-slate-800 focus:outline-none dark:focus:ring-gray-800 border-gray-500 shadow-xl shadow-gray-600">Annuler</button>
                <button type="button" id="add_submit_form" type="button" onclick="addEvent();" class="sticky bottom-4 float-right mt-10 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-bold rounded-full text-md px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 border border-blue-500 shadow-xl shadow-blue-600">Enregistrer</button>

            </form>


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
    document.getElementById('ModaleventNights').innerText = document.getElementById('ModaleventQt').value + ' Nuit(s)';
    // CATCHING elementID:
    var eventFull_Blocked = document.getElementById("Modaleventfullblocked");
    var container_full_blocked = document.getElementById("container_eventfullblocked");
    var container_global = document.getElementById("addEventModal");
    var checkbox = document.getElementById('Modaleventfullblocked');
    var Datepicker = document.getElementById('ModaleventDatepicker');

    var discountScope = '<?= $DiscountsScope ?>';
    var GlobaldiscountValues = <?= $DiscountsValues !== false ? $DiscountsValues : "'false'" ?>;
    var Discount_type = '<?= $DiscountsType ?>';
    var qtInput = document.getElementById("ModaleventQt");
    var serviceSelect = document.getElementById("ModaleventService_id");
    var priceInput = document.getElementById("ModaleventPrice");
    var discountIndicator = document.getElementById("discountIndicator");
    var totalIndicator = document.getElementById("totalIndicator");
    var userChangedPrice = false; // Flag pour suivre si l'utilisateur a modifié le prix
    var discountservice = <?= $DiscountServices ?>;
    var serviceDiscount = false;
    var E_Fee = document.getElementById('ModaleventFee');
    var E_Tax = document.getElementById('ModaleventTax');

    let service;

    // PAYMENT ROW

    function addPaymentRow() {
        // Simplifier la génération d'ID unique
        const uniqueID = `temp_${Date.now().toString(36)}_${Math.random().toString(36).substr(2, 5)}`;

        // Optimiser l'accès au DOM en minimisant le nombre de requêtes
        const modaleventQt = document.getElementById("ModaleventQt");
        const modaleventQtTraveller = document.getElementById("ModaleventQtTraveller");
        const priceInput = document.getElementById("ModaleventPrice"); // Assurez-vous que cet ID est correct

        const qt = parseInt(modaleventQt ? modaleventQt.value : 0, 10);
        const qtTraveller = parseInt(modaleventQtTraveller ? modaleventQtTraveller.value : 0, 10);
        const price = parseInt(priceInput ? priceInput.value : 0, 10);
        const serviceTax = parseInt(service.Tax, 10); // Assurez-vous que 'service' est défini
        const serviceFee = parseInt(service.Fee, 10); // et accessible

        // Calcul du total déjà payé
        let sum = Array.from(document.querySelectorAll('input[id^="rowPaid"]'))
            .filter(input => input.type !== 'hidden') // Filtrer pour exclure les inputs de type 'hidden'
            .reduce((acc, input) => acc + Number(input.value), 0);

        // Calcul du montant à remplir
        let fillPaidInput = !isNaN(price) && !isNaN(qtTraveller) ?
            (price + (qtTraveller * serviceTax * qt) + serviceFee) - sum : 0;

        if (fillPaidInput === 0) {
            return;
        }
        // Construction de la nouvelle ligne de paiement
        const newPaymentRow = `
            <div class="flex payment-row mt-1" id="${uniqueID}">
                <div class="inline-flex items-center w-fit bg-red-50 border border-red-300 hover:bg-red-400 dark:bg-red-700 dark:hover:bg-red-900 rounded-lg mx-1 my-0.5 p-2 cursor-pointer" onclick="Deletepaid('${uniqueID}')"> X </div>
                <input type="hidden" id="rowPaidid${uniqueID}" name="rowPaidid${uniqueID}">
                <select id="rowPaidType${uniqueID}" name="rowPaidType${uniqueID}" class="inline-flex rounded-l-lg items-center py-2.5 px-4 text-sm font-bold text-center text-gray-500 bg-gray-100 border border-gray-300 hover:bg-gray-200 dark:bg-slate-800 dark:hover:bg-gray-600 dark:text-white dark:border-gray-600 focus:ring-4 focus:outline-none focus:ring-gray-100 dark:focus:ring-slate-800">
                    <option value="ESPECE">ESPECE</option>
                    <option value="VIREMENT">VIREMENT</option>
                    <option value="VISA">VISA</option>
                    <option value="AMEX">AMEX</option>
                    <option value="CHEQUE">CHEQUE</option>
                </select>
                <input type="number" pattern="[0-9]*" value="${fillPaidInput}" inputmode="numeric" id="rowPaid${uniqueID}" name="rowPaid${uniqueID}" class="block w-full rounded-r-lg py-2 px-3 bg-white border border-gray-200 dark:bg-slate-900 dark:border-gray-700 text-gray-800 dark:text-white focus:ring-4 focus:outline-none focus:ring-gray-100 dark:focus:ring-slate-800">
            </div>
        `;

        document.getElementById('payments-subcontainer').insertAdjacentHTML('beforeend', newPaymentRow);
    }


    // Déclaration globale des variables pour une meilleure visibilité
    // Fonction pour mettre à jour les informations totales
    function updateTotalInfo() {
        // Accès au DOM optimisé
        const modaleventQtTraveller = document.getElementById("ModaleventQtTraveller");
        const modaleventQt = document.getElementById("ModaleventQt");
        const priceInput = document.getElementById("ModaleventPrice"); // Assurez-vous que cet ID est correct
        const totalIndicator = document.getElementById("totalIndicator"); // Assurez-vous que cet ID est correct
        const numericIndicator = document.getElementById("numericIndicator"); // Assurez-vous que cet ID est correct

        // Validation et conversion des valeurs
        const qtTraveller = parseInt(modaleventQtTraveller ? modaleventQtTraveller.value : 0);
        const price = parseInt(priceInput ? priceInput.value : 0);
        const nDays = parseInt(modaleventQt ? modaleventQt.value : 0);
        const serviceTax = parseInt(service ? service.Tax : 0);
        const serviceFee = parseInt(service ? service.Fee : 0);
        console.log("price", price);
        let total = 0;
        if (!isNaN(price) && !isNaN(qtTraveller) && !isNaN(serviceTax) && !isNaN(serviceFee) && !isNaN(nDays)) {
            // Calcul du prix total
            total = price + (qtTraveller * serviceTax * nDays) + serviceFee;
        }

        // Mise à jour de l'affichage total
        if (totalIndicator) {
            totalIndicator.innerHTML = `
            <div class="flex justify-between font-normal text-xs text-slate-400 dark:text-slate-100">
                <div class="flex-grow">
                    <div><b>Tarif réservation:</b> ${price.toLocaleString('fr-FR')} Fr</div>
                    <div><b>Taxe de séjour:</b> ${qtTraveller} Personne(s) * ${nDays} jour(s) * ${serviceTax} Fr</div>
                    <div><b>Frais de ménage:</b> ${serviceFee.toLocaleString('fr-FR')} Fr</div>
                </div>
                <div class="flex-col ml-2">
                    <div class="text-right text-sm whitespace-nowrap">TOTAL</div>           
                    <div class="text-right text-lg whitespace-nowrap">${total.toLocaleString('fr-FR')} Fr</div>
                </div>
            </div>`;
        }

        if (numericIndicator) {
            numericIndicator.style.display = (isNaN(price) || isNaN(qtTraveller)) ? "inline" : "none";
        }
    }


    function loadServiceDetails(serviceId) {

        service = discountservice.find(s => s.Service_id === serviceId);
        // MàJ datepicker
        if (fromServicepicker) {
            loadAndInitDatepicker(serviceId);
        }

        serviceDiscount = service.Discount;

        //UPDATE UI:    

        // MàJ Total
        priceInput.value = prices[serviceId];
        E_Fee.value = parseInt(service.Fee);
        E_Tax.value = parseInt(service.Tax);

        // MàJ Privatisation
        if (service.fullblocked == 1) {
            checkbox.checked = true;
            container_full_blocked.classList.add("bg-red-500");
            container_full_blocked.classList.remove("bg-transparent");
            container_global.classList.add('border', 'border-dashed', 'border-4', 'border-red-300');
            container_global.classList.add('dark:border-red-800');
        } else {
            checkbox.checked = false;
            container_full_blocked.classList.remove("bg-red-500");
            container_global.classList.remove('border', 'border-dashed', 'border-4', 'border-red-300');
            container_global.classList.remove('dark:border-red-800');
        }

        if (!userChangedPrice) {
            priceInput.value = prices[serviceId];
            updateTotalInfo(); // Mettre à jour le total après avoir changé le service
        }
    }


    // Attacher des écouteurs d'événements aux éléments
    document.getElementById("ModaleventPrice").addEventListener("change", function() {
        userChangedPrice = true;
        updateTotalInfo();
    });
    document.getElementById("ModaleventQtTraveller").addEventListener("change", updateTotalInfo);
    serviceSelect.addEventListener("change", function() {
        loadServiceDetails(this.value);
    });

    // Initialiser les valeurs par défaut
    loadServiceDetails(serviceSelect.value);

    // Fonction pour obtenir la réduction la plus proche en fonction de la quantité
    function getClosestDiscount(discountValues, quantity) {
        let closestQty = null;
        let discountValue = null;

        for (let qty in discountValues) {
            if (quantity >= parseInt(qty) && (closestQty === null || parseInt(qty) > closestQty)) {
                closestQty = parseInt(qty);
                discountValue = discountValues[closestQty];
            }
        }

        return {
            closestQty,
            discountValue
        };
    }

    // Fonction pour calculer le prix avec réduction
    function calculateDiscountedPrice(qt, servicePrice, discountValue, discountType) {
        if (discountValue > 0) {
            if (discountType == "Pourcentage") {
                return (servicePrice * qt) * (1 - discountValue / 100);
            } else if (discountType == "Fixe") {
                return discountValue * qt;
            }
        } else {
            return servicePrice * qt; // Retourner le prix sans réduction si le type de réduction n'est pas reconnu
        }
    }

    // Fonction pour mettre à jour le prix en fonction de la quantité
    function updatePrice() {
        const qt = parseInt(qtInput.value);
        let prixCalculé = 0;
        const selected_service = discountservice.find(service => service.Service_id === serviceSelect.value);

        if (!isNaN(qt) && selected_service) {
            // PRIX de la résa
            const servicePrice = prices[serviceSelect.value];
            // Get : Discount configuration or Discount Services -> OBJ
            let discountValues = discountScope == "Global" ? GlobaldiscountValues : /* Unit */ discountToArray(serviceDiscount);
            // Get : La discount la plus proche -> OBJ
            let closestDiscount = getClosestDiscount(discountValues, qt);

            let prixCalculé = calculateDiscountedPrice(qt, servicePrice, closestDiscount.discountValue, Discount_type);
            if (closestDiscount.discountValue > 0) {
                discountIndicator.style.display = "block";
                discountIndicator.innerHTML = `
        <div class="flex justify-between">
            <div class="absolute" style="left: 85%">
                <svg class="w-10 h-10 text-yellow-300 mt-1 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M13.8 4.2a2 2 0 0 0-3.6 0L8.4 8.4l-4.6.3a2 2 0 0 0-1.1 3.5l3.5 3-1 4.4c-.5 1.7 1.4 3 2.9 2.1l3.9-2.3 3.9 2.3c1.5 1 3.4-.4 3-2.1l-1-4.4 3.4-3a2 2 0 0 0-1.1-3.5l-4.6-.3-1.8-4.2Z"/>
                </svg>
            </div>
            <div class="flex-grow">
                <div class="">
                    <b>Tarif par nuit:</b> <span class="text-orange">${Discount_type == 'Pourcentage' ? closestDiscount.discountValue + '%' : closestDiscount.discountValue.toLocaleString('fr-FR')}  Fr</span> &nbsp; <span class="text-xs line-through">${servicePrice.toLocaleString('fr-FR')} Fr</span> 
                </div>
                <div class="">
                    <b> Quantité:</b> >= ${closestDiscount.closestQty} Nuits
                </div>
            </div>
        </div>`;

            } else {
                discountIndicator.style.display = "none";
            }

            priceInput.value = prixCalculé.toFixed(0).toLocaleString('fr-FR');; // Prix sans décimales
        } else {
            priceInput.value = ""; // Effacez le champ de prix si la quantité n'est pas un nombre valide
        }
        updateTotalInfo();
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


    var fromServicepicker; // Déclare la variable à l'extérieur de la fonction pour qu'elle ait une portée globale.

    var serviceSelect = document.getElementById('ModaleventService_id');

    // Ajoutez un écouteur d'événements pour réagir aux changements de sélection
    serviceSelect.addEventListener('change', function() {
        // Vérifiez si le datepicker a déjà été initialisé et détruisez-le si c'est le cas
        if (fromServicepicker) {
            fromServicepicker = ""; // Assurez-vous que la méthode `destroy` est bien définie par Easepick pour détruire l'instance
        }

        updateTotalInfo();
        updatePrice();

    });

    //TOOLTIP (beaucop de code pour peu...)
    function toggleTooltip(element) {
        var tooltip = element.querySelector('.tooltiptext');
        var isTooltipHidden = tooltip.classList.contains('tooltip-hidden');
        // Fermer toutes les tooltips ouvertes
        document.querySelectorAll('.tooltiptext').forEach(function(el) {
            el.classList.add('tooltip-hidden');
        });
        // Afficher la tooltip actuelle si elle était cachée
        if (isTooltipHidden) {
            tooltip.classList.remove('tooltip-hidden');
        }

    }

    document.addEventListener('touchstart', function(event) {
        if (!document.getElementById('container_eventfullblocked').contains(event.target)) {
            document.querySelectorAll('.tooltiptext').forEach(function(el) {
                el.classList.add('tooltip-hidden');
            });
        }
    });

    document.addEventListener('click', function(event) {
        if (!document.getElementById('container_eventfullblocked').contains(event.target)) {
            document.querySelectorAll('.tooltiptext').forEach(function(el) {
                el.classList.add('tooltip-hidden');
            });
        }
    });
</script>