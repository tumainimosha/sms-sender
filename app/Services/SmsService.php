<?php

namespace App\Services;

use \infobip\api\client\SendSingleTextualSms as Sms;
use \infobip\api\configuration\BasicAuthConfiguration as AuthConfig;
use \infobip\api\model\sms\mt\send\textual\SMSTextualRequest as SmsRequest;

class SmsService
{
    /**
     * @var Sms
     */
    protected $client;

    /**
     * SmsService constructor.
     */
    public function __construct()
    {
        $username = config('services.infobip.username');
        $password = config('services.infobip.password');

        $config = new AuthConfig($username, $password);

        $client = new Sms($config);

        $this->client = $client;
    }

    /**
     * @param $msisdn
     * @param $message
     * @param $from
     * @return mixed
     */
    public function send($msisdn, $message, $from)
    {
        $requestBody = new SmsRequest();
        $requestBody->setFrom($from);
        $requestBody->setTo($msisdn);
        $requestBody->setText($message);

        $response = $this->client->execute($requestBody);

        return $response;
    }
}
