<?php

$updaterBase         = 'https://projects.bluewindlab.net/wpplugin/zipped/plugins/';
$pluginRemoteUpdater = $updaterBase . 'bkbm/notifier_bkbm_dabp.php';
new WpAutoUpdater( BKBDABP_ADDON_CURRENT_VERSION, $pluginRemoteUpdater, BKBDABP_ADDON_UPDATER_SLUG );
