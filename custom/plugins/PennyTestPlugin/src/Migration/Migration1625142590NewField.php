<?php declare(strict_types=1);

namespace PennyTestPlugin\Migration;

use Doctrine\DBAL\Connection;
use Shopware\Core\Framework\Migration\MigrationStep;

class Migration1625142590NewField extends MigrationStep
{
    public function getCreationTimestamp(): int
    {
        return 1625142590;
    }

    public function update(Connection $connection): void
    {
        $sql = <<<SQL
ALTER TABLE `product`
    ADD `penny_custom_field` VARCHAR(255) NULL
SQL;
        $connection->executeStatement($sql);
    }

    public function updateDestructive(Connection $connection): void
    {
        $sql = <<<SQL
ALTER TABLE `product` DROP `penny_custom_field`;
SQL;
        $connection->executeStatement($sql);
    }
}
