<?php
include 'db.php';
include 'r1.php';

// set timestamp for run
mysql_query("INSERT INTO `host_log_poll` (poll_run_datetime) VALUES (UNIX_TIMESTAMP())");

// get ID of run
$thispollid = mysql_result(mysql_query("SELECT MAX(`id`) FROM `host_log_poll`"), 0);

// for each server
foreach ($config['servers'] as $thisServer) {
  // make a new XMLRPC API connection to the current server
  $r1 = new r1api($config['username'], $config['password'], $thisServer);

    // check to see if the current CDP server exists in the database.  If not, add it.
    $serverexists = mysql_num_rows(mysql_query("SELECT `id` FROM `server` WHERE `cdp_hostname` = '$thisServer'"));
    if ($serverexists == "0") {
      mysql_query("INSERT INTO `server` (`cdp_hostname`) 
      VALUES ('$thisServer')");
    } // if hostexists


  // get all the host [UU]IDs 
  foreach ($r1->getIDs() as $hostid) {
    // get information for each host as an array
    $thisHost = $r1->getHost($hostid);

    // check the ID of the CDP server
    $sqlHostServer = mysql_result(mysql_query("SELECT `id` FROM `server` WHERE `cdp_hostname` = '$thisServer' LIMIT 1"), 0);

    // check to see if the host exists in the database.  If not, add it.
    $hostexists = mysql_num_rows(mysql_query("SELECT `id` FROM `host` WHERE `hostID` = '$thisHost[hostID]'"));
    if ($hostexists == "0") {
      mysql_query("INSERT INTO `host` (`hostID`, `hostName`, `hostType`, `volumeID`, `cdp_server_id`) 
      VALUES ('$thisHost[hostID]', '$thisHost[hostName]', '$thisHost[hostType]', '$thisHost[volumeID]', '$sqlHostServer')");
    } // if hostexists

    // get the ID of the host
    $sqlhostid = mysql_result(mysql_query("SELECT `id` FROM `host` WHERE `hostID` = '$thisHost[hostID]'"), 0);
    // insert the data that can change between runs into the host_log table
    mysql_query("
     INSERT INTO `host_log`
      (`host_id`,
       `poll_id`,
       `isEnabled`,
       `isControlPanelModuleEnabled`,
       `quota`, 
       `diskUsage`)
     VALUES (
       '$sqlhostid',
       '$thispollid',
       '$thisHost[isEnabled]',
       '$thisHost[isControlPanelModuleEnabled]',
       '$thisHost[quota]',
       '$thisHost[diskUsage]'
   )", $conn);

    // unset stuff so it won't carry over into the next loop
    unset($thisHost);
    unset($hostexists);

  } //foreach hostid
  // release the API instance
  unset($r1);

} // foreach server

?>
