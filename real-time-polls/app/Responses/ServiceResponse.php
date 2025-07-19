<?php

namespace App\Responses;

use App\Contracts\ResponseContract;

class ServiceResponse implements ResponseContract {

    /**
     * Setter of response service
     *
     * @param $data
     * @param string $message
     * @param int $status
     * @param string $customCode
     */
    public function __construct($data, string $message, int $status, string $customCode = null) {
        $this->status       = $status;
        $this->message      = $message;
        $this->data         = $data;
        $this->customCode   = $customCode;
    }

    public function status(): int {
        return $this->status;
    }

    public function message(): string {
        return $this->message;
    }

    public function data() {
        return $this->data;
    }

    public function customCode(): string
    {
        return $this->customCode;
    }
}
