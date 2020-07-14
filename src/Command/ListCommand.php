<?php

namespace Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ListCommand extends Command
{
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'list';

    protected function configure()
    {
        $this->setDescription("This command to show all todo items")
            ->setName("list")
            ->setHelp("Input List is required");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $dataJson = file_get_contents("todo.json");
        $data = json_decode($dataJson, true);
        $data = array_map(function($v){return($v['id']." ".$v['title']." ".$v['complete']);}, $data["todos"]);
        $output->writeln($data);
        return Command::SUCCESS;
    }
}