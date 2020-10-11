<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Kurs</title>
    <!-- für bootstrap unterstützung -->
    <link rel="stylesheet" type="text/css" href="/css/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="/css/styles.css">
    <script src="/js/jquery-3.5.1.min.js"></script>
    <script src="/js/bootstrap/bootstrap.min.js"></script>
    <!-- bootstrap ende -->
</head>

<body>
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container">
            <?php require_once 'inc/top_navigation.php'; ?>
        </div>
    </nav>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12 mt-3">
                <div class="card">

                    <?php if (isset($title)) : ?>
                        <div class="card-header">
                            <h3><?php echo $title; ?></h3>
                        </div>
                    <?php endif; ?>

                    <div class="card-body">

                        <!-- here comes the content of the page -->