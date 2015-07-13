<?php
/**
 * @file
 * Contains BackupMigrate\CLI\Service\ConsoleEnvironment
 */


namespace BackupMigrate\CLI\Service;

use BackupMigrate\Core\Environment\EnvironmentBase;
use BackupMigrate\Core\File\TempFileAdapter;
use Symfony\Component\Console\Logger\ConsoleLogger;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class ConsoleEnvironment
 * @package BackupMigrate\CLI\Service
 */
class ConsoleEnvironment extends EnvironmentBase {

  /**
   * @param \Symfony\Component\Console\Output\OutputInterface $out
   */
  function __construct(OutputInterface $out) {
    $logger = new ConsoleLogger($out);
    $files = new TempFileAdapter('/tmp');
    parent::__construct($files, NULL, NULL, $logger);
  }
}