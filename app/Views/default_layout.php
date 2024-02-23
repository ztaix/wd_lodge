<?= $this->include('default_header') ?>
<div class="flex justify-center flex-grow w-full overflow-y-auto bg-slate-50 dark:bg-slate-900">

    <?php echo view('banners/banner_update'); ?>

    <?= $contents_views ?>

</div>
<?= $this->include('default_footer') ?>