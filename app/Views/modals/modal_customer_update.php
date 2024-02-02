<?php
$modal_id = "updateCustomerModal";
?>
<!-- UPDATE CUSTOMER - Modal Container -->
<div id="<?= $modal_id ?>-shadow_modal" class="fixed inset-0 bg-black opacity-50 hidden" onclick="closeModalById('<?= $modal_id ?>')"></div>
<div id="<?= $modal_id ?>" tabindex="-1" aria-hidden="true" class="flex h-full flex-grow hidden"  onclick="closeModalById('<?= $modal_id ?>')">

<div class="mx-auto max-w-md lg:max-w-lg">

        <!-- Modal Header -->
        <div id="header_<?= $modal_id ?>"></div>

        <div class="flex justify-center p-4 sm:p-9 overflow-y-auto" onclick="event.stopPropagation()">
            <div class="bg-white border border-gray-200 rounded-lg dark:bg-slate-800 dark:border-gray-800">
                <div class="px-4">

                    <form id="customerForm" class="space-y-6" method="post">
                        <input type="hidden" id="customer_id" name="customer_id">
                        
                        <div class="relative">
                            <input type="text" value='' id="customer_name" name="Name" class="block w-full text-md text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" >                        
                            <label for="customer_name" class="absolute text-md text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-slate-800 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">Client</label>
                        </div>

                        <div class="relative">
                            <input type="text" value='' id="customer_phone" name="Phone" class="block w-full text-md text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" >                        
                            <label for="customer_phone" class="absolute text-md text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-slate-800 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">Téléphone</label>
                        </div>                    
                        <div class="relative">
                            <input type="email" value='' id="customer_email" name="Email" class="block w-full text-md text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" >                        
                            <label for="customer_email" class="absolute text-md text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-slate-800 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">Email</label>
                        </div>
                        <div class="relative">
                            <textarea rows="3" value='' id="customer_comment" name="Comment" class="block w-full text-md text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" ></textarea>                        
                            <label for="customer_comment" class="absolute text-md text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-slate-800 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">Commentaire</label>
                        </div>
                        <button type="button" id="update_customer_submit_form" type="button"  class="sticky bottom-4 float-right mt-10 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 ">Enregistrer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> 