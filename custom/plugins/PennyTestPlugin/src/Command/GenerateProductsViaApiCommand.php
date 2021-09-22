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
        $productAmount = 1;
        $count = 0;
        $start = microtime(true);

        while ($count < $productAmount) {
            $count += $bulkSize;
            $payloads = $this->getPayloads($bulkSize);
            $syncOperation = new SyncOperation(
                'write',
                'product',
                'upsert',
                $payloads,
            );

            $orderNumbers = array_column($payloads, 'productNumber');
            $io->info('syncing another batch of ' . $bulkSize . ' products');
            $io->info('Adding new order numbers ' . implode(', ', $orderNumbers));

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
                'SW1337' . $faker->randomNumber(8),
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
                    "id" => "1a9fdd57134947b6b8782f36ad962f6b",
                    "productId" => $id,
                    "salesChannelId" => "98432def39fc4624b33213a56b8c944d",
                    "visibility" => 30
                ],
            ],
            "categories" => [
                [
                    "id" => "a515ae260223466f8e37471d279e6406",
                ]
            ],
            'customFields' => [
                'penny_set_1' => "Test 123 Test",
            ],
        ];
    }
}
