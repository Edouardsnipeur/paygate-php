<?php
namespace Paygate;

/**
 * User: Edouard Zinnoussou
 * Date: 2023-10-08
 * Time: 19:23
 *
 * THIS FILE CONTAINS ALL PAYGATE TRANSACTION API STATUS
 */

final class TransactionStatus {
    const SUCCESS = 0;
    const INVALID_TOKEN = 2;
    const INVALID_PARAMS = 4;
    const DOUBLONS = 6;
    const INTERNAL_ERROR = 7;
}