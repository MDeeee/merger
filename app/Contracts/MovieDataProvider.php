<?php

namespace App\Contracts;

interface MovieDataProvider
{
    public function getTitles(): ?array;
}
