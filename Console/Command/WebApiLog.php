<?php
/**
 * WebApiLog
 *
 * @copyright Copyright © 2022 Onecode  All rights reserved.
 * @author    support@onecde.gr
 *
 */

namespace Onecode\WebApiLogger\Console\Command;

use Exception;
use Magento\Framework\App\Area;
use Magento\Framework\App\State;
use Magento\Framework\Exception\LocalizedException;
use Onecode\WebApiLogger\Cron\CleanUp;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class WebApiLog
 * @package Onecode\WebApiLogger\Console\Command
 */
class WebApiLog extends Command
{
    /** @var CleanUp */
    private $cleanUp;

    /** @var State */
    private $appState;

    public function __construct(
        CleanUp $cleanUp,
        State   $appState,
        string  $name = null
    ) {
        $this->cleanUp  = $cleanUp;
        $this->appState = $appState;
        parent::__construct($name);
    }

    /**
     * {@inheritdoc}
     */
    protected function configure(): void
    {
        parent::configure();
        $this->setName('onecode:web:logger:cleaner')
             ->setDescription('Onecode Web API Logger — manually trigger log cleanup');
    }

    /**
     * {@inheritdoc}
     *
     * @throws LocalizedException
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $this->appState->getAreaCode();
        } catch (Exception $e) {
            $this->appState->setAreaCode(Area::AREA_CRONTAB);
        }

        $output->writeln('<info>Starting WebApiLogger cleanup...</info>');

        $result = $this->cleanUp->execute();

        if ($result) {
            $output->writeln('<info>Cleanup completed successfully.</info>');
            return Command::SUCCESS;
        }

        $output->writeln('<error>Cleanup encountered errors. Check var/log/system.log for details.</error>');
        return Command::FAILURE;
    }
}
