<?php
$modal_id = "ListEventModal";
?>

<!-- LIST TODAY EVENTS - Modal Container -->
<div id="<?= $modal_id ?>" tabindex="-1" aria-hidden="true" class="fixed w-full h-full  hidden z-50">
    <div class="h-full relative bg-slate-200 rounded-lg dark:bg-gray-700 ">

        <div class="sticky right-3 top-3">
            <button type="button" class="absolute right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="authentication-modal" onclick="closeModalById('<?= $modal_id ?>')">
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                </svg>
                <span class=" sr-only">Fermer</span>
            </button>
        </div>
        <!-- Modal Header -->
        <div class="flex max-w-xl mx-auto py-4">
                    <div class="w-full inline-flex p-2 mx-2 cursor-pointer text-base shadow-md 
                    border
                    text-blue-700 dark:text-white
                    bg-blue-300 hover:bg-blue-200 dark:bg-blue-700 hover:dark:bg-blue-800 rounded-lg" onclick="handleAddEventClick()">
                        <svg class=" w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1v3m5-3v3m5-3v3M1 7h18M5 11h10M2 3h16a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1Z" />
                        </svg>
                        <div class="px-4">+ Ajouter une réservation pour le </div>
    
                        <h3 id="modal-title" class="text-center font-bold -ml-2"><!-- JavaScript print Date du jour --></h3>
                    </div>
        </div>

        <!-- Modal Body -->
        <div class="flex flex-col max-w-xl mx-auto">

            <div class="flex justify-center p-2 mx-2 mb-14 bg-slate-200 dark:bg-slate-700">

                <div class="w-full bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                    <div class="px-4">

                        <div class="flex items-center my-2">
                            <div id="bookingListContainer" class="w-full text-md text-slate-500">
                                <!-- JavaScript will populate this area -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function handleAddEventClick() {
        resetForm('addEventModal');
        openModal('addEventModal');
    }
</script>