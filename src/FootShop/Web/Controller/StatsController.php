<?php
declare(strict_types=1);

namespace FootShop\Web\Controller;

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
            'title' => 'Stats',
            'brands' => $this->transformStats($stats),
        ]);
    }

    /**
     * @param iterable|BrandStats[] $stats
     * @return iterable
     */
    private function transformStats(iterable $stats): iterable
    {
        foreach ($stats as $stat) {
            yield [
                'name' => $stat->getName(),
                'quantity' => $stat->getQuantity(),
                'reserved' => $stat->getReserved(),
                'price_quantity' => $stat->getPriceQuantity(),
                'price_reserved' => $stat->getPriceReserved(),
            ];
        }
    }
}
