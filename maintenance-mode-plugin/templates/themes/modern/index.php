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
    <link href="<?php echo $this->themeUrl; ?>assets/css/page-loader.css" rel="stylesheet" type="text/css">
    <link href="<?php echo $this->themeUrl; ?>assets/css/page-normalize.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link href="<?php echo $this->themeUrl; ?>assets/css/page-style.css" rel="stylesheet" type="text/css">
    <!--[if lt IE 9]>
    <link rel="stylesheet" type="text/css" href="<?php echo $this->themeUrl; ?>assets/css/page-ie.css" />
    <![endif]-->

    <!-- Scripts -->
    <script src="<?php echo $this->themeUrl; ?>assets/js/page-jquery.js"></script>
</head>
<body>
<div class="preloader">
    <div class="loading">
        <h2>
            Loading...
        </h2>
        <span class="progress"></span>
    </div>
</div>

<div class="wrapper">
    <ul class="scene unselectable" data-friction-x="0.1" data-friction-y="0.1" data-scalar-x="25" data-scalar-y="15" id="scene">
        <li class="layer" data-depth="0.00">
        </li>
        <!-- BG -->

        <li class="layer" data-depth="0.10">
            <div class="background">
            </div>
        </li>

        <!-- Hero -->

        <li class="layer" data-depth="0.20">
            <div class="title">
                <h2>
                    <?php echo esc_attr($this->options['title']); ?>
                </h2>
                <span class="line"></span>
            </div>
        </li>

        <li class="layer" data-depth="0.25">
            <div class="sphere">

            </div>
        </li>

        <li class="layer" data-depth="0.30">
            <div class="hero">
                <h1 id="countdown">
                    The most spectacular coming soon template!
                </h1>

                <div class="sub-title">
                    <?php echo $this->options['description']; ?>
                </div>
            </div>
        </li>
        <!-- Flakes -->

        <li class="layer" data-depth="0.40">
            <div class="depth-1 flake1">
                <img alt="flake" src="<?php echo $this->themeUrl; ?>assets/img/flakes/depth1/flakes1.png">
            </div>

            <div class="depth-1 flake2">
                <img alt="flake" src="<?php echo $this->themeUrl; ?>assets/img/flakes/depth1/flakes2.png">
            </div>

            <div class="depth-1 flake3">
                <img alt="flake" src="<?php echo $this->themeUrl; ?>assets/img/flakes/depth1/flakes3.png">
            </div>

            <div class="depth-1 flake4">
                <img alt="flake" src="<?php echo $this->themeUrl; ?>assets/img/flakes/depth1/flakes4.png">
            </div>
        </li>

        <li class="layer" data-depth="0.50">
            <div class="depth-2 flake1">
                <img alt="flake" src="<?php echo $this->themeUrl; ?>assets/img/flakes/depth2/flakes1.png">
            </div>

            <div class="depth-2 flake2">
                <img alt="flake" src="<?php echo $this->themeUrl; ?>assets/img/flakes/depth2/flakes2.png">
            </div>
        </li>

        <li class="layer" data-depth="0.60">
            <div class="depth-3 flake1">
                <img alt="flake" src="<?php echo $this->themeUrl; ?>assets/img/flakes/depth3/flakes1.png">
            </div>

            <div class="depth-3 flake2">
                <img alt="flake" src="<?php echo $this->themeUrl; ?>assets/img/flakes/depth3/flakes2.png">
            </div>

            <div class="depth-3 flake3">
                <img alt="flake" src="<?php echo $this->themeUrl; ?>assets/img/flakes/depth3/flakes3.png">
            </div>

            <div class="depth-3 flake4">
                <img alt="flake" src="<?php echo $this->themeUrl; ?>assets/img/flakes/depth3/flakes4.png">
            </div>
        </li>

        <li class="layer" data-depth="0.80">
            <div class="depth-4">
                <img alt="flake" src="<?php echo $this->themeUrl; ?>assets/img/flakes/depth4/flakes.png">
            </div>
        </li>

        <li class="layer" data-depth="1.00">
            <div class="depth-5">
                <img alt="flake" src="<?php echo $this->themeUrl; ?>assets/img/flakes/depth5/flakes.png">
            </div>
        </li>
        <!-- Contact -->

        <li class="layer" data-depth="0.20">
            <div class="contact">
                <ul class="icons">
                    <li>
                        <a class="behance" href="#"><i class="fa fa-behance"></i></a>
                    </li>

                    <li>
                        <a class="twitter" href="#"><i class="fa fa-twitter"></i></a>
                    </li>

                    <li>
                        <a class="dribbble" href="#"><i class="fa fa-dribbble"></i></a>
                    </li>
                </ul>
                Coming Soon Plugin by <a href="https://razormeister.pl" style="target="_blank">RazorTeam</a> | Theme by <a href="https://themewagon.com/" target="_blank">ThemeWagon</a>
            </div>
        </li>
    </ul>
</div>

<!-- Javascript -->
<script src="<?php echo $this->themeUrl; ?>assets/js/page-plugins.js"></script>
<script src="<?php echo $this->themeUrl ?>assets/js/page-jquery.countdown.min.js"></script>
<script src="<?php echo $this->themeUrl; ?>assets/js/page-main.js"></script>

<script>
    <?php
        if (\MaintenanceModePlugin\Inc\Base\BaseController::$isSchedule) {
            $date = date('F d, Y H:i:s', \MaintenanceModePlugin\Inc\Base\BaseController::$scheduleEnd);
        } else {
            $date = "December 14, 2020 18:03:26";
        }
    ?>
    $('#countdown').countdown({
        date: "<?php echo $date ?>",
        render: function(data) {
            var el = $(this.el);
            el.empty()
                //.append("<div>" + this.leadingZeros(data.years, 4) + "<span>years</span></div>")
                .append("<div>" + this.leadingZeros(data.days, 2) + " <span>days</span></div>")
                .append("<div>" + this.leadingZeros(data.hours, 2) + " <span>hrs</span></div>")
                .append("<div>" + this.leadingZeros(data.min, 2) + " <span>min</span></div>")
                .append("<div>" + this.leadingZeros(data.sec, 2) + " <span>sec</span></div>");
        },
        onEnd: function() {
            window.location.reload(true);
        }
    });
</script>

</body>
</html>