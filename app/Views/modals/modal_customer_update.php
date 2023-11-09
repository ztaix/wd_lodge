<?php
$modal_id = "updateCustomerModal";
?>
<!-- ADD EVENTS - Modal Container -->
<div id="<?= $modal_id ?>" tabindex="-1" aria-hidden="true" class="fixed w-full h-full inset-0 hidden z-50 overflow-auto ">
    <div class="relative h-full bg-white rounded-lg shadow dark:bg-gray-700  flex justify-center ">

        <!-- Modal content -->
        <div class="max-w-4xl">


            <!-- Modal Header -->
            <div class="px-6 py-6 lg:px-8 flex justify-between items-center">

                <div class="flex-grow text-center">
                    <h3 id="Update_customer_Modal_title" class="text-center text-2xl font-bold text-gray-800 dark:text-white">Client</h3>
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

            <div class="px-6 py-6 lg:px-8" >
                <form id="customerForm" class="space-y-6" method="post">
                    <input type="hidden" id="customer_id" name="customer_id">
                    
                    <div class="relative">
                        <input type="text" value='' id="customer_name" name="Name" class="block w-full text-md text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" >                        
                        <label for="Name" class="absolute text-md text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-700 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">Client</label>
                    </div>
    
                    <div class="relative">
                        <input type="text" value='' id="customer_phone" name="Phone" class="block w-full text-md text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" >                        
                        <label for="Phone" class="absolute text-md text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-700 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">Téléphone</label>
                    </div>                    
                    <div class="relative">
                        <input type="email" value='' id="customer_email" name="Email" class="block w-full text-md text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" >                        
                        <label for="Email" class="absolute text-md text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-700 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">Email</label>
                    </div>
                    <div class="relative">
                        <textarea rows="3" value='' id="customer_comment" name="Comment" class="block w-full text-md text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" ></textarea>                        
                        <label for="Comment" class="absolute text-md text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-700 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">Commentaire</label>
                    </div>
                    <button type="button" id="cancel_customer_submit_form" type="button"  class="sticky bottom-10 float-left mt-10 text-white bg-gray-700 hover:bg-gray-800 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-gray-600 dark:hover:bg-gray-700 focus:outline-none dark:focus:ring-gray-800 ">Annuler</button>
                    <button type="button" id="update_customer_submit_form" type="button"  class="sticky bottom-10 float-right mt-10 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 ">Enregistrer</button>
                </form>
            </div>
        </div>
    </div>
</div> 