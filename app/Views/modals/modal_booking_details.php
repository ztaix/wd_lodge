<?php
$modal_id = "DetailsEventModal";
?>

<!-- DETAILS EVENTS - Modal Container -->
<div id="<?= $modal_id ?>" tabindex="-1" aria-hidden="true" class="fixed w-full h-full hidden z-50 overflow-auto">
    <div class="relative bg-slate-200 dark:bg-gray-700 ">
        
            <!-- Modal Header -->
            <div class="px-6 py-6 lg:px-8 flex justify-between items-center bg-slate-200 dark:bg-gray-700">
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
            <div class="flex justify-center h-full px-4 pb-9 bg-slate-200 dark:bg-slate-700 ">
                
            <h3 id="modal-title_details_booking" class="flex items-center text-lg leading-6 font-medium"><!-- JavaScript print Date du jour --></h3>

                <div class="flex flex-col">

                    <p class="text-xs text-slate-400 flex justify-between m-2">
                        <span id="booking_details_created_span" class="flex items-center">créer le :</span>
                        <span id="booking_details_updated_span" class="flex items-center">modifier le: </span>
                    </p>

                    <div class="max-w-sm bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">

                        <h5 id="booking_details_id_h5" class="absolute p-4 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Titre du service</h5>
                        <a href="#">
                            <img id="booking_details_img" class="rounded-t-lg" src="./img/lodge.jpeg" alt="" />
                        </a>

                        <div class="px-4">

                            <div class="flex space-x-4 my-2">
                                <div class="relative w-12 h-10 overflow-hidden justify-start bg-gray-100 rounded-full dark:bg-gray-600">
                                    <svg class="absolute w-12 h-12 text-gray-400 -left-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <div class="w-full font-medium  text-gray-700 dark:text-white">
                                    <div class="flex justify-between cursor-pointer">
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
                                <h5 id="booking_details_fullblocked_h5" class="relative bg-red-200 dark:bg-red-800 rounded-lg text-sm text-center font-bold tracking-tight text-red-500 dark:text-red-950 mx-auto p-2">FullBlocked</h5>
                            </p>
                            <p class="flex items-center justify-between text-base text-gray-700 dark:text-gray-400 my-2">
                                <svg class="w-4 h-4 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 11 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1.75 15.363a4.954 4.954 0 0 0 2.638 1.574c2.345.572 4.653-.434 5.155-2.247.502-1.813-1.313-3.79-3.657-4.364-2.344-.574-4.16-2.551-3.658-4.364.502-1.813 2.81-2.818 5.155-2.246A4.97 4.97 0 0 1 10 5.264M6 17.097v1.82m0-17.5v2.138"/>
                                </svg>
                                <span class="font-bold">Tarif</span>
                                <span class="ml-auto flex flex-col items-end">
                                <span id="booking_details_price_span" class="w-fit text-md bg-yellow-100 text-yellow-800 font-medium px-2.5 py-0.5 rounded-full dark:bg-yellow-900 dark:text-yellow-300">Yellow</span>
                                <span class='text-xs italic text-slate-300 dark:text-slate-400'>(taxe voyageur inclus)</span>
                            </span>
                            </p>
                            <div class="flex items-center justify-between text-base text-gray-700 dark:text-gray-400 my-2">
                                <span class="flex items-center">

                                    <svg class="w-4 h-4 mr-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M11.074 4 8.442.408A.95.95 0 0 0 7.014.254L2.926 4h8.148ZM9 13v-1a4 4 0 0 1 4-4h6V6a1 1 0 0 0-1-1H1a1 1 0 0 0-1 1v13a1 1 0 0 0 1 1h17a1 1 0 0 0 1-1v-2h-6a4 4 0 0 1-4-4Z"/>
                                        <path d="M19 10h-6a2 2 0 0 0-2 2v1a2 2 0 0 0 2 2h6a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1Zm-4.5 3.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2ZM12.62 4h2.78L12.539.41a1.086 1.086 0 1 0-1.7 1.352L12.62 4Z"/>
                                    </svg>
                                    <span class="mr-2 font-bold">
                                        Encaissé
                                    </span>
                                </span>
                                <div class="w-full h-6 bg-slate-300 rounded-full dark:bg-gray-700">
                                    <div id="booking_details_progress_div" class="bg-green-600 text-xs font-medium text-green-100 text-center p-0.5 leading-none rounded-full h-full flex items-center justify-center"></div>
                                </div>
                            </div>
                            <p class="flex justify-between items-center text-base text-gray-700 dark:text-gray-400 my-2">
                                <!-- Conteneur pour les éléments collés -->
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 20">
                                        <path d="M17.8 13.75a1 1 0 0 0-.859-.5A7.488 7.488 0 0 1 10.52 2a1 1 0 0 0 0-.969A1.035 1.035 0 0 0 9.687.5h-.113a9.5 9.5 0 1 0 8.222 14.247 1 1 0 0 0 .004-.997Z"/>
                                    </svg>    
                                    <span class="font-bold">Nombre de nuits</span>
                                </span>
                                <!-- Élément séparé -->
                                <span id="booking_details_qt_span" class="text-md font-medium">Qt nuits</span>
                            </p>

                            <p class="flex items-center justify-between text-base text-gray-700 dark:text-gray-400 my-2">
                                <span class="flex items-center">

                                    <svg class="w-4 h-4 mr-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 18">
                                        <path d="M14 2a3.963 3.963 0 0 0-1.4.267 6.439 6.439 0 0 1-1.331 6.638A4 4 0 1 0 14 2Zm1 9h-1.264A6.957 6.957 0 0 1 15 15v2a2.97 2.97 0 0 1-.184 1H19a1 1 0 0 0 1-1v-1a5.006 5.006 0 0 0-5-5ZM6.5 9a4.5 4.5 0 1 0 0-9 4.5 4.5 0 0 0 0 9ZM8 10H5a5.006 5.006 0 0 0-5 5v2a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-2a5.006 5.006 0 0 0-5-5Z"/>
                                    </svg>
                                
                                    <span class="font-bold">Voyageur(s)</span>
                                </span>
                                <span id="booking_details_traveller_span" class="text-md font-medium">Nb Voyageurs</span>
                            </p>
                            


                            <div class="flex items-center justify-between text-base text-gray-700 dark:text-gray-400 my-2">
                                
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                                    </svg>
                                    <span class="font-bold">Période</span>
                                </span>
                                <span id="booking_details_start_span" class="mr-3"></span>
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9" />
                                </svg>
                                <span id="booking_details_end_span" class="ml-3 text-gray-800 dark:text-white"></span>
                            </div>

                            <p class="text-base text-gray-700 dark:text-gray-400 my-2">
                                <span class="font-bold">Commentaire : </span>
                                <span id="booking_details_comment_span">Commentaire de réservation.</span>
                            </p>
                            <div class="inline-flex items-center w-full pt-4 gap-2">
                                <a id="booking_details_pdf" href="#" class="whitespace-nowrap text-slate-400 bg-white hover:bg-gray-100 border border-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-100 font-sans text-xs font-bold uppercase rounded-lg px-5 py-2.5 text-center inline-flex items-center dark:focus:ring-gray-600 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:bg-gray-700 mb-2 w-full"></a>
                                <a id="booking_details_sendmail" href="#" class="whitespace-nowrap text-slate-400 bg-white hover:bg-gray-100 border border-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-100 font-sans text-xs font-bold uppercase rounded-lg px-5 py-2.5 text-center inline-flex items-center dark:focus:ring-gray-600 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:bg-gray-700 mb-2 w-full"></a>
                            </div>


                            <div class="flex flex-col items-right w-full py-4 px-4">
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