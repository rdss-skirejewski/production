<?php

namespace PennyTestPlugin\Command;

use Shopware\Core\Framework\DataAbstractionLayer\EntityRepositoryInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class AddCustomFieldSetsCommand extends Command
{
    public static $defaultName = 'ct:addCustomFieldSet';

    protected $entityRepository;

    public function __construct(
        EntityRepositoryInterface $entityRepository,
        string $name
    )
    {
        $this->entityRepository = $entityRepository;
        parent::__construct($name);
    }

    protected function configure(): void
    {
        $this->setName('ct:addCustomFieldSet')->setDescription('Test-Plugin to insert some Attributes');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
    }

}
