<?php

namespace App\Traits;

trait HasEmail
{
    public function getEmailForPasswordReset()
    {
        return $this->email;
    }
}
