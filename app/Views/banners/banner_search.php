<?php $modal_id = 'SearchListEventModal' ?>

<!-- BANNER SEARCH -->
<div id="<?= $modal_id ?>-shadow_modal" class="fixed inset-0 bg-black opacity-50 hidden" onclick="closeModalById('<?= $modal_id ?>')"></div>
<div id="<?= $modal_id ?>" tabindex="-1" aria-hidden="true" class="flex h-full flex-grow hidden"  onclick="closeModalById('<?= $modal_id ?>')">
    <div class="mx-auto w-full max-w-xl ">
        <div onclick="event.stopPropagation()">
            <div class="mx-auto max-w-sm pt-20 lg:px-8 flex justify-between items-center ">
                    <div class="absolute  flex items-center pl-3 pointer-events-none shadow-xl z-0">
                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                        </svg>
                    </div>
                    <input type="search" id="default-search" class="shadow-lg block w-full p-4 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Client, Date, Service, Tarif, Réf..." required>
                    <div class="flex-shrink-0 ml-2"> <!-- Remplacement de grow-0 par flex-shrink-0 -->
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="authentication-modal" onclick="closeModalById('<?= $modal_id ?>')">
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class=" sr-only">Fermer</span>
                </button>
            </div>
            </div>
            
            <div id="searchResults" class="relative text-slate-600 dark:text-slate-200 rounded-xl mt-4">
                    <!-- Les résultats de la recherche seront insérés ici -->
            </div>

        </div>
    </div>
</div>



