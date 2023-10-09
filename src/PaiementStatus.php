<?php
namespace Paygate;

/**
 * User: Edouard Zinnoussou
 * Date: 2023-10-08
 * Time: 19:23
 *
 * THIS FILE CONTAINS ALL PAYGATE PAYMENT API STATUS
 */

final class PaiementStatus {
    const SUCCESS = 0;
    const PENDING = 2;
    const EXPIRED = 4;
    const CANCELED = 6;
    const INTERNAL_ERROR = 7;
}