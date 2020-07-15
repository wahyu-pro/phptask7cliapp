<?php

namespace Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;

class UpdateCommand extends Command
{
    protected static $defaultName = 'update';

    protected function configure()
    {
        $this->setDescription("This command should update todo item")
            ->setName("update")
            ->addArgument("id", InputArgument::REQUIRED, "enter your id todo")
            ->addArgument("todo", InputArgument::REQUIRED, "enter your update todo")
            ->setHelp("Input update [todo] ");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $id = $input->getArgument("id");
        $title = $input->getArgument("todo");
        $dataJson = file_get_contents("todo.json");
        $data = json_decode($dataJson, true);
        $item = array_filter($data['todos'], function($v) use($id) {return($v["id"] == $id);});
        if($item){
            foreach ($item as $key => $value) {
                $data['todos'][$key]["title"] = $title;
            }
        }

        $dataWrite = json_encode($data, JSON_PRETTY_PRINT);
        if(file_put_contents("todo.json", $dataWrite)){
            $output->writeln("Message : data berhasil diupdate");
        }
        $data = array_map(function($v){return $v['id']." ".$v['title']." ".($v['complete'] ? '[Done]' : '');}, $data["todos"]);
        $output->writeln($data);
        return Command::SUCCESS;
    }
}