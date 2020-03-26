<!--[if IE 8 ]><html class="ie" xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!-->
<!DOCTYPE html>
<html lang="<?php language_attributes();?>">
<!--<![endif]-->

<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>
        Coming soon!
    </title><!-- Behavioral Meta Data -->
    <meta content="yes" name="apple-mobile-web-app-capable">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport"><!-- Core Meta Data -->
    <meta name="generator" content="Maintenance Mode Plugin for WordPress">
    <meta name="author" content="Tymoteusz `RazorMeister` Bartnik">
    <meta name="author" content="Przemysław `lavar3l` Dominikowski">

    <link href="favicon.png" rel="shortcut icon" type="image/png">

    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Styles -->
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,100,900' rel='stylesheet' type='text/css'><!-- Styles -->
    <link href="<?php echo $this->themeUrl; ?>assets/css/page-style.css" rel="stylesheet" type="text/css">
    <!-- Scripts -->

</head>

<body>
<div class="bodycontainer">
    <div class="textcontainer">
        <h1><?php echo esc_attr($this->options['title']); ?></h1>
    </div>
    <div class="textcontainer">
        <div class="plaintext">
            <?php echo $this->options['description']; ?>
        </div>
    </div>
</div>




<!-- Javascript -->

</body>
</html>