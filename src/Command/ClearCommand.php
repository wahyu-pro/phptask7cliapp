<?php

namespace Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ClearCommand extends Command
{
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'clearcommand';

    protected function configure()
    {
        $this->setDescription("This command to clear all todo items")
            ->setName("clear")
            ->setHelp("Input clear is required");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $dataJson = file_get_contents("todo.json");
        $data = json_decode($dataJson, true);
        $data['todos'] = [];
        $output->writeln("Data berhasil di clear");

        $dataWrite = json_encode($data, JSON_PRETTY_PRINT);
        if(file_put_contents("todo.json", $dataWrite)){
            $output->writeln("Message : data berhasil diupdate");
        }
        return Command::SUCCESS;
    }
}