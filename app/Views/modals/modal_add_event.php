<?php
$modal_id = "addEventModal";
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
                <form id="eventForm" class="space-y-6">
                    <input type="hidden" id="Modaleventid" name="id">
                    <input type="hidden" id="ModaleventTax" name="Tax">
                    <input type="hidden" id="ModaleventFee" name="Fee">
                    <div>
                        <select id="ModaleventType_doc" name="ModaleventType_doc" class="block w-full p-4 text-xl font-bold text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-slate-800 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="Devis" selected>Devis</option>
                            <option value="Facture">Facture</option>
                        </select>
                    </div>

                    <div class="flex w-full items-center">
                        <div class="flex-grow">
                            <!-- Votre liste déroulante des clients -->
                            <div id="Modalevent_Container_Customer_id" class="flex">
                                <span class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 border rounded-e-0 border-gray-300 rounded-s-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">
                                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 18">
                                        <path fill-rule="evenodd" d="M12 20a8 8 0 0 1-5-1.8v-.6c0-1.8 1.5-3.3 3.3-3.3h3.4c1.8 0 3.3 1.5 3.3 3.3v.6a8 8 0 0 1-5 1.8ZM2 12a10 10 0 1 1 10 10A10 10 0 0 1 2 12Zm10-5a3.3 3.3 0 0 0-3.3 3.3c0 1.7 1.5 3.2 3.3 3.2 1.8 0 3.3-1.5 3.3-3.3C15.3 8.6 13.8 7 12 7Z" clip-rule="evenodd"/>
                                    </svg>
                                </span>                               
                                <select id="ModaleventCustomer_id" name="ModaleventCustomer_id" class="w-full text-md text-gray-900 border border-gray-300 rounded-l-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-slate-800 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" style="width:100%;">
                                    <?php foreach ($options_customers_id as $id => $Name) : ?>
                                        <option value="<?php echo $id; ?>"><?php echo $Name; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            
                            </div>
                        </div>
                    </div>
  
                    <div class="relative flex">
                        
                        <span class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 border rounded-e-0 border-gray-300 rounded-s-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">
                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 18">
                                <path d="M14 2a3.963 3.963 0 0 0-1.4.267 6.439 6.439 0 0 1-1.331 6.638A4 4 0 1 0 14 2Zm1 9h-1.264A6.957 6.957 0 0 1 15 15v2a2.97 2.97 0 0 1-.184 1H19a1 1 0 0 0 1-1v-1a5.006 5.006 0 0 0-5-5ZM6.5 9a4.5 4.5 0 1 0 0-9 4.5 4.5 0 0 0 0 9ZM8 10H5a5.006 5.006 0 0 0-5 5v2a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-2a5.006 5.006 0 0 0-5-5Z" />
                            </svg>
                        </span>
                        <input type="number" pattern="[0-9]*" value="1" inputmode="numeric" id="ModaleventQtTraveller" name="ModaleventQtTraveller" class="block w-full rounded-e-lg text-md text-gray-900 bg-transparent rounded-r-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer">
                        <label for="ModaleventQtTraveller" class="absolute ml-10 text-md text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-slate-800 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">Nombre de voyageur</label>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <!-- Liste déroulante de services -->
                        <div class="flex flex-grow">
                        <span class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 border rounded-e-0 border-gray-300 rounded-s-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">
                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 18">
                                <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M5 7h14M5 12h14M5 17h14"/>
                            </svg>
                        </span>
                        
                            <select id="ModaleventService_id" name="ModaleventService_id" class="block w-full text-md text-gray-900 rounded-e-lg text-md bg-transparent rounded-r-lg border-1 border-gray-300 appearance-none dark:text-white dark:bg-slate-700 dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer cursor-pointer">
                                <?php foreach ($options_services_id as $id => $title) : ?>
                                    <option value="<?php echo $id; ?>"><?php echo $title; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Case à cocher -->
                        <div id="container_eventfullblocked" class="flex ml-4 w-fit p-2 bg-transparent border border-gray-200 dark:border-red-900 rounded-lg"  onclick="toggleTooltip(this)">
                            <input disabled id="Modaleventfullblocked" name="Modaleventfullblocked" type="checkbox" class="w-4 h-4 text-red-600 bg-gray-100 border-gray-300 rounded focus:ring-red-500 dark:focus:ring-red-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-slate-800 dark:border-gray-600">
                            <label for="Modaleventfullblocked" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Privatiser</label>
                            <span class="tooltiptext tooltip-hidden absolute bg-black text-white text-xs rounded py-1 px-2 z-10 left-1/2 transform  -translate-y-6">Sélectionner "Maison" pour privatiser</span>
                        </div>
                    </div>

                    <div date-rangepicker id="dateranger" class="flex items-center justify-between">
                        <div class="relative">
                            <label for="ModaleventStart" class="absolute text-md text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-slate-800 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">Début</label>
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                                </svg>
                            </div>
                            <input id="ModaleventStart" name="ModaleventStart" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5  dark:bg-slate-800 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 cursor-pointer" placeholder="Date de début">
                        </div>
                        <span class="mx-4 text-gray-500">
                            <svg class="w-4 h-4  dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9" />
                            </svg>
                        </span>
                        <div class="relative">
                            <label for="ModaleventEnd" class="absolute text-md text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-slate-800 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">Fin</label>
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                                </svg>
                            </div>
                            <input id="ModaleventEnd" name="ModaleventEnd" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5  dark:bg-slate-800 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 cursor-pointer" placeholder="Date de fin">
                        </div>
                    </div>
                    <div class="relative pt-2">
                        <input disabled type="number" pattern="[0-9]*" value="1" inputmode="numeric" id="ModaleventQt" name="ModaleventQt" class="block w-full text-md text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer">
                        <label for="ModaleventQt" class="absolute text-md text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-slate-800 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">Nombre de nuit</label>
                    </div>
                    
                    <div class="relative z-10 shadow-sm">
                        <input type="number" pattern="[0-9]*" inputmode="numeric" id="ModaleventPrice" name="ModaleventPrice" class="block w-full  text-md text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="" required>
                        <label for="ModaleventPrice" class="absolute text-md text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-slate-800 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">Prix Total</label>
                    </div>    
                    
                    <div class="relative z-0">
                        <div id="totalIndicator" class="-mt-7 p-2 border border-dashed border-gray-400 dark:border-gray-600 bg-gray-50 dark:bg-gray-800 rounded-b-lg border-t-0 text-sm text-slate-600 dark:text-slate-400"></div>
                        <div id="discountIndicator" class="-mt-2 p-2 border border-dashed border-gray-400 dark:border-yellow-600 bg-yellow-200 dark:bg-yellow-800 rounded-b-lg border-t-0 text-md text-yellow-500 dark:text-yellow-200 hidden"></div>
                        <div id="numericIndicator" class="absolute top-0 left-0 text-sm text-red-600 hidden">Seules des valeurs numériques sont autorisées.</div>
                    </div>
                    


                    <div id="payments-container" class="relative">
                        <div id="payments-subcontainer"></div>
                    </div>
                    <div class="flex justify-end">
                        <div onclick="addPaymentRow()" class="flex w-fit p-2 cursor-pointer rounded-lg text-gray-600 dark:text-white bg-slate-400 hover:bg-slate-300 focus:ring-4 focus:ring-slate-300 font-medium text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-slate-600 dark:hover:bg-slate-500 focus:outline-none dark:focus:ring-slate-800 shadow-sm dark:shadow-black" style="margin-top: 0.5rem;">Ajouter un encaissement</div>
                    </div>
                    <div position="relative">
                        <label for="ModaleventComment" class="block mb-2 text-md font-medium text-gray-900 dark:text-white">Commentaire :</label>
                        <textarea id="ModaleventComment" name="ModaleventComment" class="block p-2.5 w-full text-md text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-slate-800 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Une chose à dire, c'est ici..."></textarea>
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

    // CATCHING elementID:
    var eventFull_Blocked = document.getElementById("Modaleventfullblocked");
    var container_full_blocked = document.getElementById("container_eventfullblocked");
    var container_global = document.getElementById("addEventModal");
    var checkbox = document.getElementById('Modaleventfullblocked');
    var DateStart = document.getElementById('ModaleventStart');
    var DateEnd = document.getElementById('ModaleventEnd');

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
    // Simplifier la génération d'ID unique en utilisant une combinaison de date et aléatoire
    const uniqueID = `temp_${Date.now().toString(36)}_${Math.random().toString(36).substr(2, 5)}`;

    // Optimiser l'accès au DOM
    const qt = parseInt(document.getElementById("ModaleventQt").value, 10);
    const qtTraveller = parseInt(document.getElementById("ModaleventQtTraveller").value, 10);
    const price = parseInt(priceInput.value, 10);
    const serviceTax = parseInt(service.Tax, 10);
    const serviceFee = parseInt(service.Fee, 10);

    let sum = Array.from(document.querySelectorAll('input[id^="rowPaid"]'))
                    .filter(input => /^rowPaid\d+$/.test(input.id))
                    .reduce((acc, input) => acc + Number(input.value), 0);

    let FillPaidInput = !isNaN(price) && !isNaN(qtTraveller) ?
                        (price + (qtTraveller * serviceTax * qt) + serviceFee) - sum : 0;

    const newPaymentRow = `
    <div class="flex payment-row mt-1" id='${uniqueID}'>
        <div class=" inline-flex items-center w-fit bg-red-50 border border-red-300 hover:bg-red-400 dark:bg-red-700 dark:hover:bg-red-900 rounded-lg mx-1 my-0.5 p-2 cursor-pointer" onclick="Deletepaid('${uniqueID}')"> X </div>
            <input type="hidden" id="rowPaidid${uniqueID}" name="rowPaidid${uniqueID}">
            <select id="rowPaidType${uniqueID}" name="rowPaidType${uniqueID}" class="inline-flex rounded-l-lg items-center py-2.5 px-4 text-sm font-bold text-center text-gray-500 bg-gray-100 border border-gray-300 hover:bg-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-100 dark:bg-slate-800 dark:hover:bg-gray-600 dark:focus:ring-slate-800 dark:text-white dark:border-gray-600">
                <option value="ESPECE">ESPECE</option>
                <option value="VIREMENT">VIREMENT</option>
                <option value="VISA">VISA</option>
                <option value="AMEX">AMEX</option>
                <option value="CHEQUE">CHEQUE</option>
            </select>
            <input type="number" pattern="[0-9]*" value=${FillPaidInput} inputmode="numeric" id="rowPaid${uniqueID}" name="rowPaid${uniqueID}" class=" block w-full rounded-r-lg text-md text-gray-900 bg-transparent border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer">
        </div>
    `;

    document.getElementById('payments-subcontainer').insertAdjacentHTML('beforeend', newPaymentRow);
}

    // Déclaration globale des variables pour une meilleure visibilité
    // Fonction pour mettre à jour les informations totales
    function updateTotalInfo() {
        let qtTraveller = parseInt(document.getElementById("ModaleventQtTraveller").value);
        let price = parseInt(priceInput.value);
        let total = 0;
        let nDays = parseInt(document.getElementById("ModaleventQt").value);
        
        if (!isNaN(price) && !isNaN(qtTraveller) && service) {
            // Calcul du prix total
            total = price + (qtTraveller * parseInt(service.Tax) * parseInt(nDays))  + parseInt(service.Fee);
        }

        totalIndicator.innerHTML = `
        <div class="flex justify-between  font-normal text-xs text-slate-400 dark:text-slate-100">
            <div class="flex-grow">
                <div class="">
                    <b>Tarif réservation:</b> ${price.toLocaleString('fr-FR')}  Fr
                </div>
                <div class="">
                    <b>Taxe de séjour:</b> ${qtTraveller} Personne(s) * ${nDays} jour(s) * ${parseInt(service.Tax)} Fr
                </div>
                <div class="">
                    <b>Frais de ménage:</b>  ${service.Fee.toLocaleString('fr-FR')} Fr
                </div>
            </div>
            <div class="flex-col">
                <div class="text-right text-sm whitespace-nowrap">
                    TOTAL
                </div>           
                <div class="text-right text-lg whitespace-nowrap">
                    ${total.toLocaleString('fr-FR')} Fr
                </div>
            </div>
        </div>`;
        numericIndicator.style.display = (isNaN(price) || isNaN(qtTraveller)) ? "inline" : "none";
    }
    
    function loadServiceDetails(serviceId) {
        
        service = discountservice.find(s => s.Service_id === serviceId);
        
        // MàJ datepicker
        if(fromServicepicker){

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
            container_global.classList.add('border');
            container_global.classList.add('border-dashed');
            container_global.classList.add('border-4');
            container_global.classList.add('border-red-400');

        }
        else { 
            checkbox.checked = false;
            container_full_blocked.classList.remove("bg-red-500");
            container_global.classList.remove('border');
            container_global.classList.remove('border-dashed');
            container_global.classList.remove('border-4');
            container_global.classList.remove('border-red-400'); 
        }

        if (!userChangedPrice) {
            priceInput.value = prices[serviceId];
            updateTotalInfo(); // Mettre à jour le total après avoir changé le service
        }
    }


    // Attacher des écouteurs d'événements aux éléments
    document.getElementById("ModaleventPrice").addEventListener("change", function() {userChangedPrice = true;updateTotalInfo();});
    document.getElementById("ModaleventQtTraveller").addEventListener("change", updateTotalInfo);
    serviceSelect.addEventListener("change", function() { loadServiceDetails(this.value); });

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

    return { closestQty, discountValue };
}

// Fonction pour calculer le prix avec réduction
function calculateDiscountedPrice(qt, servicePrice, discountValue, discountType) {
    if(discountValue>0){
        if (discountType == "Pourcentage") {
            return (servicePrice * qt) * (1 - discountValue / 100);
        } else if (discountType == "Fixe") {
            return discountValue * qt;
        }
    }
    else{
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

        priceInput.value = prixCalculé.toFixed(0).toLocaleString('fr-FR'); ; // Prix sans décimales
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
                fromServicepicker.destroy(); // Assurez-vous que la méthode `destroy` est bien définie par Easepick pour détruire l'instance
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