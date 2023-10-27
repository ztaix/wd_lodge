<?php
$modal_id= "ListEventModal";
?>

<!-- LIST TODAY EVENTS - Modal Container -->
<div id="<?= $modal_id ?>" tabindex="-1" aria-hidden="true"  class="fixed inset-0 hidden w-full h-full z-50">
    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700 ">
        <div class=" overflow-auto h-[calc(100vh)]">

        <!-- Modal Header -->
        <div class="px-6 py-6 lg:px-8 flex justify-between items-center">
            <div >
                <svg class=" w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1v3m5-3v3m5-3v3M1 7h18M5 11h10M2 3h16a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1Z"/>
                </svg>
            </div>
            <div class="flex-grow text-center">
                <h3 id="modal-title" class="text-center text-2xl font-bold text-gray-800 dark:text-white"><!-- JavaScript print Date du jour --></h3>
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
        <div class=" px-4 py-2">
            <div id="bookingListContainer" class="text-md text-slate-500" >
            <!-- JavaScript will populate this area -->
            </div>
        </div>
    </div>
  </div>
</div>