<?php

namespace Enan\PathaoCourier\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class DataServiceOutput
{
    protected $data = null;
    protected $message = null;
    protected $status_code = 200;
    protected $is_success = false;

    public function __construct(Collection|Model|array|null $data, string|null $message = null, bool $is_success = true, $status_code = 200)
    {
        $this->data = $data;
        $this->message = $message;
        $this->is_success = $is_success;
        $this->status_code = $status_code;
    }

    public function getData()
    {
        return $this->data;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function getStatusCode()
    {
        return $this->status_code;
    }

    public function isSuccess()
    {
        return $this->is_success;
    }

    public function setData($data): static
    {
        $this->data = $data;
        return $this;
    }

    public function setMessage($message): static
    {
        $this->message = $message;
        return $this;
    }

    public function setSuccess($is_success): static
    {
        $this->is_success = $is_success;
        return $this;
    }

    public function setStatusCode($status_code): static
    {
        $this->status_code = $status_code;
        return $this;
    }
}
