<?php $modal_id = 'banner_update'; ?>
<div id="<?= $modal_id; ?>" tabindex="-1" class="text-white hidden rounded-full">

    <div class="px-3 py-3 lg:px-8 flex justify-between items-center ">
        <div class="hidden">
            <a href="https://flowbite.com/" class="flex items-center mb-2 border-gray-200 md:pr-4 md:mr-4 md:border-r md:mb-0 dark:border-gray-600">
                <img src="https://flowbite.com/docs/images/logo.svg" class="h-6 mr-2" alt="Flowbite Logo">
                <span class="self-center text-lg font-semibold whitespace-nowrap dark:text-white">Flowbite</span>
            </a>
        </div>
        <div class="flex-grow text-center">
            <p id="banner_update-text" class="flex items-center text-sm font-normal">Message banner</p>
        </div>
        <div>
            <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="authentication-modal" onclick="closex('<?= $modal_id ?>')">
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                </svg>
                <span class=" sr-only">Fermer</span>
            </button>
        </div>
    </div>
</div>