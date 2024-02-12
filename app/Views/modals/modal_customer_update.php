<?php
$modal_id = "updateCustomerModal";
?>
<!-- UPDATE CUSTOMER - Modal Container -->
<div id="<?= $modal_id ?>-shadow_modal" class="fixed inset-0 bg-black opacity-50 hidden" onclick="closeModalById('<?= $modal_id ?>')"></div>
<div id="<?= $modal_id ?>" tabindex="-1" aria-hidden="true" class="flex h-full flex-grow hidden"  onclick="closeModalById('<?= $modal_id ?>')">

<div class="mx-auto max-w-md lg:max-w-lg">

        <!-- Modal Header -->
        <div id="header_<?= $modal_id ?>"></div>

        <div id="body_<?= $modal_id ?>" class="flex justify-center p-4 sm:p-9 overflow-y-auto" onclick="event.stopPropagation()">
            <div class="bg-white border border-gray-200 rounded-lg dark:bg-slate-800 dark:border-gray-800">
                <div class="px-4">

                    <form id="customerForm" class="space-y-6" method="post">
                        <input type="hidden" id="customer_id" name="customer_id">
                        
                        
                        <div class="py-2 px-3 bg-white border border-gray-200 rounded-lg dark:bg-slate-900 dark:border-gray-700" data-hs-input-number>
                            <div class="w-full flex justify-between items-center gap-x-5">

                                <div class="grow">
                                <span class="block text-xs text-gray-500 dark:text-gray-400">
                                    Client
                                </span>
                                <input id="customer_name" class="w-full p-0 bg-transparent border-0 text-gray-800 focus:ring-0 dark:text-white
                                focus:outline-none" type="text" value="" name="Name" >
                                </div>
                            </div>
                        </div>
                        
                        <div class="py-2 px-3 bg-white border border-gray-200 rounded-lg dark:bg-slate-900 dark:border-gray-700" data-hs-input-number>
                            <div class="w-full flex justify-between items-center gap-x-5">

                                <div class="grow">
                                    <span class="block text-xs text-gray-500 dark:text-gray-400">
                                    Téléphone
                                </span>
                                <input id="customer_phone" name="Phone" class="w-full p-0 bg-transparent border-0 text-gray-800 focus:ring-0 dark:text-white
                                focus:outline-none" type="text" value="" name="Phone" >
                            </div>
                            </div>
                        </div>
                        
                        <div class="py-2 px-3 bg-white border border-gray-200 rounded-lg dark:bg-slate-900 dark:border-gray-700" data-hs-input-number>
                            <div class="w-full flex justify-between items-center gap-x-5">
                                
                                <div class="grow">
                                    <span class="block text-xs text-gray-500 dark:text-gray-400">
                                        Email
                                    </span>
                                <input id="customer_email" class="w-full p-0 bg-transparent border-0 text-gray-800 focus:ring-0 dark:text-white
                                focus:outline-none" type="email" value="" name="Email" >
                            </div>
                            </div>
                        </div>
                        
                        <div class="py-2 px-3 bg-white border border-gray-200 rounded-lg dark:bg-slate-900 dark:border-gray-700" data-hs-input-number>
                            <div class="w-full flex justify-between items-center gap-x-5">

                                <div class="grow">
                                <span class="block text-xs text-gray-500 dark:text-gray-400">
                                    Commentaire
                                </span>
                                <textarea rows="3" id="customer_comment" class="w-full p-0 bg-transparent border-0 text-gray-800 focus:ring-0 dark:text-white
                                focus:outline-none"  value="" name="Comment" ></textarea>
                                </div>
                            </div>
                        </div>
                        
                        <button type="button" id="update_customer_submit_form"  type="button"  class="sticky bottom-4 float-right mt-10 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 ">Enregistrer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> 