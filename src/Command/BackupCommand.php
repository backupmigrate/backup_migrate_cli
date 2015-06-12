<?php
/**
 * @file
 * Contains ${NAMESPACE}\BackupCommand
 */

namespace BackupMigrate\CLI\Command;

use BackupMigrate\Core\Services\BackupMigrate;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class BackupCommand
 * @package BackupMigrate\Command\BackupCommand
 */
class BackupCommand extends Command {
  protected $bam;

  /**
   * @param \BackupMigrate\Core\Services\BackupMigrate $bam
   * @param null $name
   */
  public function __construct(BackupMigrate $bam, $name = NULL) {
    parent::__construct($name);

    $this->bam = $bam;
  }

  protected function configure()
  {
    $this
      ->setName('backup')
      ->setDescription('Backup a database')
      ->addArgument(
        'source',
        InputArgument::OPTIONAL,
        'The object to be backed up',
        'db'
      )
      ->addArgument(
        'destination',
        InputArgument::OPTIONAL,
        'The destination to send the backup to',
        'stdout'
      );
  }

  /**
   * Executes the current command.
   *
   * This method is not abstract because you can use this class
   * as a concrete class. In this case, instead of defining the
   * execute() method, you set the code to execute by passing
   * a Closure to the setCode() method.
   *
   * @param InputInterface  $input  An InputInterface instance
   * @param OutputInterface $output An OutputInterface instance
   *
   * @return null|int null or 0 if everything went fine, or an error code
   *
   * @throws \LogicException When this abstract method is not implemented
   *
   * @see setCode()
   */
  protected function execute(InputInterface $input, OutputInterface $output)
  {
    $source = $input->getArgument('source');
    $destination = $input->getArgument('destination');
    $this->bam->backup($source, $destination);
  }
}