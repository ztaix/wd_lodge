<?php
$modal_id= "CustomerInfoModal";
?>

<!-- DETAILS EVENTS - Modal Container -->
<div id="<?= $modal_id ?>" tabindex="-1" aria-hidden="true" class="fixed w-full h-full inset-0 hidden z-50">
    <div class="h-full relative bg-white rounded-lg shadow dark:bg-gray-700 ">
        <div class="h-full overflow-scroll">

            <!-- Modal Header -->
            <div class="px-6 py-6 lg:px-8 flex justify-between items-center">
                <div >
                    <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 16">
                        <path d="M18 0H2a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2ZM6.5 3a2.5 2.5 0 1 1 0 5 2.5 2.5 0 0 1 0-5ZM3.014 13.021l.157-.625A3.427 3.427 0 0 1 6.5 9.571a3.426 3.426 0 0 1 3.322 2.805l.159.622-6.967.023ZM16 12h-3a1 1 0 0 1 0-2h3a1 1 0 0 1 0 2Zm0-3h-3a1 1 0 1 1 0-2h3a1 1 0 1 1 0 2Zm0-3h-3a1 1 0 1 1 0-2h3a1 1 0 1 1 0 2Z"/>
                    </svg>
                </div>
                <div class="flex-grow text-center">
                    <h3 class="text-center text-2xl font-bold text-gray-800 dark:text-white">Historique client</h3>
                </div>    
                <div >
                    <button type="button" class="absolute right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="authentication-modal" onclick="closeModalById('<?= $modal_id ?>')">
                        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class=" sr-only">Fermer</span>
                    </button>
                </div>
            </div>

            <!-- Modal Body -->
            <div class="h-full overflow-scroll px-4 py-2 bg-slate-200">
                <h3 id="modal-title_customer_finance_total" class="flex items-center text-lg leading-6 font-medium"><!-- JavaScript print Date du jour --></h3>
                <div class="relative overflow-x-auto shadow rounded-lg mb-3">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-3 py-3">
                                    Service
                                </th>
                                <th scope="col" class="px-3 py-3">
                                    Date
                                </th>
                                <th scope="col" class="px-3 py-3">
                                    Encaissé
                                </th>
                                <th scope="col" class="px-3 py-3">
                                    Tarif
                                </th>
                            </tr>
                        </thead>
                        <tbody id="CustomerDetailsContainer">

                            <!-- JavaScript will populate this area -->

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
