<?php declare(strict_types=1);

namespace PennyTestPlugin;

use Shopware\Core\Framework\Plugin;

class PennyTestPlugin extends Plugin
{
    public function getMigrationNamespace(): string
    {
        return 'PennyTestPlugin\Migration';
    }
}
