<?php
use PHPUnit\Framework\TestCase;
use Paygate\Paygate;
use Paygate\Network;
use Paygate\TransactionStatus;

final class PaygateTest extends TestCase
{
    private $paygate;

    protected function setUp() : void
    {
        $this->paygate = new Paygate("6c5e3c15-4775-4933-98f3-f2dcc275e775");
    }

    public function testGetAuthToken(): void
    {
        $response = $this->paygate->getAuthToken();

        $this->assertEquals($response, "6c5e3c15-4775-4933-98f3-f2dcc275e775");
    }

    public function testPayNow(): void
    {
        $response = $this->paygate->payNow(
            phone_number : "92988508",
            amount : 1,
            identifier : "9920",
            network : Network::TMONEY,
        );

        $this->assertEquals($response->status, TransactionStatus::SUCCESS);
    }
}