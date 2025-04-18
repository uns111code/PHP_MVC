<?php foreach ($_SESSION['flash'] ?? [] as $type => $message): ?>

    <div class="alert alert-<?= $type ?>" role="alert">
        
            <?php echo $message;
                unset($_SESSION['flash'][$type]); 
            ?>
        
    </div>

<?php endforeach; ?>