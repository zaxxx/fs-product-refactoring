<?php
declare(strict_types=1);

namespace FootShop\web\Controller;

use FootShop\Brands\Entity\Brand;
use FootShop\Brands\Repository\BrandRepository;
use FootShop\Products\Entity\Product;
use FootShop\Products\Query\ProductsQueryProvider;
use FootShop\Products\Repository\ProductRepository;
use Monolog\Logger;
use Twig_Environment;

class ProductController implements Controller
{
    /** @var Twig_Environment */
    private $twig;

    /** @var ProductRepository */
    private $productRepository;

    /** @var BrandRepository */
    private $brandRepository;

    /** @var ProductsQueryProvider */
    private $productsQueryProvider;

    /** @var Logger */
    private $logger;

    public function __construct(
        Twig_Environment $twig,
        ProductRepository $productRepository,
        BrandRepository $brandRepository,
        ProductsQueryProvider $productsQueryProvider,
        Logger $logger
    ) {
        $this->twig = $twig;
        $this->productRepository = $productRepository;
        $this->brandRepository = $brandRepository;
        $this->productsQueryProvider = $productsQueryProvider;
        $this->logger = $logger;
    }

    public function render(): void
    {
        $this->logger->info('Rendering products action.');

        $brands = $this->brandRepository->findAll();
        $products = $this->productRepository->find($this->productsQueryProvider->get());

        echo $this->twig->render('product.html', [
            'type' => 'product',
            'title' => 'Products',
            'brands' => array_map(function (Brand $brand) {
                return $this->transformBrand($brand);
            }, $brands),
            'products' => array_map(function (Product $product) {
                return $this->transformProduct($product);
            }, $products),
        ]);
    }

    private function transformBrand(Brand $brand): array
    {
        return [
            'id' => $brand->getId(),
            'name' => $brand->getName(),
        ];
    }

    private function transformProduct(Product $product): array
    {
        return [
            'id' => $product->getId(),
            'name' => $product->getName(),
            'brand' => $product->getBrandName(),
            'price' => $product->getPrice(),
            'quantity' => $product->getQuantity(),
            'reserved' => $product->getReserved(),
            'sum_price' => $product->getSumPrice(),
            'sum_reserved_price' => $product->getSumReservedPrice(),
        ];
    }
}
