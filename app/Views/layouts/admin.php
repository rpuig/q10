<!DOCTYPE html>
<html>
<head>
    <!-- Your common head content goes here -->
</head>
<body>
    <!-- Header and other common content -->
    <?php echo render_menu(); ?>

    
    <!-- Main content of each page -->
    <?= $this->renderSection('content') ?>
    
    <!-- Footer and other common content -->
    
    <!-- Debugger Toolbar -->
</body>
</html>
