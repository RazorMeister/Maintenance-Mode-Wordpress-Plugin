<div class="wrap">
    <h1>Maintenance Mode Plugin</h1>

    <form action="options.php" method="post">
        <?php
            settings_fields($this->prefix.'general');
            do_settings_sections($this->pageName);

            submit_button();
        ?>
    </form>
</div>