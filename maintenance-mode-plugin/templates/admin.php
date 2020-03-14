<div class="wrap">
    <h1>Maintenance Mode Plugin</h1>

    <ul class="nav nav-tabs">
        <li class="active"><a href="#tab-1">Main settings</a></li>
        <li><a href="#tab-2">IP management</a></li>
        <li><a href="#tab-3">Schedule</a></li>
        <li><a href="#tab-4">About plugin</a></li>
    </ul>

    <div class = "tab-content">
        <div id="tab-1" class="tab-pane active">
            <form action="options.php" method="post">
                <?php
                settings_fields($this->prefix.'general');
                do_settings_sections($this->pageName);

                submit_button();
                ?>
            </form>
        </div>

        <div id="tab-2" class="tab-pane">
            <h3>IP management</h3>
        </div>

        <div id="tab-3" class="tab-pane">
            <h3>Schedule</h3>
        </div>

        <div id="tab-4" class="tab-pane">
            <h3>About plugin</h3>
        </div>
    </div>


</div>