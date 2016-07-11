<?php
namespace PayWithCapture;

use PayWithCapture\Contracts\APIContract;
use PayWithCapture\Services\Transaction;
use PayWithCapture\Services\ServerData;
use PayWithCapture\Services\Otp;
use PayWithCapture\Services\CardPayment;
use PayWithCapture\Services\AccountPayment;
use PayWithCapture\Services\QRCode;

/*
* This is the entry point of this library
*
* $client = new PayWithCaptureClient($clientId, $clientSecret, $environment)
* the $environment variable can either be "staging" or "production"
* depending on the stage of development you are in.
*/
class PayWithCaptureClient implements APIContract
{
  private $env;

  private $authentication;

  function __construct($clientId, $clientSecret, $env = ServerData::$STAGING, $eagerLoading = false, $username = "", $password = "")
  {
    $this->env = $env;
    $authentication = new Authentication($clientId, $clientSecret, $env, $eagerLoading, $username, $password);
  }

  private function loadAuthAndReturnAccessToken()
  {
    $authentication->loadAccessToken();
    $accessToken = $authentication->getAccessToken();
  }

  /*
  * This method returns a Transaction client for interacting
  * with transaction endpoints such as get details of a transaction
  * transactionClient = $client->getTransactionClient();
  * transactionClient->findTransaction($transactionId);
  * @return {Array} json response string from server in array format.
  * @throws Exceptions
  */
  public function getTransactionClient()
  {
    return new Transaction($this->loadAuthAndReturnAccessToken(), $this->env);
  }

  public function getAccountPaymentClient()
  {
    return new AccountPayment($this->loadAuthAndReturnAccessToken(), $this->env);
  }

  public function getCardPaymentClient()
  {
    return new CardPayment($this->loadAuthAndReturnAccessToken(), $this->env);
  }

  public function getOtpClient()
  {
    return new Otp($this->loadAuthAndReturnAccessToken(), $this->env);
  }

  public function getQRCodeClient()
  {
    retur new QRCode($this->loadAuthAndReturnAccessToken(), $this->env);
  }

  public function getPOSPrintingClient()
  {

  }
}
