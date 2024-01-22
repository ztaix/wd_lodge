<?= $this->include('default_header') ?>
<div class="flex justify-center flex-grow w-full overflow-y-auto">

                <?php echo view('banners/banner_update'); ?>

                <?= $contents_views ?>

</div>
<?= $this->include('default_footer') ?>