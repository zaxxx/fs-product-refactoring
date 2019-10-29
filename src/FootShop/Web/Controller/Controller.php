<?php
declare(strict_types=1);

namespace FootShop\web\Controller;

use Throwable;

interface Controller
{
    /** @throws Throwable */
    public function render(): void;
}
