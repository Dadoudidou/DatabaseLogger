<?php
/* @var $this App\View\AppView */
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $this->fetch('title') ?>
    </title>
    
    <?= $this->Html->css("DatabaseLogger./vendors/bootstrap/css/bootstrap.min.css") ?>
    <?= $this->Html->css("DatabaseLogger./vendors/bootstrap/css/bootstrap-theme.min.css") ?>
    <style>
	html, body { font-size: 12px;  }
    </style>
</head>
<body>
    <?= $this->fetch('content') ?>
    
    <script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
    <?= $this->Html->script("DatabaseLogger./vendors/bootstrap/js/bootstrap.min.js"); ?>
    
    <?= $this->fetch('scriptBottom') ?>
</body>
</html>
