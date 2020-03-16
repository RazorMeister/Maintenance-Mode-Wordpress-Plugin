<!DOCTYPE HTML>
<html lang="<?php language_attributes();?>">
<head>
    <!-- Title -->
    <meta

    <!-- Meta tags -->
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" >
    <meta name="generator" content="Maintenance Mode Plugin for WordPress">
    <meta name="author" content="Tymoteusz `RazorMeister` Bartnik">
    <meta name="author" content="Przemysław `lavar3l` Dominikowski">

    <!-- Styles -->
    <link rel="stylesheet" href="<?php echo $this->pluginUrl; ?>assets/css/global-styles.css">
</head>
<body>
    <div id="wrapper">
        <header>
            <h1><?php echo esc_attr($this->options['title']); ?></h1>
            <p>
                <?php echo esc_attr($this->options['description']); ?>
            </p>
        </header>
    </div>

    <!-- Scripts -->
    <script type="text/javascript" src=<?php echo $this->pluginUrl; ?>assets/js/global-scripts.js"></script>
</body>
</html>