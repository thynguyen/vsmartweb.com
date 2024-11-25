<?php

/*
 * ==========================================================
 * ADMINISTRATION PAGE
 * ==========================================================
 *
 * Administration page to manage the settings and reply to the users.
 *
 */

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
global $SB_CONNECTION;
define('SB_PATH', getcwd());
if (!file_exists('config.php')) {
    $raw = str_replace(['[url]', '[name]', '[user]', '[password]', '[host]', '[port]'], '', file_get_contents('resources/config-source.php'));
    $file = fopen('config.php', 'w');
    fwrite($file, $raw);
    fclose($file);
}
require('config.php');
require('include/functions.php');
$connection_check = sb_db_check_connection();
if ($connection_check === true) {
    sb_updates_check();
}
require('include/components.php');

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no" />
    <meta name="theme-color" content="#566069" />
    <title><?php echo sb_get_setting('admin-title') ? sb_get_setting('admin-title') : 'Support Board' ?></title>
    <script src="js/min/jquery.min.js"></script>
    <script src="js/main.js?v=<?php echo SB_VERSION ?>"></script>
    <script src="js/admin.js?v=<?php echo SB_VERSION ?>"></script>
    <link rel="stylesheet" type="text/css" href="css/min/admin.min.css?v=<?php echo SB_VERSION ?>" media="all" />
    <link rel="shortcut icon" type="image/png" href="media/icon.png" />
    <link rel="apple-touch-icon" href="resources/pwa/icons/icon-192x192.png" />
    <link rel="manifest" href="resources/pwa/manifest.json" />
    
    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', function () {
                navigator.serviceWorker.register('sw.js').then(function (registration) {
                    registration.update();
                }).catch(function (error) {
                    console.log('Registration failed with ' + error);
                });
            });
        }
    </script>

    <?php
    if (sb_get_multi_setting('push-notifications', 'push-notifications-active') && sb_get_active_user()) {
        echo '<script src="https://js.pusher.com/beams/1.0/push-notifications-cdn.js"></script><script>window.navigator.serviceWorker.ready.then((serviceWorkerRegistration) => {
            const sb_beams_client = new PusherPushNotifications.Client({
                instanceId: "' . sb_get_multi_setting('push-notifications', 'push-notifications-id') . '",
                serviceWorkerRegistration: serviceWorkerRegistration,
            });
            sb_beams_client.start().then(() => sb_beams_client.setDeviceInterests(["' . sb_get_active_user()['id'] . '", "agents"])).catch(console.error);
        });</script>';
    }
    if ($connection_check === true) {
        sb_js_global();
        sb_js_admin();
    }
    ?>
</head>

<body>
    <?php
    if ($connection_check !== true) {
        sb_installation_box($connection_check);
        die();
    }
    sb_component_admin();
    ?>
</body>

</html>