#!/usr/bin/env php
<?php
// backup_migrate.php

require __DIR__.'/vendor/autoload.php';

use BackupMigrate\Core\Config\Config;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Output\StreamOutput;
use BackupMigrate\Core\Services\BackupMigrate;
use BackupMigrate\Core\Destination\StreamDestination;
use BackupMigrate\CLI\Service\ConsoleEnvironment;
use BackupMigrate\CLI\Command\BackupCommand;

// Load up the config file for the database settings.
$config = require './config.php';

$output = new StreamOutput(fopen('php://stderr', 'w'));
$env = new ConsoleEnvironment($output);
$bam = new BackupMigrate($env, new Config($config['config']));

// Load the plugins specified in the config.
foreach ($config['plugins'] as $id => $plugin) {
  $bam->plugins()->add(
    new $plugin['type'](new Config($plugin['config'])),
    $id
  );
}
// Add the stdout destination
$bam->plugins()->add(
  new StreamDestination(new Config(['streamuri' => 'php://stdout'])),
  'stdout'
);
$bam->plugins()->add(new \BackupMigrate\Core\Filter\CompressionFilter(), 'compression');
$bam->plugins()->add(new \BackupMigrate\Core\Filter\FileNamer(), 'name');

$application = new Application();
$application->add(new BackupCommand($bam));
$application->run(null, $output);