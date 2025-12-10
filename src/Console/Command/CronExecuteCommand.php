<?php

namespace Rnab\Cron\Console\Command;

use Magento\Framework\App\ObjectManager;
use Magento\Framework\Console\Cli;
use Magento\Framework\Exception\FileSystemException;
use Magento\Framework\Exception\RuntimeException;
use Magento\Framework\Shell\ComplexParameter;
use Magento\Store\Model\Store;
use Magento\Store\Model\StoreManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Magento\Cron\Model\ConfigInterface;
        
/**
 * Command for executing cron jobs
 *
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class CronExecuteCommand extends Command
{
    /**
     * @var ConfigInterface
     */
    private $config;

    public function __construct(
        ConfigInterface $config
    ) {
        $this->config = $config;
        parent::__construct();
    }

    /**
     * @inheritdoc
     */
    protected function configure()
    {
        $this->setName('cron:execute')
            ->setDescription('Execute a specific cron job disregarding its schedule')
            ->addOption('job-code', null, InputOption::VALUE_REQUIRED, 'Cron job code')
            ;
        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $jobConfig = $this->getJobConfig($input->getOption('job-code'));
        if ($jobConfig === null) {
            $output->writeln('<error>Job not found</error>');
            return Cli::RETURN_FAILURE;
        }

        $instance = ObjectManager::getInstance()->create($jobConfig['instance']);
        $method = $jobConfig['method'];
        $instance->$method();
        
        return Cli::RETURN_SUCCESS;
    }

    protected function getJobConfig(string $jobCode)
    {
        $jobs = $this->config->getJobs();
        foreach ($jobs as $jobGroup) {
            foreach ($jobGroup as $job) {
                if ($job['name'] === $jobCode) {
                    return $job;
                }
            }
        }
        return null;
    }
}
