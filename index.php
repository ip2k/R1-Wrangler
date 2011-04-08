<?php
include 'header.html';
include 'db.php';

$resarray = array();
$sql = "SELECT
  host_log.isEnabled,
  host_log.isControlPanelModuleEnabled,
  host_log.quota,
  host_log.diskUsage,
  host.hostName,
  host.hostType,
  server.cdp_hostname
FROM host_log
JOIN (host, server)
  ON (host_log.host_id = host.id
    AND host.cdp_server_id = server.id)
  WHERE host_log.poll_id =
    (SELECT MAX(`id`)
    FROM host_log_poll)";
$res = mysql_query($sql, $conn);

while($rec = mysql_fetch_assoc($res)){
$resarray[] = $rec;
}

//var_dump($resarray);

foreach ($resarray as $thisHost) {
  // convert disk usage to GiB
  $thisHost['diskUsage'] = round($thisHost['diskUsage'] / 1074000000, 3);

  // convert disk quota to GiB
  $thisHost['quota'] = round($thisHost['quota'] / 1074000000, 3);

  // fix host type names
  if ($thisHost['hostType'] == '1') { 
    $thisHost['hostType'] = 'Windows';
  } else {
    $thisHost['hostType'] = 'Linux';
  }

  // color row red if host is disabled
  if ($thisHost['isEnabled'] == '0') { 
    echo '<tr class="gradeX">';
    $thisHost['isEnabled'] = 'False';
  } else {
    echo '<tr>';
    $thisHost['isEnabled'] = 'True';
  }

  // Generate table data
  echo
    '<td>' . $thisHost['cdp_hostname'] . '</td>' .
    '<td>' . $thisHost['hostName'] . '</td>' .
    '<td>' . $thisHost['isEnabled'] . '</td>' .
    '<td>' . $thisHost['hostType'] . '</td>' .
    '<td>' . $thisHost['quota'] . '</td>' . 
    '<td>' . $thisHost['diskUsage'] . '</td>' .
    '</tr>';

} // foreach resarray

unset($res);
unset($resarray);
include 'footer.html';
?>
