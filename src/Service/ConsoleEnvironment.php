<?php
/**
 * @file
 * Contains BackupMigrate\CLI\Service\ConsoleEnvironment
 */


namespace BackupMigrate\CLI\Service;

use BackupMigrate\Core\Services\EnvironmentBase;
use BackupMigrate\Core\Services\TempFileAdapter;
use BackupMigrate\Core\Services\TempFileManager;
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
    $files = new TempFileManager(new TempFileAdapter('/tmp'));
    parent::__construct($files, NULL, NULL, $logger);
  }
}