<?php

return [
  'plugins' => [
    'db' => [
      'type' => '\BackupMigrate\Core\Source\MySQLiSource',
      // #### Enter your DB credentials here ####
      'config' => [
        'host' => '127.0.0.1',
        'database' => 'backupmigratecoretest',
        'user' => 'bamtest',
        'password' => '',
        'port' => '8889',
      ],
    ],
  ],
  'config' => [
    'compression' => [
      'compression' => 'none',
    ],
    'name' => [
      'filename' => 'backup',
      'timestamp' => true,
    ]
  ],
];
