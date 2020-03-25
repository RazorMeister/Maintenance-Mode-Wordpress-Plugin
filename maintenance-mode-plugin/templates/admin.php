<script src="https://kit.fontawesome.com/77b6468d65.js" crossorigin="anonymous"></script>
<h1 class="plugintitle-h1">Maintenance Mode Plugin</h1>
<div class="tabs">

    <input type="radio" id="tab1" name="tab-control" class="tab-control" <?php if((isset($_COOKIE['MMP_currentTabId']) && $_COOKIE['MMP_currentTabId'] == 'tab1') || !isset($_COOKIE['MMP_currentTabId'])) echo 'checked'; ?>>
    <input type="radio" id="tab2" name="tab-control" class="tab-control" <?php if(isset($_COOKIE['MMP_currentTabId']) && $_COOKIE['MMP_currentTabId'] == 'tab2') echo 'checked'; ?>>
    <input type="radio" id="tab3" name="tab-control" class="tab-control" <?php if(isset($_COOKIE['MMP_currentTabId']) && $_COOKIE['MMP_currentTabId'] == 'tab3') echo 'checked'; ?>>
    <input type="radio" id="tab4" name="tab-control" class="tab-control" <?php if(isset($_COOKIE['MMP_currentTabId']) && $_COOKIE['MMP_currentTabId'] == 'tab4') echo 'checked'; ?>>
    <ul>
        <li title="<?php _e('Main Settings', $this->pluginName) ?>">
            <label for="tab1" role="button">
                <svg viewBox="0 0 24 24">
                    <path d="M14,2A8,8 0 0,0 6,10A8,8 0 0,0 14,18A8,8 0 0,0 22,10H20C20,13.32 17.32,16 14,16A6,6 0 0,1 8,10A6,6 0 0,1 14,4C14.43,4 14.86,4.05 15.27,4.14L16.88,2.54C15.96,2.18 15,2 14,2M20.59,3.58L14,10.17L11.62,7.79L10.21,9.21L14,13L22,5M4.93,5.82C3.08,7.34 2,9.61 2,12A8,8 0 0,0 10,20C10.64,20 11.27,19.92 11.88,19.77C10.12,19.38 8.5,18.5 7.17,17.29C5.22,16.25 4,14.21 4,12C4,11.7 4.03,11.41 4.07,11.11C4.03,10.74 4,10.37 4,10C4,8.56 4.32,7.13 4.93,5.82Z"/>
                </svg>
                <br><span><?php _e('Main Settings', $this->pluginName) ?></span>
            </label>
        </li>
        <li title="<?php _e('IP Management', $this->pluginName) ?>">
            <label for="tab2" role="button">
                <i class="fas fa-globe"></i>
                <br><span><?php _e('IP Management', $this->pluginName) ?></span>
            </label>
        </li>
        <li title="<?php _e('Schedule', $this->pluginName) ?>">
            <label for="tab3" role="button">
                <i class="fas fa-calendar-check"></i>
                <br><span><?php _e('Schedule', $this->pluginName) ?></span>
            </label>
        </li>
        <li title="<?php _e('About plugin', $this->pluginName) ?>">
            <label for="tab4" role="button">
                <i class="fas fa-info-circle"></i>
                <br><span><?php _e('About plugin', $this->pluginName) ?></span>
            </label>
        </li>
    </ul>

    <div class="slider">
        <div class="indicator"></div>
    </div>
    <div class="content">
        <section>
            <h2><?php _e('Main Settings', $this->pluginName) ?></h2>
            <form action="options.php" method="post">
            <?php
                settings_fields($this->prefix . 'general');
                do_settings_sections($this->prefix . 'general');

                submit_button(null, 'primary', 'saveGeneral');
            ?>
            </form>
        </section>
        <section>
            <h2><?php _e('IP Management', $this->pluginName) ?></h2>
            <?php _e('IP whitelisting is a security feature used for limiting and controlling access only to trusted users. IP whitelisting allows you to create lists of trusted IP addresses or IP ranges from which you can access your website without seeing maintenance page.', $this->pluginName) ?>
            <br>
            <br>
            <?php _e('Please note that most home networks are likely to have a dynamic IP address. A dynamic IP address is an IP address that changes from time to time unlike a static IP address. Instead of one IP address always being allocated to your home network (static IP), your IP address is pulled from a pool of addresses and then assigned to your home network by your ISP. After a few days, weeks or sometimes months that IP address is put back into the pool and you are assigned a new IP address.', $this->pluginName) ?>
            <h3><?php _e('Your IP address: ', $this->pluginName) ?><?php echo $this->userIp ?></h3>
            <form action="options.php" method="post">
                <?php
                settings_fields($this->prefix . 'ipManagement');
                do_settings_sections($this->prefix . 'ipManagement');

                submit_button(null, 'primary', 'saveIpManagement');
                ?>
            </form>
        </section>
        </section>
        <section>
            <h2><?php _e('Schedule', $this->pluginName) ?></h2>
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quam nemo ducimus eius, magnam error quisquam sunt
            voluptate labore, excepturi numquam! Alias libero optio sed harum debitis! Veniam, quia in eum.
            <h3>Obecna data: <?php echo date('d-m-Y H:i:s', current_time('U')) ?>
            </h3>
            <form action="options.php" method="post">
                <?php settings_fields($this->prefix . 'schedule'); ?>

                <div class="current-schedules">
                    <table class="table" border="1">
                        <tr>
                            <td>Data start</td>
                            <td>Data end</td>
                            <td>Usuń</td>
                        </tr>
                        <?php
                        if(is_array($this->options['dateStart']))
                            foreach (array_keys($this->options['dateStart']) as $key)
                            echo '<tr>
                                    <td>'.date('d-m-Y H:i', $this->options['dateStart'][$key]).'</td>
                                    <td>'.date('d-m-Y H:i', $this->options['dateEnd'][$key]).'</td>
                                    <td><input type="checkbox" name="'.$this->prefix.'schedule[delete]['.$key.']"></td>
                                </tr>';
                        ?>
                    </table>
                </div>

                <?php
                    do_settings_sections($this->prefix . 'schedule');
                    submit_button(null, 'primary', 'saveSchedule');
                ?>
            </form>
        </section>
        <section>
            <h2><?php _e('About plugin', $this->pluginName) ?></h2>
            <?php _e('Maintenance Mode Plugin is a small plugin that replaces your website with a splash page which explains why it\'s offline and when you can expect it to be live again. It is possible to operate it manually or using schedule and IP whitelisting.', $this->pluginName) ?>

            <h3><?php _e('Authors', $this->pluginName) ?></h3>
            <?php _e('Tymoteusz \'RazorMeister\' Bartnik & Przemysław \'lavar3l\' Dominikowski', $this->pluginName) ?>

            <h3><?php _e('Repository', $this->pluginName) ?></h3>
            <?php _e('Feel free to visit our', $this->pluginName) ?> <a href="https://github.com/RazorMeister/Maintenance-Mode-Wordpress-Plugin" target="_blank"><?php _e('GitHub repository!', $this->pluginName) ?></a>

            <h3><?php _e('License', $this->pluginName) ?></h3>
            <?php _e('This work is licensed under the European Union Public License v. 1.2. For further details visit our', $this->pluginName) ?> <a href="https://github.com/RazorMeister/Maintenance-Mode-Wordpress-Plugin/blob/master/LICENSE.md" target="_blank"><?php _e('GitHub repo', $this->pluginName) ?></a>.
        </section>
    </div>
</div>

<script>
    let  dateStartIsOpen = false;
    let  dateEndIsOpen = false;
    let picker = new SimplePicker({
        zIndex: 10
    });

    $(".dateStart").click(function() {
        if (dateStartIsOpen) {
            picker.close();
            dateStartIsOpen = false;
        } else {
            picker.open();
            dateStartIsOpen = true;
        }
    });

    $(".dateEnd").click(function() {
        if (dateEndIsOpen) {
            picker.close();
            dateEndIsOpen = false;
        } else {
            picker.open();
            dateEndIsOpen = true;
        }
    });

    picker.on('close', function(date){
        dateStartIsOpen = false;
        dateEndIsOpen = false;
    });


    picker.on("submit", function(date, readableDate){
        if (dateStartIsOpen) {
            $(".dateStart").val(readableDate);
            dateStartIsOpen = false;
        } else {
            $(".dateEnd").val(readableDate);
            dateEndIsOpen = false;
        }
    });
</script>
