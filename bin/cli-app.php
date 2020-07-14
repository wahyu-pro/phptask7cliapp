<?php

// application.php

require __DIR__.'/../vendor/autoload.php';

use Console\Command\ListCommand;
use Console\Command\AddCommand;
use Console\Command\UpdateCommand;
use Console\Command\DeleteCommand;
use Console\Command\SetCompleted;
use Console\Command\SetUnCompleted;
use Console\Command\ClearCommand;
use Symfony\Component\Console\Application;

$application = new Application();

// ... register commands
$application->add(new ListCommand());
$application->add(new AddCommand());
$application->add(new UpdateCommand());
$application->add(new DeleteCommand());
$application->add(new SetCompleted());
$application->add(new SetUnCompleted());
$application->add(new ClearCommand());

$application->run();

?>