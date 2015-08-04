#!/usr/bin/env php
<?php
// backup_migrate.php

require __DIR__.'/vendor/autoload.php';

use BackupMigrate\Core\Config\Config;
use BackupMigrate\Core\File\TempFileManager;
use BackupMigrate\Core\Filter\CompressionFilter;
use BackupMigrate\Core\Filter\FileNamer;
use BackupMigrate\Core\Plugin\PluginManager;
use BackupMigrate\Core\Service\ServiceLocator;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Logger\ConsoleLogger;
use Symfony\Component\Console\Output\StreamOutput;
use BackupMigrate\Core\Main\BackupMigrate;
use BackupMigrate\Core\Destination\StreamDestination;
use BackupMigrate\Core\File\TempFileAdapter;
use BackupMigrate\CLI\Command\BackupCommand;

// Load up the config file for the database settings.
$config = require './config.php';

$output = new StreamOutput(fopen('php://stderr', 'w'));

// Create the service locator
$services = new ServiceLocator();
$services->add('Logger',
  new ConsoleLogger($output)
);

$services->add('TempFileManager',
  new TempFileManager(new TempFileAdapter('/tmp'))
);

// Create the plugin manager
$plugins = new PluginManager($services);

// Load the plugins specified in the config.
foreach ($config['plugins'] as $id => $plugin) {
  $plugins->add(
    $id,
    new $plugin['type'](new Config($plugin['config']))
  );
}
// Add the stdout destination
$plugins->add(
  'stdout',
  new StreamDestination(new Config(['streamuri' => 'php://stdout']))
);
$plugins->add('compression', new CompressionFilter());
$plugins->add('name', new FileNamer());

// Configure the plugins
$plugins->setConfig(new Config($config['config']));

// Create the service object.
$bam = new BackupMigrate($plugins);

$application = new Application();
$application->add(new BackupCommand($bam));
$application->run(null, $output);

$bam->plugins()->setConfig(['db' => []]);