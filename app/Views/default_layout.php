<?= $this->include('default_header') ?>
<div class="flex-grow overflow-y-auto">

        <div class='content text-gray-900 dark:text-white bg-slate-50 dark:bg-slate-900'>

                <?php echo view('banners/banner_update'); ?>


                <?= $contents_views ?>


        </div>
</div>
<?= $this->include('default_footer') ?>