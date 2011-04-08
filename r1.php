<?php
include 'xmlrpc.inc';

class r1api {
    public $r1password;
    public $r1username;
    public $r1host;
    public $r1port;
    public $r1XMLRPCPath;

  function __construct($r1username, $r1password, $r1host, $r1port = '8084', $r1XMLRPCPath = '/xmlrpc') {
    $this->username = $r1username;
    $this->password = $r1password;
    $this->host = $r1host;
    $this->port = $r1port;
    $this->path = $r1XMLRPCPath;
    $this->xmlrpcclient = new xmlrpc_client($this->host . ':' . $this->port . $this->path);
    $this->xmlrpcclient->setCredentials($this->username, $this->password);
  } //function __construct
    
  function getIDs() {
    $xmlrpc_msg = new xmlrpcmsg('host.getHostIds');
    $reply = $this->xmlrpcclient->send($xmlrpc_msg);
    $xml = $reply->value();
    return $xml->getVal();
  } //function getIDs

  function getHost($hostID) {
    $this->hostID = $hostID;
    $xmlrpc_msg = new xmlrpcmsg('host.getHost' ,  array(new xmlrpcval($this->hostID, 'string')));
    $reply = $this->xmlrpcclient->send($xmlrpc_msg);
    $xml = $reply->value();
    $inarr = $xml->getVal();
    $outarr = array( 'hostID' => $inarr[0],
      'hostName' => $inarr[1],
      'hostType' => $inarr[2],
      'volumeID' => $inarr[3],
      'isEnabled' => $inarr[4],
      'isControlPanelModuleEnabled' => $inarr[5],
      'quota' => $inarr[6],
      'diskUsage' => $inarr[7],
     );
    return $outarr;
  } // function getHost

  function getLastFinishedBackupTaskInfo($hostID) {
    $this->hostID = $hostID;
    $xmlrpc_msg = new xmlrpcmsg('host.getLastFinishedBackupTaskInfo' ,  array(new xmlrpcval($this->hostID, 'string')));
    $reply = $this->xmlrpcclient->send($xmlrpc_msg);
    $xml = $reply->value();
    $inarr = $xml->getVal();
    $outarr = array( 'runState' => $inarr[0],
      'timeCompleted' => $inarr[1],
      'taskRunID' => $inarr[2],
     );
    return $outarr;
  } // function getLastFinishedBackupTaskInfo

/* needs more work to return outarr as a complex array of messages
  function 
getTaskLogs($taskID) {
    $this->taskID = $taskID;
    $xmlrpc_msg = new xmlrpcmsg('taskRun.getTaskLogs' ,  array(new xmlrpcval($this->taskID, 'double')));
    $reply = $this->xmlrpcclient->send($xmlrpc_msg);
    $xml = $reply->value();
    $inarr = $xml->getVal();
    foreach ($inarr as $thismsg) {
      foreach ($thismsg as $v) {
        var_dump($v->getVal());
      $outarr["$thismsg"] = array( 'taskLogMsgID' => $inarr[0],
          'taskRunID' => $inarr[1],
          'logLevel' => $inarr[2],
          'time' => $inarr[3],
          'msg' => $inarr[4],
         );
 
      } //foreach thismsg
    } //foreach inarr
    return $outarr;
  } // function getTaskLogs

*/

  function getScheduledTaskIdsByHost($hostID) {
    $this->hostID = $hostID;
    $xmlrpc_msg = new xmlrpcmsg('backupTask.getScheduledTaskIdsByHost' ,  array(new xmlrpcval($this->hostID, 'string')));
    $reply = $this->xmlrpcclient->send($xmlrpc_msg);
    $xml = $reply->value();
    return $xml->getVal();
  } // function getScheduledTaskIdsByHost

  function getTaskRun($taskID) {
    $this->taskID = $taskID;
    $xmlrpc_msg = new xmlrpcmsg('backupTask.getScheduledTaskIdsByHost' ,  array(new xmlrpcval($this->taskID, 'string')));
    $reply = $this->xmlrpcclient->send($xmlrpc_msg);
    $xml = $reply->value();
    return $xml->getVal();
  } // function getTaskRun

} // class r1api
?>
