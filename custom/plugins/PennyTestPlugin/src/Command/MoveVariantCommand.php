<?php

namespace PennyTestPlugin\Command;

use Shopware\Core\Content\Product\ProductCollection;
use Shopware\Core\Content\Product\ProductEntity;
use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsFilter;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\RangeFilter;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class MoveVariantCommand extends Command
{
    public static $defaultName = 'penny:moveVariant';

    protected EntityRepository $entityRepository;

    public function __construct(
        EntityRepository $entityRepository
    )
    {
        $this->entityRepository = $entityRepository;
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setName('penny:moveVariant')
            ->setDescription('MOVE VARIANT!!!1');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $io->comment('hi');


        // fetch product with variants
        $criteria = new Criteria();
        $criteria->addFilter(new EqualsFilter('productNumber', 'SWDEMO10005'));
        $criteria->addAssociation('children');

        /** @var ProductEntity $productWithVariant */
        $productWithVariant = $this->entityRepository->search(
            $criteria,
            Context::createDefaultContext()
        )->getEntities()->first();

        $variantCount = $productWithVariant->getChildCount();
        $io->note(sprintf('Product %s has %d variants', $productWithVariant->getProductNumber(), $variantCount));
        $variants = $productWithVariant->getChildren();


        // fetch product without variants
        $criteria = new Criteria();
        $criteria->addFilter(new EqualsFilter('childCount', 0));
        $criteria->addFilter(new EqualsFilter('productNumber', 'SWDEMO10002'));
        $criteria->addAssociation('children');

        /** @var ProductEntity $productWithoutVariants */
        $productWithoutVariants = $this->entityRepository->search(
            $criteria,
            Context::createDefaultContext()
        )->getEntities()->first();

        $variantCount = $productWithoutVariants->getChildCount();
        $io->note(
            sprintf('Product %s has %d variants',
                $productWithoutVariants->getProductNumber(),
                $variantCount)
        );

        $elements = $variants->getElements();
        $changeableVariant = array_shift($elements);
        $this->entityRepository->update(
            [
                [
                    'id' => $productWithoutVariants->getId(),
                    'children' => [
                        [
                            'id' => $changeableVariant->getId(),
                        ]
                    ]
                ]
            ],
            Context::createDefaultContext()
        );

        $variantCount = $productWithoutVariants->getChildCount();
        $io->note(sprintf('Product %s has %d variants', $productWithoutVariants->getProductNumber(), $variantCount));

        return 1;
    }
}
