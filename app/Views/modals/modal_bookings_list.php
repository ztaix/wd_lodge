<?php
$modal_id = "ListEventModal";
?>
<!-- LIST TODAY EVENTS - Modal Container -->
<div id="<?=$modal_id?>-shadow_modal" class="fixed bg-black hidden h-screen w-screen" onclick="closeModalById('<?= $modal_id ?>')"></div>
<div id="<?= $modal_id ?>" tabindex="-1" aria-hidden="true" class="max-w-md lg:max-w-lg flex flex-grow hidden top-0 overflow-auto" >

<div class="relative mx-auto p-2 ">

    <!-- Modal Header -->
    <div class="px-6 py-6 lg:px-8 flex justify-between items-center text-slate-500 bg-white border-gray-200 dark:bg-gray-800 dark:border-gray-700 rounded-xl">

        <div class="flex-grow text-center">
        <div class="w-full inline-flex p-2 mx-2 cursor-pointer Add_Event_blinking" onclick="handleAddEventClick()">
                        <h2 class="px-4">Ajouter une réservation : </h2>
    
                        <h2 id="modal-title" class="text-center font-bold -ml-2"><!-- JavaScript print Date du jour --></h2>
                    </div>
        </div>    
        <div class="pl-4">
            <button type="button" class=" text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="authentication-modal" onclick="closeModalById('<?= $modal_id ?>')">
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
                <span class=" sr-only">Fermer</span>
            </button>
        </div>
    </div>

        <!-- Modal Body -->
        <div class="flex flex-col max-w-xl mx-auto">

            <div class="flex justify-center pt-2">

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