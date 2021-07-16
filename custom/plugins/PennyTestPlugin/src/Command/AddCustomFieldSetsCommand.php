<?php

namespace PennyTestPlugin\Command;

use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepositoryInterface;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\System\CustomField\CustomFieldTypes;
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
        EntityRepositoryInterface $entityRepository
    )
    {
        $this->entityRepository = $entityRepository;
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setName('ct:addCustomFieldSet')->setDescription('Test-Plugin to insert some Attributes');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $context = Context::createDefaultContext();
        // Next Step: Custom field zu bestehende fieldset (swag_example_set) hinzufügen.
        $this->entityRepository->create([
            [
                'name' => 'swag_example_set',
                'config' => [
                    'label' => [
                        'en-GB' => 'English custom field set label',
                        'de-DE' => 'German custom field set label'
                    ]
                ],
                'customFields' => [
                    [
                        'name' => 'swag_example_size',
                        'type' => CustomFieldTypes::INT,
                        'config' => [
                            'label' => [
                                'en-GB' => 'English custom field label',
                                'de-DE' => 'German custom field label'
                            ],
                            'customFieldPosition' => 1
                        ]
                    ]
                ],
                'relations' => [
                    [
                        'entityName' => 'product'
                    ]
                ]
            ]
        ], $context);
        return 1;
    }

}
