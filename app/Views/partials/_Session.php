<?php if (session('mensaje')) {
?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?php echo session('mensaje') ?>
         <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <br>
<?php } ?>