<?php
declare(strict_types=1);

namespace FootShop\web\Controller;

use FootShop\Brands\Entity\BrandStats;
use FootShop\Brands\Repository\BrandStatsRepository;
use Twig_Environment;

class StatsController implements Controller
{
    /** @var Twig_Environment */
    private $twig;

    /** @var BrandStatsRepository */
    private $brandStatsRepository;

    public function __construct(Twig_Environment $twig, BrandStatsRepository $brandStatsRepository)
    {
        $this->twig = $twig;
        $this->brandStatsRepository = $brandStatsRepository;
    }

    public function render(): void
    {
        $stats = $this->brandStatsRepository->findAll();

        echo $this->twig->render('stats.html', [
            'type' => 'stats',
            'brands' => array_map(function (BrandStats $stats) {
                return $this->transformStats($stats);
            }, $stats),
        ]);
    }

    private function transformStats(BrandStats $stats): array
    {
        return [
            'name' => $stat->getName(),
            'quantity' => $stat->getQuantity(),
            'reserved' => $stat->getReserved(),
            'price_quantity' => $stat->getPriceQuantity(),
            'price_reserved' => $stat->getPriceReserved(),
        ];
    }
}
