<?php

namespace Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;

class AddCommand extends Command
{
    protected static $defaultName = 'add';

    protected function configure()
    {
        $this->setDescription("This command should add new todo item")
            ->setName("add")
            ->addArgument("todo", InputArgument::REQUIRED, "enter your todo")
            ->setHelp("Input add [todo] ");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $title = $input->getArgument("todo");
        $dataJson = file_get_contents("todo.json");
        $data = json_decode($dataJson, true);
        $generateId = count($data['todos']) + 1;
        $add = [
            "id" => $generateId,
            "title" => $title,
            "complete" => ""
        ];
        array_push($data['todos'], $add);
        $dataWrite = json_encode($data, JSON_PRETTY_PRINT);
        if(file_put_contents("todo.json", $dataWrite)){
            $output->writeln("Message : data berhasil ditambah");
        }
        return Command::SUCCESS;
    }
}