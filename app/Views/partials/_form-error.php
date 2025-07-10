<?php if (session('validation')) { ?>
    <div class="container">
        <?php foreach(session('validation')->getErrors() as $error) { ?>
            <div class="alert alert-danger">
                <?= $error ?>
            </div>
        <?php } ?>
    </div>
<?php } ?>