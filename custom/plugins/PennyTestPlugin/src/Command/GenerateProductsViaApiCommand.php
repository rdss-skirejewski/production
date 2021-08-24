<?php

declare(strict_types=1);

namespace PennyTestPlugin\Command;

use Faker\Factory;
use Faker\Generator;
use Shopware\Core\Framework\Api\Sync\SyncBehavior;
use Shopware\Core\Framework\Api\Sync\SyncOperation;
use Shopware\Core\Framework\Api\Sync\SyncService;
use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\Uuid\Uuid;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class GenerateProductsViaApiCommand extends Command
{
    public static $defaultName = 'penny:create:products-api';

    private SyncService $syncService;

    public function __construct(
        SyncService $syncService
    )
    {
        $this->syncService = $syncService;
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setName(self::$defaultName)
            ->setDescription('create via api');
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $io->comment('create');

        $bulkSize = 10;
        $productAmount = 3000;
        $count = 0;
        $start = microtime(true);

        while ($count < $productAmount) {
            $count += $bulkSize;
            $syncOperation = new SyncOperation(
                'write',
                'product',
                'upsert',
                $this->getPayloads($bulkSize),
            );

            $io->info('syncing another batch of ' . $bulkSize . ' products');

            $this->syncService->sync(
                [
                    $syncOperation,
                ],
                Context::createDefaultContext(),
                new SyncBehavior(true)
            );
        }
        $stop = microtime(true);
        var_dump($stop - $start);

        $io->success('done');

        return 1;
    }

    private function getPayloads(int $limit): array
    {
        $faker = Factory::create();
        $payloads = [];
        foreach (range(0, $limit) as $count) {
            $payloads[] = $this->getPayload(
                Uuid::randomHex(),
                'SW1000' . $faker->randomNumber(8),
                $faker->text(50),
                $faker->numberBetween(1, 200)
            );
        }
        return $payloads;
    }

    private function getPayload(string $id, string $orderNumber, string $name, int $stock): array
    {
        $faker = Factory::create();

        return [
            'id' => $id,
            'manufacturerId' => 'b74c9af89be84041803b855fab69de48',
            "taxId" => "feab1744f6c14e3790d3cb113322677c",
            "deliveryTimeId" => "6c1d9c27d28141f4a64f755966299f46",
            "featureSetId" => "9a6d7d43c94f440aacdd27d226fa3932",
            'price' => [
                [
                    "currencyId" => "b7d2554b0ce847cd82f3ac9bd1c0dfca",
                    "net" => $faker->randomFloat(null, 10, 20),
                    "linked" => true,
                    "gross" => $faker->randomFloat(null, 21)
                ],
            ],
            "productNumber" => $orderNumber,
            "stock" => $stock,
            "active" => true,
            "purchasePrices" => [
                [
                    "currencyId" => "b7d2554b0ce847cd82f3ac9bd1c0dfca",
                    "net" => 0,
                    "linked" => true,
                    "gross" => 0,
                ],
            ],
            "name" => $name,
            "visibilities" => [
                [
                    "id" => "f982f2132dd54e9b81a759467f9c250d",
                    "productId" => $id,
                    "salesChannelId" => "27f88058a9e440d68b3544f6dc435e88",
                    "visibility" => 30
                ],
            ],
            "categories" => [
                [
                    "id" => "28c4d6c0e39540d18f8d4ff762f81642",
                ]
            ]
        ];
    }
}
