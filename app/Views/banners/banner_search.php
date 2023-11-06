<?php $modal_id = 'SearchListEventModal' ?>
<div id="<?= $modal_id ?>" class="fixed w-full h-full top-0 m-0 p-0 z-50" style="display:none; background-color: rgba(0, 0, 0, 0.5);">
        
    <div class="px-6 py-6 lg:px-8 flex justify-between items-center ">
            <div class="absolute left-5 flex items-center pl-3 pointer-events-none">
                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                </svg>
            </div>
            <input type="search" id="default-search" class="shadow-lg block w-full p-4 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Rechercher: Client, ID de résa, date, service, Encaissé, Tarif..." required>
                      
            
        <div class="flex-shrink-0 ml-2"> <!-- Remplacement de grow-0 par flex-shrink-0 -->
            <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="authentication-modal" onclick="closeModalById('<?= $modal_id ?>')">
               <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
                <span class=" sr-only">Fermer</span>
            </button>
        </div>
    </div>
    <div id="searchResults" class=" text-slate-400 rounded-xl m-5 p-5">
            <!-- Les résultats de la recherche seront insérés ici -->
    </div>
</div>


