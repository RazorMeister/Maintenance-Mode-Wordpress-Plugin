<script src="https://kit.fontawesome.com/77b6468d65.js" crossorigin="anonymous"></script>
<h1 class="plugintitle-h1">Maintenance Mode Plugin</h1>
<a class="button button-primary button-preview" href="<?php echo site_url('index.php?maintenanceModePreview=true') ?>" target="_blank"><i class="fa fa-search"></i> <?php _e('Preview', $this->pluginName) ?></a>
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
            <div class="info-box"><?php _e('IP whitelisting is a security feature used for limiting and controlling access only to trusted users. IP whitelisting allows you to create lists of trusted IP addresses or IP ranges from which you can access your website without seeing maintenance page.', $this->pluginName) ?></div>
            <div class="info-box"><?php _e('Please note that most home networks are likely to have a dynamic IP address. A dynamic IP address is an IP address that changes from time to time unlike a static IP address. Instead of one IP address always being allocated to your home network (static IP), your IP address is pulled from a pool of addresses and then assigned to your home network by your ISP. After a few days, weeks or sometimes months that IP address is put back into the pool and you are assigned a new IP address.', $this->pluginName) ?></div>

            <form action="options.php" method="post">
                <div class="current-ip-rules">
                    <div class="tablecontainer">
                        <table>
                            <thead>
                            <tr>
                                <th><?php _e('Excluded IP addresses', $this->pluginName) ?></th>
                                <th colspan="3"></th>
                            </tr>
                            <tr class="headingTr">
                                <th><?php _e('Start IP address', $this->pluginName) ?></th>
                                <th><?php _e('End IP address', $this->pluginName) ?></th>
                                <th><?php _e('Remove', $this->pluginName) ?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            if(is_array($this->options['ipWhitelist']) && count($this->options['ipWhitelist']) > 0) {
                                $clientAddress = \IPLib\Factory::addressFromString($this->userIp);
                                foreach (array_keys($this->options['ipWhitelist']) as $key) {
                                    $range = \IPLib\Factory::rangeFromString($this->options['ipWhitelist'][$key]);
                                    $start = (string) $range->getStartAddress();
                                    $end = (string) $range->getEndAddress();
                                    echo '<tr>
                                        <td>'.$start.($clientAddress->matches($range) ? ' ('.__('Includes your IP address', $this->pluginName).')' : '').'</td>
                                        <td>'.($start != $end ? $end : '---').'</td>
                                        <td><input type="checkbox" name="'.$this->prefix.'ipManagement[delete]['.$key.']"></td>
                                    </tr>';
                                }
                            } else
                                 echo '<tr><td>---</td><td>---</td><td>---</td></tr>';
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <h3><?php _e('Add new IP address', $this->pluginName) ?></h3>
                <?php _e('Your IP address: ', $this->pluginName) ?><?php echo $this->userIp ?>

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
            <div class="info-box"><?php _e('Maintenance scheduling is a feature used to plan the time when your website will have ongoing intended maintenance (such as installing updates, hotfixes or provisioning major changes). Maintenance mode plugin will activate itself automatically when the time comes.', $this->pluginName) ?></div>
            <div class="info-box"><?php _e('You can specify multiple date and time ranges.', $this->pluginName) ?></div>
            <div class="info-box"><?php _e('If you choose “Modern Theme” the countdown on maintenance page will automagically count to the first end date.', $this->pluginName) ?></div>
            </h3>
            <form action="options.php" method="post">
                <?php settings_fields($this->prefix . 'schedule'); ?>

                <div class="current-schedules">
                    <div class="tablecontainer">
                        <table>
                            <thead>
                                <tr>
                                    <th><?php _e('Scheduled maintenance', $this->pluginName) ?></th>
                                    <th colspan="3"></th>
                                </tr>
                                <tr class="headingTr">
                                    <th><?php _e('Start date', $this->pluginName) ?></th>
                                    <th><?php _e('End date', $this->pluginName) ?></th>
                                    <th><?php _e('Remove', $this->pluginName) ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if(is_array($this->options['dateStart']) && count($this->options['dateStart']) > 0) {
                                    foreach (array_keys($this->options['dateStart']) as $key)
                                        echo '<tr>
                                            <td>'.date('d-m-Y H:i', $this->options['dateStart'][$key]).'</td>
                                            <td>'.date('d-m-Y H:i', $this->options['dateEnd'][$key]).'</td>
                                            <td><input type="checkbox" name="'.$this->prefix.'schedule[delete]['.$key.']"></td>
                                        </tr>';
                                } else
                                     echo '<tr><td>---</td><td>---</td><td>---</td></tr>';
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <h3><?php _e('Schedule new maintenance time', $this->pluginName) ?></h3>
               <?php _e('Current time:', $this->pluginName) ?> <?php echo date('d-m-Y H:i:s', current_time('U')) ?>
                <?php
                    do_settings_sections($this->prefix . 'schedule');
                    submit_button(null, 'primary', 'saveSchedule');
                ?>
            </form>
        </section>
        <section>
            <h2><?php _e('About plugin', $this->pluginName) ?></h2>
            <div class="info-box"><?php _e('Maintenance Mode Plugin is a small plugin that replaces your website with a splash page which explains why it\'s offline and when you can expect it to be live again. It is possible to operate it manually or using schedule and IP whitelisting.', $this->pluginName) ?></div>

            <h3><?php _e('Authors', $this->pluginName) ?></h3>
            <span><?php _e('Tymoteusz \'RazorMeister\' Bartnik & Przemysław \'lavar3l\' Dominikowski', $this->pluginName) ?></span>

            <h3><?php _e('Repository', $this->pluginName) ?></h3>
            <span><?php _e('Feel free to visit our', $this->pluginName) ?> <a href="https://github.com/RazorMeister/Maintenance-Mode-Wordpress-Plugin" target="_blank"><?php _e('GitHub repository!', $this->pluginName) ?></a></span>

            <h3><?php _e('License', $this->pluginName) ?></h3>
            <span><?php _e('This work is licensed under the European Union Public License v. 1.2. For further details visit our', $this->pluginName) ?> <a href="https://github.com/RazorMeister/Maintenance-Mode-Wordpress-Plugin/blob/master/LICENSE.md" target="_blank"><?php _e('GitHub repo', $this->pluginName) ?></a>.</span>
        </section>
    </div>
</div>

<script>
	jQuery(document).ready(function( $ ) {
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
				console.log(date);
				$(".dateStart").val(dayjs(date).format("DD-MM-YYYY HH:mm"));
				dateStartIsOpen = false;
			} else {
				$(".dateEnd").val(dayjs(date).format("DD-MM-YYYY HH:mm"));
				dateEndIsOpen = false;
			}
		});
	});
</script>
