<?php
namespace PayWithCapture\Builders;

use PayWithCapture\Services\ServerData;
use PayWithCapture\Parsers\ServerResponseParser;

class AccountPaymentRequestBuilder extends ParentBuilder
{
  function __construct($env)
  {
    parent::__construct($env);
  }

  public function addType($type)
  {
    $this->session->data['type'] = $type;
    return $this;
  }

  public function addAmount($amount)
  {
    $this->session->data['amount'] = $amount;
    return $this;
  }

  public function addDescription($description)
  {
    $this->session->data['description'] = $description;
    return $this;
  }

  public function addTransactionId($transactionId)
  {
    $this->session->data['transaction_id'] = $transactionId;
    return $this;
  }

  public function addMerchantId($merchantId)
  {
    $this->session->data['merchant_id'] = $merchantId;
    return $this;
  }

  public function addAccountNumber($accountNumber)
  {
    $this->session->data['accountnumber'] = $accountNumber;
    return $this;
  }

  /*
  * This method builds the request and sends the request to the server
  * then sends the response to parser for validation and convertion to AccountPayment type
  * @return AccountPayment
  */
  public function build()
  {
    $this->log->info("AccountPayment headers: ".json_encode($this->session->headers));
    $this->log->info("Account payment data: ".json_encode($this->session->data));
    $response = $this->session->post(ServerData::$ACCOUNT_PAYMENT_PATH);
    $this->log->info("AccountPaymentBuilder build response: ".json_encode($response));
    $accPayment = ServerResponseParser::parseAccountPaymentResponse($response);
    return $accPayment;
  }
}
