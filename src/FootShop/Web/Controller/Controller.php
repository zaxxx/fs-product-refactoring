<?php
declare(strict_types=1);

namespace FootShop\Web\Controller;

use Throwable;

interface Controller
{
    /** @throws Throwable */
    public function render(): void;
}
