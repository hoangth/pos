<?php
/**
 * Created by PhpStorm.
 * User: daniel
 * Date: 05.10.14
 * Time: 16:58
 */

namespace Cundd\PersistentObjectStore\Console\Server;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Process;

/**
 * Abstract console command to start the server
 *
 * @package Cundd\PersistentObjectStore\Console
 */
abstract class AbstractServerCommand extends Command
{
    /**
     * @var \Symfony\Component\Process\ProcessBuilder
     * @Inject
     */
    protected $processBuilder;

    /**
     * Configure the command
     */
    protected function configure()
    {
        $this
            ->addArgument(
                'ip',
                InputArgument::OPTIONAL,
                'Server IP address'
            )
            ->addArgument(
                'port',
                InputArgument::OPTIONAL,
                'Server port'
            )
            ->addArgument(
                'data-path',
                InputArgument::OPTIONAL,
                'Directory path where the data is stored'
            )
            ->addOption(
                'dev',
                null,
                InputOption::VALUE_NONE,
                'Start the server in development mode'
            );
    }

    /**
     * @param Process         $process
     * @param OutputInterface $output
     */
    protected function startProcessAndWatch(Process $process, OutputInterface $output)
    {
        if (OutputInterface::VERBOSITY_VERBOSE <= $output->getVerbosity()) {
            $output->writeln(sprintf('<info>Start server using command %s</info>', $process->getCommandLine()));
        }

        $exitedSuccessfully = false;
        while (!$exitedSuccessfully) {
            $process->start();
            $process->wait(
                function ($type, $buffer) use ($output) {
                    if (Process::ERR === $type) {
                        $output->writeln(sprintf('<error>%s</error>', $buffer));
                    } else {
                        $output->writeln($buffer);
                    }
                }
            );

            $exitedSuccessfully = $process->getExitCode() === 0;
            if ($exitedSuccessfully) {
                $output->writeln('<info>Terminated</info>');
            } else {
                $output->writeln('<error>Crashed</error>');
                $output->writeln('<info>Will restart the server</info>');
            }
        }
    }
}
