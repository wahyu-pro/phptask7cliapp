<?php

namespace Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;

class SetCompleted extends Command
{
    protected static $defaultName = 'setcompleted';

    protected function configure()
    {
        $this->setDescription("This  command should done a todo item.")
            ->setName("done")
            ->addArgument("id", InputArgument::REQUIRED, "enter your id todo")
            ->setHelp("Input id for set completed");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $id = $input->getArgument("id");
        $dataJson = file_get_contents("todo.json");
        $data = json_decode($dataJson, true);
        $item = array_filter($data['todos'], function($v) use($id) {return($v["id"] == $id);});
        if($item){
            foreach ($item as $key => $value) {
                $data['todos'][$key]["complete"] = "[Done]";
            }
        }

        $dataWrite = json_encode($data, JSON_PRETTY_PRINT);
        if(file_put_contents("todo.json", $dataWrite)){
            $output->writeln("Message :Set completed success");
        }
        return Command::SUCCESS;
    }
}