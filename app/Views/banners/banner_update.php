<?php $modal_id = 'banner_update'; ?>
<div id="<?= $modal_id; ?>" tabindex="-1" class="text-white hidden rounded-full">
    <div class="flex justify-between items-center px-3 py-3 lg:px-8">
        <div class="flex-grow flex flex-col items-center justify-center text-left text-md font-normal" id="banner_update-text"></div>
        <button type="button" class="text-gray-700 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="authentication-modal" onclick="closex('<?= $modal_id ?>')">
            <svg class="w-5 h-5" aria-hidden="true" fill="none" viewBox="0 0 14 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
            </svg>
            <span class="sr-only">Fermer</span>
        </button>
    </div>
</div>
