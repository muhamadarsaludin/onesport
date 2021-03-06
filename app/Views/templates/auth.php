<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="<?= base_url('img/logos/logo-gram.svg'); ?>" type="image/x-icon">
    <title><?= $title; ?></title>
    <?= $this->include('templates/_style.php'); ?>
</head>

<body>
    <?= $this->renderSection('content'); ?>

    <?= $this->include('templates/_script.php'); ?>
</body>

</html>