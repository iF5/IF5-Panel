<?php

namespace App\Http\Interfaces;

interface UserInterface
{
    public function getUser();

    public function getRole();

    public function getCompanyId();

    public function getProviderId();
}