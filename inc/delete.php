     <?php
        if (!empty($_SESSION['delete'])) { ?>
             <div class="alert   w-100 text-center lead  alert-success"><?php echo $_SESSION['delete'] ?> &#128522;</div>
     <?php ;
        };
        unset($_SESSION['delete']);
        ?>