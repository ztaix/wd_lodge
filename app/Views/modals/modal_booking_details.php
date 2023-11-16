<script>
    var baseUrl = "<?= base_url(); ?>"; // Ceci stockera l'URL de base dans une variable JavaScript
</script>

<?php
$modal_id = "DetailsEventModal";
?>

<!-- DETAILS EVENTS - Modal Container -->
<div id="<?= $modal_id ?>" tabindex="-1" aria-hidden="true" class="fixed w-full hidden z-50">
    <div class="h-full bg-slate-200 rounded-lg dark:bg-gray-700 ">
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
        <div class="flex justify-center h-full px-4 pb-9 bg-slate-200 dark:bg-slate-700">
            <h3 id="modal-title_details_booking" class="flex items-center text-lg leading-6 font-medium"><!-- JavaScript print Date du jour --></h3>

            <div class="flex flex-col">

                <p class="text-xs text-slate-400 flex justify-between m-2">
                    <span id="booking_details_created_span" class="flex items-center">créer le :</span>
                    <span id="booking_details_updated_span" class="flex items-center">modifier le: </span>
                </p>

                <div class="max-w-sm bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">

                    <h5 id="booking_details_id_h5" class="absolute p-4 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Titre du service</h5>
                    <a href="#">
                        <img class="rounded-t-lg" src="./img/lodge.jpeg" alt="" />
                    </a>

                    <div class="px-4">

                        <div class="flex space-x-4 my-2">
                            <div class="relative w-12 h-10 overflow-hidden justify-start bg-gray-100 rounded-full dark:bg-gray-600">
                                <svg class="absolute w-12 h-12 text-gray-400 -left-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div class="w-full font-medium  text-gray-700 dark:text-white">
                                <div class="flex justify-between">
                                    <div id="booking_details_customer_name_span">Customer Name</div>
                                    <span id="booking_details_customer_phone_span" class="text-sm text-gray-500 dark:text-gray-400">customer_phone</span>
                                </div>
                                <div class="flex justify-between">
                                    <div id="booking_details_customer_created_span" class="text-xs text-slate-400 dark:text-gray-500">Created at Month YEAR</div>
                                    <span id="booking_details_customer_mail_span" class="text-sm text-gray-500 dark:text-gray-400">customer_mail</span>
                                </div>
                            </div>
                        </div>
                        <div class="flex text-sm p-2 border-l-4 border-slate-200 dark:border-gray-950 dark:bg-slate-900 bg-slate-50 rounded-lg">
                            <span id="booking_details_customer_comment_span" class="text-md inline-flex text-slate-500 dark:text-slate-200 ">Commentaire client</span>
                        </div>



                        <p class="flex justify-between text-base text-gray-700 dark:text-gray-400 my-2">
                            <h5 id="booking_details_service_h5" class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Titre du service</h5>
                            <h5 id="booking_details_fullblocked_h5" class="text-sm font-bold tracking-tight text-red-900 dark:text-red-300">FullBlocked</h5>
                        </p>
                        <p class="flex justify-between text-base text-gray-700 dark:text-gray-400 my-2">
                            <span class="font-bold">Nombre de nuits</span>
                            <span id="booking_details_qt_span" class="text-md font-medium mr-2">Qt nuits</span>
                        </p>
                        <p class="flex justify-between text-base text-gray-700 dark:text-gray-400 my-2">
                            <span class="font-bold">Tarif</span>
                            <span id="booking_details_price_span" class="text-md bg-yellow-100 text-yellow-800 font-medium px-2.5 py-0.5 rounded-full dark:bg-yellow-900 dark:text-yellow-300">Yellow</span>
                        </p>
                        <p class="flex justify-between text-base text-gray-700 dark:text-gray-400 my-2">
                            <span class="font-bold">Voyageur(s):</span>
                            <span id="booking_details_traveller_span" class="text-md font-medium mr-2">Nb Voyageurs</span>
                        </p>
                        
                        <div class="flex justify-between text-base text-gray-700 dark:text-gray-400 my-2">
                            <span class="mr-2 font-bold">Encaissé</span>
                            <div class="w-full h-6 bg-slate-300 rounded-full dark:bg-gray-700">
                                <div id="booking_details_progress_div" class="bg-green-600 text-xs font-medium text-green-100 text-center p-0.5 leading-none rounded-full h-full flex items-center justify-center">
                                </div>
                            </div>
                        </div>


                        <div class="flex items-center justify-between text-base text-gray-700 dark:text-gray-400 my-2">
                            <span class="font-bold">Période :</span>
                            <span id="booking_details_start_span" class="mr-3"></span>
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9" />
                            </svg>
                            <span id="booking_details_end_span" class="ml-3 text-gray-800 dark:text-white"></span>
                        </div>

                        <p class="text-base text-gray-700 dark:text-gray-400 my-2">
                            <span class="font-bold">Commentaire</span>
                            <span id="booking_details_comment_span">Commentaire de réservation.</span>
                        </p>
                        <div class="inline-flex items-center w-full gap-2">
                            <a id="booking_details_pdf" href="#" class="whitespace-nowrap text-slate-400 bg-white hover:bg-gray-100 border border-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-100 font-sans text-xs font-bold uppercase rounded-lg px-5 py-2.5 text-center inline-flex items-center dark:focus:ring-gray-600 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:bg-gray-700 mb-2 w-full"></a>
                            <a id="booking_details_sendmail" href="#" class="whitespace-nowrap text-slate-400 bg-white hover:bg-gray-100 border border-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-100 font-sans text-xs font-bold uppercase rounded-lg px-5 py-2.5 text-center inline-flex items-center dark:focus:ring-gray-600 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:bg-gray-700 mb-2 w-full"></a>
                        </div>


                        <div class="flex flex-col items-right w-full pb-2">
                            <button type="button" id="booking_details_update_button" class="text-sm text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg px-5 py-1.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 ">
                                Modifier</button>
                            <button type="button
                            " id="booking_details_delete_button" class="mt-2 text-sm text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg px-5 py-1.5 dark:bg-red-600 dark:hover:bg-red-700 focus:outline-none dark:focus:ring-red-800 ">
                                Suppprimer</button>
                        </div>

                    </div>

                </div>


            </div>


        </div>
    </div>

</div>