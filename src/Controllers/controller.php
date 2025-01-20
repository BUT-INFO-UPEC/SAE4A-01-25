<?php

namespace App\Controller;

require_once __DIR__ . "/../Model/classes/Msg.php";

use App\Model\Classes\BDD;
use App\Model\Classes\Msg;
use App\Model\Requetteurs\Requetteur_BDD;

class Controller
{
  #region Messages
  //////////////////////////////////
  //                              //
  //           Msesages           //
  //                              //
  //////////////////////////////////

  // setSuccess
  public static function setSuccess($msg)
  {
    $msg = new Msg($msg);
    return $msg->setSuccess();
  }
  // setError
  public static function setError($msg)
  {
    $msg = new Msg($msg);
    return $msg->setError();
  }
  // setWarning
  public static function setWarning($msg)
  {
    $msg = new Msg($msg);
    return $msg->setWarning();
  }
  // setDanger
  public static function setDanger($msg)
  {
    $msg = new Msg($msg);
    return $msg->setDanger();
  }
  // setSuccesAndRedirect
  public static function setSuccessAndRedirect($msg)
  {
    $msg = new Msg($msg);
    return $msg->setSuccessAndRedirect();
  }
  // setErrorAndRedirect
  public static function setErrorAndRedirect($msg)
  {
    $msg = new Msg($msg);
    return $msg->setErrorAndRedirect();
  }
  // setWarningAndRedirect
  public static function setWarningAndRedirect($msg)
  {
    $msg = new Msg($msg);
    return $msg->setWarningAndRedirect();
  }
  // setDangerAndRedirect
  public static function setDangerAndRedirect($msg)
  {
    $msg = new Msg($msg);
    return $msg->setDangerAndRedirect();
  }
  #endregion

  ////////////////////////////////////////////////////////////////

  #region BDD_conn
  //////////////////////////////////
  //                              //
  //           BDD_conn           //
  //                              //
  //////////////////////////////////

  // fetchAll
  public function fetchAll(string $query, array $params = []): array
  {
    $result = new BDD();
    return $result->fetchAll($query, $params);
  }
  // fetchOne
  public function fetchOne(string $query, array $params = []): array
  {
    $result = new BDD();
    return $result->fetchOne($query, $params);
  }
  // execute
  public function execute(string $query, array $params = []): int
  {
    $result = new BDD();
    return $result->execute($query, $params);
  }

  ////////////////////////////////////////////////////////////////

  #region Requetteur_BDD
  //////////////////////////////////
  //                              //
  //        Requetteur_BDD        //
  //                              //
  //////////////////////////////////

  public static function getStations()
  {
    return Requetteur_BDD::get_station();
  }

  #endregion

  ////////////////////////////////////////////////////////////////

  #region Requetteur_API
  //////////////////////////////////
  //                              //
  //        Requetteur_API        //
  //                              //
  //////////////////////////////////



  #endregion

  ////////////////////////////////////////////////////////////////

  #region composants
  //////////////////////////////////
  //                              //
  //           composants         //
  //                              //
  //////////////////////////////////



  #endregion

  ////////////////////////////////////////////////////////////////

  #region Requette_API
  //////////////////////////////////
  //                              //
  //         Requette_API         //
  //                              //
  //////////////////////////////////



  #endregion
}
