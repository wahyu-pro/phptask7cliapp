<?php

namespace Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;

class SetUnCompleted extends Command
{
    protected static $defaultName = 'setuncompleted';

    protected function configure()
    {
        $this->setDescription("This  command should undone a todo item.")
            ->setName("undone")
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
                $data['todos'][$key]["complete"] = false;
            }
        }
        $dataWrite = json_encode($data, JSON_PRETTY_PRINT);
        if(file_put_contents("todo.json", $dataWrite)){
            $output->writeln("Message :Set uncompleted success");
        }
        $data = array_map(function($v){return $v['id']." ".$v['title']." ".($v['complete'] ? '[Done]' : '');}, $data["todos"]);
        $output->writeln($data);
        return Command::SUCCESS;
    }
}