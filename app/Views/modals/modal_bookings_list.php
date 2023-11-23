<?php
$modal_id = "ListEventModal";
?>

<!-- LIST TODAY EVENTS - Modal Container -->
<div id="<?= $modal_id ?>" tabindex="-1" aria-hidden="true" class="fixed w-full h-full  hidden z-50">
    <div class="h-full relative bg-slate-200 rounded-lg dark:bg-gray-700 ">

        <!-- Modal Header -->
        <div class="px-6 py-6 lg:px-8 flex justify-between items-center">
            <div>
                <svg class=" w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1v3m5-3v3m5-3v3M1 7h18M5 11h10M2 3h16a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1Z" />
                </svg>
            </div>
            <div class="flex-grow text-center">
                <h3 id="modal-title" class="text-center text-2xl font-bold text-gray-800 dark:text-white"><!-- JavaScript print Date du jour --></h3>
            </div>
            <div>
                <button type="button" class="absolute right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="authentication-modal" onclick="closeModalById('<?= $modal_id ?>')">
                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class=" sr-only">Fermer</span>
                </button>
            </div>
        </div>

        <!-- Modal Body -->
        <div class="flex flex-col max-w-xl mx-auto">
            <div class="p-2 mx-2 cursor-pointer  shadow-md border hover:border border-blue-300 dark:border-blue-600 hover:border-blue-900 text-blue-200 hover:text-white dark:text-white bg-blue-400 hover:bg-blue-600 dark:bg-blue-900 hover:dark:bg-blue-700 rounded-lg" onclick="handleAddEventClick()">
                <div class="px-4 text-slate-200 dark:text-white">+ Ajouter une réservation</div>
            </div>

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