<?php
$modal_id= "CustomerInfoModal";
?>

<!-- DETAILS EVENTS - Modal Container -->
<div id="<?= $modal_id ?>-shadow_modal" class="fixed inset-0 bg-black opacity-50 hidden" onclick="closeModalById('<?= $modal_id ?>')"></div>

<div id="<?= $modal_id ?>" tabindex="-1" aria-hidden="true" class="flex h-full flex-grow hidden" onclick="closeModalById('<?= $modal_id ?>')">

    <div class="mx-auto max-w-md lg:max-w-lg">

            <!-- Modal Header -->
            <div id="header_<?= $modal_id ?>"></div>

            <!-- Modal Body -->
            <div id="body_<?= $modal_id ?>" class="flex justify-center p-4 overflow-y-auto" onclick="event.stopPropagation()">

                <div class="bg-white border border-gray-200 rounded-lg dark:bg-slate-800 dark:border-gray-800">
                
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
                
                <div class="overflow-x-auto mb-2">

                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 ">
                        <thead id="CustomerInfoModal_th" class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="pl-4 py-3">
                                    Réf.
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
                        <tbody class="bg-transparent border-0" id="CustomerInfoModal_tbody">

                            <!-- JavaScript will populate this area -->

                        </tbody>
                    </table>
                </div>
                </div>
            </div>
    </div>
</div>
