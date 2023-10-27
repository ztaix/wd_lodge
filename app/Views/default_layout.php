<?= $this->include('default_header') ?>

<div class='content'>
        
<?php echo view('banners/banner_search'); ?>
<?php echo view('banners/banner_update'); ?>


        <?= $contents_views ?>

  
</div>
<?= $this->include('default_footer') ?>
