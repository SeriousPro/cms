<?php
/**
 * User: Marcel 'CoNfu5eD Naeve <confu5ed@serious-pro.de>
 * Date: 05.03.2016
 * Time: 13:49
 */
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:og="http://ogp.me/ns#" lang="<?php echo $_SESSION['language']; ?>">
<head>
    <!--[if lte IE 8]><script type="text/javascript" src="<?php echo Url::media('themes/default_v1/js/html5shiv.js'); ?>"></script><![endif]-->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--[if IE]><meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1'><![endif]-->

    <script src="https://code.jquery.com/jquery-2.2.1.min.js" integtity="sha384-f02fb76d6fc0adb5e29ec25db808e6f4eed6367b8e70ef81a24fd549c4588a46b0b6fcf864fae95ed19f2887b033d74a" crossorigin="anonymous"></script>


    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="<?php echo Url::media('themes/default_v1/css/theme.css'); ?>">

    <?php Plugin::head(Plugin::select(), $_GET['params']); ?>
</head>
<body>
    <header>
        <?php Plugin::breadcrumbs(Plugin::select(), $_GET['params']); ?>
    </header>
    <div class="container">
        <section class="row">
            <?php Plugin::body(Plugin::select(), $_GET['params']); ?>
        </section>
        <footer class="row">

        </footer>
    </div>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
</body>
</html>
