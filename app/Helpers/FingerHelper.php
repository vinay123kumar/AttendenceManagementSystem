<?php
namespace App\Helpers;

use Rats\Zkteco\Lib\ZKTeco;

class FingerHelper
{
    protected $zk;

    // public function __construct($ip = '127.0.0.1', $port = 4370)
    // {
    //     $this->zk = new ZKTeco($ip, $port);
    // }

    // public function init(): bool
    // {
    //     return $this->zk->connect();
    // }

    public function getStatus(): bool
    {
        return $this->zk->connect();
    }

    public function getStatusFormatted(): string
    {
        return $this->zk->connect() ? "Active" : "Inactive";
    }

    public function getSerial()
    {
        if ($this->zk->connect()) {
            return substr(strstr($this->zk->serialNumber(), '='), 1);
        }
        return false;
    }
}
