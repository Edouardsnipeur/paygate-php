<?php

namespace Paygate;
/**
 * User: Edouard Zinnoussou
 * Date: 2023-10-08
 * Time: 19:23
 *
 * THIS FILE CONTAINS ALL PAYGATE SDK
 */

class Paygate
{
    private $auth_token;

    private $curl;

    private $attempts = 0;

    /**
     * Kkiapay constructor.
     */
    public function __construct($auth_token)
    {
        $this->auth_token = $auth_token;
        $this->curl = new \GuzzleHttp\Client([
            'verify' => __DIR__ . '/../data/cacert.pem'
        ]);
    }

    public function payNow(
        string $phone_number,
        int $amount,
        string $identifier,
        string $network,
        string $description = "",
    )
    {
        $reponse = null;
        try {

            $url = Constants::BASE_URL_V1;

            $response = $this->curl->post($url . '/pay', array(
                "json" => [
                    "phone_number" => $phone_number,
                    "amount" => $amount,
                    "description" => $description,
                    "identifier" => $identifier,
                    "network" => $network,
                    "auth_token" => $this->auth_token,
                ],
                'headers' => [
                    'Accept'     => 'application/json',
                ]
            ));

            $reponse = $response->getBody();
            return json_decode((string)$reponse);
        } catch (RequestException $e) {
            $reponse = json_encode(array("status" => TransactionStatus::INTERNAL_ERROR));
            return json_decode((string)$response);
        }
    }

    public function redirectPayNow(
        string $phone_number = "",
        int $amount,
        string $identifier,
        string $url = null,
        string $description = "",
    )
    {
        $url = Constants::BASE_URL_V1;
        $this->curl->get($url . '/page', array(
            "query" => [
                "phone" => $phone_number,
                "amount" => $amount,
                "description" => $description,
                "identifier" => $identifier,
                "auth_token" => $this->auth_token,
                "url" => $url,
            ]
        ));
    }

    public function verifyTransactionWithPaygateReference(
        string $tx_reference,
    )
    {
        $reponse = null;
        try {

            $url = Constants::BASE_URL_V1;

            $response = $this->curl->post($url . '/status', array(
                "json" => [
                    "tx_reference" => $tx_reference,
                    "auth_token" => $this->auth_token,
                ],
                'headers' => [
                    'Accept'     => 'application/json',
                ]
            ));

            $reponse = $response->getBody();
            return json_decode((string)$reponse);
        } catch (RequestException $e) {
            $this->attempts += 1;
            if($this->attempts > 3) return $e->getResponse()->getStatusCode();
            return $this->verifyTransactionWithPaygateReference($tx_reference);
        }
    }

    public function verifyTransactionWithEcommerceId(
        string $identifier,
    )
    {
        $reponse = null;
        try {

            $url = Constants::BASE_URL_V2;

            $response = $this->curl->post($url . '/status', array(
                "json" => [
                    "identifier" => $identifier,
                    "auth_token" => $this->auth_token,
                ],
                'headers' => [
                    'Accept'     => 'application/json',
                ]
            ));

            $reponse = $response->getBody();
            return json_decode((string)$reponse);
        } catch (RequestException $e) {
            $this->attempts += 1;
            if($this->attempts > 3) return $e->getResponse()->getStatusCode();
            return $this->verifyTransactionWithEcommerceId($identifier);
        }
    }

    public function checkBalance()
    {
        $reponse = null;
        try {

            $url = Constants::BASE_URL_V1;

            $response = $this->curl->post($url . '/check-balance', array(
                "json" => [
                    "auth_token" => $this->auth_token,
                ],
                'headers' => [
                    'Accept'     => 'application/json',
                ]
            ));

            $reponse = $response->getBody();
            return json_decode((string)$reponse);
        } catch (RequestException $e) {
            return $e->getResponse()->getStatusCode();
        }
    }

    /**
     * @return mixed
     */
    public function getAuthToken()
    {
        return $this->auth_token;
    }
}

