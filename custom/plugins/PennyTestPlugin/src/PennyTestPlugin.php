<?php declare(strict_types=1);

namespace PennyTestPlugin;

use Shopware\Core\Framework\Plugin;
use Shopware\Storefront\Framework\ThemeInterface;

class PennyTestPlugin extends Plugin implements ThemeInterface
{
    public function getMigrationNamespace(): string
    {
        return 'PennyTestPlugin\Migration';
    }

    public function getThemeConfigPath(): string
    {
        return 'theme.json';
    }
}
