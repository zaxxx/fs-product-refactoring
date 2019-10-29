<?php
declare(strict_types=1);

namespace Tests\Unit\FootShop\Products\Query\PSR;

use FootShop\Products\Query\PSR\PSRProductsQueryProvider;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;

class PSRProductsQueryProviderTest extends TestCase
{
    public function testGet(): void
    {
        $serverRequestInterface = $this->createMock(ServerRequestInterface::class);
        $serverRequestInterface->expects(self::once())
            ->method('getQueryParams')
            ->willReturn([
                'name' => 'foo',
                'brand' => 2,
                'order' => 'name',
                'limit' => 100,
            ]);

        $provider = new PSRProductsQueryProvider($serverRequestInterface);
        $query = $provider->get();

        self::assertEquals('foo', $query->getName());
        self::assertEquals(2, $query->getBrandId());
        self::assertEquals('name', $query->getOrder());
        self::assertEquals(100, $query->getLimit());
    }
}
