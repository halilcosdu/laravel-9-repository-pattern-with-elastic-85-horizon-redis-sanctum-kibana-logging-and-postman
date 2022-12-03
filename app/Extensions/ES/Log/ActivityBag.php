<?php

namespace App\Extensions\ES\Log;

use Carbon\Carbon;
use Illuminate\Contracts\Support\Arrayable;

/**
 *
 */
class ActivityBag implements Arrayable
{
    /**
     * @var mixed
     */
    private mixed $ip;

    /**
     * @var string
     */
    private string $action;

    /**
     * @var \Carbon\Carbon
     */
    private Carbon $date;

    /**
     * @var int|null
     */
    private int|null $causerID;

    /**
     * @var array|null
     */
    private array|null $info = null;

    /**
     * @var string
     */
    private string $uri;

    /**
     * @var string
     */
    private string $method;

    /**
     * @var string
     */
    private string $agent;

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'ip' => $this->getIP(),
            'action' => $this->getAction(),
            'date' => $this->getDate(),
            'causer_id' => $this->getCauserID(),
            'info' => $this->getInfo(),
            'uri' => $this->getUri(),
            'method' => $this->getMethod(),
            'agent' => $this->getAgent(),
        ];
    }

    /**
     * @return mixed
     */
    public function getIP()
    {
        return $this->ip;
    }

    /**
     * @param  mixed  $ip
     * @return \App\Extensions\ES\Log\ActivityBag
     */
    public function setIP(mixed $ip)
    {
        $this->ip = $ip;

        return $this;
    }

    /**
     * @return string
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @param  string  $action
     * @return \App\Extensions\ES\Log\ActivityBag
     */
    public function setAction(string $action)
    {
        $this->action = $action;

        return $this;
    }

    /**
     * @return \Carbon\Carbon
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param  \Carbon\Carbon  $date
     * @return \App\Extensions\ES\Log\ActivityBag
     */
    public function setDate(Carbon $date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getCauserID()
    {
        return $this->causerID;
    }

    /**
     * @param  int|null  $causerID
     * @return \App\Extensions\ES\Log\ActivityBag
     */
    public function setCauserID(?int $causerID)
    {
        $this->causerID = $causerID;

        return $this;
    }

    /**
     * @return array|null
     */
    public function getInfo()
    {
        return $this->info;
    }

    /**
     * @param  array|null  $info
     * @return \App\Extensions\ES\Log\ActivityBag
     */
    public function setInfo(?array $info)
    {
        $this->info = $info;

        return $this;
    }

    /**
     * @return string
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * @param  string  $uri
     * @return \App\Extensions\ES\Log\ActivityBag
     */
    public function setUri(string $uri)
    {
        $this->uri = $uri;

        return $this;
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @param  string  $method
     * @return \App\Extensions\ES\Log\ActivityBag
     */
    public function setMethod(string $method)
    {
        $this->method = $method;

        return $this;
    }

    /**
     * @return string
     */
    public function getAgent()
    {
        return $this->agent;
    }

    /**
     * @param  string  $agent
     * @return \App\Extensions\ES\Log\ActivityBag
     */
    public function setAgent(string $agent)
    {
        $this->agent = $agent;

        return $this;
    }
}
