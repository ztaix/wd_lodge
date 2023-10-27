<script>
    var baseUrl = "<?= base_url(); ?>"; // Ceci stockera l'URL de base dans une variable JavaScript
</script>

<?php
$modal_id = "DetailsEventModal";
?>

<!-- DETAILS EVENTS - Modal Container -->
<div id="<?= $modal_id ?>" tabindex="-1" aria-hidden="true" class="fixed w-full h-full inset-0 hidden z-50">
    <div class="h-full relative bg-slate-200 rounded-lg dark:bg-gray-700 ">
        <div class="h-full overflow-scroll">

            <!-- Modal Header -->
            <div class="px-6 py-6 lg:px-8 flex justify-between items-center">
                <div>
                    <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 16">
                        <path d="M18 0H2a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2ZM6.5 3a2.5 2.5 0 1 1 0 5 2.5 2.5 0 0 1 0-5ZM3.014 13.021l.157-.625A3.427 3.427 0 0 1 6.5 9.571a3.426 3.426 0 0 1 3.322 2.805l.159.622-6.967.023ZM16 12h-3a1 1 0 0 1 0-2h3a1 1 0 0 1 0 2Zm0-3h-3a1 1 0 1 1 0-2h3a1 1 0 1 1 0 2Zm0-3h-3a1 1 0 1 1 0-2h3a1 1 0 1 1 0 2Z" />
                    </svg>
                </div>
                <div class="flex-grow text-center">
                    <h3 class="text-center text-2xl font-bold text-gray-800 dark:text-white">Détails de réservation</h3>
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
            <div class="flex justify-center h-full overflow-scroll px-4 py-2 0bg-slate-20">
                <h3 id="modal-title_details_booking" class="flex items-center text-lg leading-6 font-medium"><!-- JavaScript print Date du jour --></h3>

                <div class="relative overflow-x-auto rounded-lg">
                    <div class="max-w-sm bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                        <a href="#">
                            <img class="rounded-t-lg" src="./img/lodge.jpeg" alt="" />
                        </a>
                        <div id="booking_details_type_doc_div" class="absolute overflow-hidden top-10 -left-10 w-1/2 transform -rotate-45 h-5 bg-gray-950 bg-opacity-80  text-white text-center leading-5 flex items-center justify-center">
                            Type_doc
                        </div>

                        <div class="p-5">
                            <div class="flex items-center justify-between">
                                <h5 id="booking_details_title_h5" class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Titre du service</h5>
                                <h5 class="mb-4 text-2xl font-extrabold leading-none tracking-tight text-gray-900 md:text-5xl lg:text-6xl dark:text-white">
                                    <mark id="booking_details_price_mark" class="px-2 text-white rounded">5000 Fr</mark>
                                </h5>
                            </div>
                            <div class="flex items-center justify-start">
                                <span id="booking_details_start_span" class="mr-3 text-gray-800 dark:text-white"></span>
                                <svg class="w-3 h-3 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9" />
                                </svg>
                                <span id="booking_details_end_span" class="ml-3 text-gray-800 dark:text-white"></span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-base font-medium text-gray-800 dark:text-white">Encaissé</span>
                                <span id="booking_details_paid_span" class="text-sm font-bold text-gray-800 dark:text-white">50 FR</span>
                            </div>
                            <div class="w-full  bg-slate-300 rounded-full dark:bg-gray-700">
                                <div id="booking_details_progress_div" class="bg-blue-600 text-xs font-medium text-blue-100 text-center p-0.5 leading-none rounded-full"></div>
                            </div>

                            <p class="text-base text-gray-700 dark:text-gray-400 my-4">
                                <span class="font-bold">Commentaire :</span>
                                <span id="booking_details_comment_span">Commentaire de réservation.</span>
                            </p>

                            <p class="text-base text-gray-700 dark:text-gray-400 my-4">
                                <span class="font-bold">Réservé par :</span>
                                <span id="booking_details_customer_name_span">customer_name</span>
                            </p>
                            <p class="text-xs text-slate-300 flex justify-between my-4">
                                <span id="booking_details_created_span" class="flex items-center">créer le :</span>
                                <span id="booking_details_updated_span" class="flex items-center">modifier le: </span>
                            </p>
                            <div class="flex justify-between pb-2">
                                <a id="booking_details_pdf" href="#" class="inline-flex middle none center rounded-lg bg-pink-500 py-2 px-3 font-sans text-xs font-bold uppercase text-white shadow-md shadow-pink-500/20 transition-all hover:shadow-lg hover:shadow-pink-500/40 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none" data-ripple-light="true"></a>
                                <a id="booking_details_sendmail" href="#" class="inline-flex middle none center rounded-lg bg-emerald-500 py-2 px-3 font-sans text-xs font-bold uppercase text-white shadow-md shadow-emerald-500/20 transition-all hover:shadow-lg hover:shadow-emerald-500/40 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none" data-ripple-light="true"></a>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="fixed bottom-0 pb-10 pb-10 flex justify-between w-9/12">
                    <button id="booking_details_delete_button" class="inline-flex middle none center rounded-lg bg-red-500 py-2 px-4 font-sans text-md font-bold uppercase text-white shadow-md shadow-red-500/20 transition-all hover:shadow-lg hover:shadow-red-500/40 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none" data-ripple-light="true">
                        Supprimer
                        <svg class="w-4 h-4 ml-2 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                    </button>
                    <button id="booking_details_update_button" class="inline-flex middle none center rounded-lg bg-blue-500 py-2 px-4 font-sans text-md font-bold uppercase text-white shadow-md shadow-blue-500/20 transition-all hover:shadow-lg hover:shadow-blue-500/40 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none" data-ripple-light="true">
                        Modifier
                        <svg class="w-4 h-4 ml-2 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 18">
                            <path d="M12.687 14.408a3.01 3.01 0 0 1-1.533.821l-3.566.713a3 3 0 0 1-3.53-3.53l.713-3.566a3.01 3.01 0 0 1 .821-1.533L10.905 2H2.167A2.169 2.169 0 0 0 0 4.167v11.666A2.169 2.169 0 0 0 2.167 18h11.666A2.169 2.169 0 0 0 16 15.833V11.1l-3.313 3.308Zm5.53-9.065.546-.546a2.518 2.518 0 0 0 0-3.56 2.576 2.576 0 0 0-3.559 0l-.547.547 3.56 3.56Z" />
                            <path d="M13.243 3.2 7.359 9.081a.5.5 0 0 0-.136.256L6.51 12.9a.5.5 0 0 0 .59.59l3.566-.713a.5.5 0 0 0 .255-.136L16.8 6.757 13.243 3.2Z" />
                        </svg>
                    </button>
                </div>
            </div>

        </div>

    </div>

</div>