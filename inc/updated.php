     <?php
        if (!empty($_SESSION['updated'])) { 
         foreach ($_SESSION['updated'] as $updated) {
            # code...
         
         ?>
             <div class="alert   w-100 text-center lead  alert-success"><?php echo $updated ?> &#128522;</div>
     <?php ;
         }
      };
        unset($_SESSION['updated']);
        ?>