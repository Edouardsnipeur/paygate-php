<?php

namespace Paygate;

require '../vendor/autoload.php';

include_once('../src/Paygate.php');

$auth_token = "xxxxxxxxxxxxxxxxxxxxxxxxxx";

$paygate = new Paygate($auth_token);

$verify = $paygate->verifyTransactionWithPaygateReference("xxxxxxx");


var_dump($verify);