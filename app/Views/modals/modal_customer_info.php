<?php
$modal_id= "CustomerInfoModal";
?>

<!-- DETAILS EVENTS - Modal Container -->
<div id="<?=$modal_id?>-shadow_modal" class="absolute bg-black hidden h-screen w-screen" onclick="closeModalById('<?= $modal_id ?>')"></div>

<div id="<?= $modal_id ?>" tabindex="-1" aria-hidden="true" class="fixed max-w-md lg:max-w-lg mx-auto flex flex-col flex-grow hidden top-0 overflow-auto" >

            <!-- Modal Header -->
            <div class="px-2 py-2 lg:px-8 flex justify-between items-center bg-white rounded-b-lg shadow-md ">
                <div class="flex-grow text-center">
                    <h3  class="text-center text-2xl font-bold text-gray-800 dark:text-white">Historique Client</h3>
                </div> 
                <div>
                    <button type="button" class=" text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="authentication-modal" onclick="closeModalById('<?= $modal_id ?>')">
                        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class=" sr-only">Fermer</span>
                    </button>
                </div>
            </div>

            <!-- Modal Body -->
            <div class="flex justify-center px-4 py-4 sm:px-9 sm:pb-9">
            <div class="flex flex-col">

                <div class="bg-white border border-gray-200 rounded-lg dark:bg-slate-800 dark:border-gray-800 shadow-2xl">
                
                    <div class="px-4">

                        <div id="history_customer_block_toedit" class="flex space-x-4 my-2 group cursor-pointer">
                            <div class="relative w-12 h-10 overflow-hidden justify-start bg-gray-100 rounded-full dark:bg-gray-600">
                                <svg class="absolute w-12 h-12 text-gray-400 -left-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div class="w-full font-medium text-gray-700 dark:text-white">
                                <div class="flex justify-between items-center">
                                    <div class="flex-none opacity-0 transition-opacity duration-300 group-hover:opacity-100">
                                        <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="square" stroke-linejoin="round" stroke-width="2" d="M7 19H5a1 1 0 0 1-1-1v-1a3 3 0 0 1 3-3h1m4-6a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm7.4 1.6a2 2 0 0 1 0 2.7l-6 6-3.4.7.7-3.4 6-6a2 2 0 0 1 2.7 0Z"/>
                                        </svg>
                                    </div>
                                    <div id="history_customer_name_span" class="flex-grow -ml-2 transition-all duration-300 group-hover:m-0 group-hover:translate-x-2">Customer Name</div>
                                    <span id="history_customer_phone_span" class="flex-none whitespace-nowrap text-gray-500 dark:text-gray-400">customer_phone</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <div id="history_customer_created_span" class="text-xs text-slate-400 dark:text-gray-500">Created at Month YEAR</div>
                                    <span id="history_customer_email_span" class="text-sm text-gray-500 dark:text-gray-400">customer_mail</span>
                                </div>
                                <div class="flex w-full text-sm p-2 mt-2 border-l-4 border-slate-200 dark:border-gray-950 dark:bg-slate-900 bg-slate-50 rounded-lg">
                                    <span id="history_customer_comment_span" class="text-md inline-flex text-slate-500 dark:text-slate-200 ">Commentaire client</span>
                                </div>
                            </div>                 
                            
                        </div>
                    </div>

                <h3 id="modal-title_customer_finance_total" class="flex items-center text-lg leading-6 font-medium"><!-- JavaScript print Date du jour --></h3>
                
                <div class="flex flex-col ">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 ">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-4 py-3">
                                    Type
                                </th>
                                <th scope="col" class="px-2 py-3">
                                </th>
                                <th scope="col" class="px-4 py-3">
                                    Service
                                </th>
                                <th scope="col" class="text-center px-4 py-3">
                                    Date
                                </th>
                                <th scope="col" class="px-4 py-3">
                                    Encaissé
                                </th>
                                <th scope="col" class="px-4 py-3">
                                    Tarif
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-transparent border-0" id="CustomerDetailsContainer">

                            <!-- JavaScript will populate this area -->

                        </tbody>
                    </table>
                </div>
                </div>
                </div>
            </div>

</div>
