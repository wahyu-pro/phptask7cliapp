<?php

namespace Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;

class DeleteCommand extends Command
{
    protected static $defaultName = 'delete';

    protected function configure()
    {
        $this->setDescription("This  command should delete a todo item.")
            ->setName("delete")
            ->addArgument("id", InputArgument::REQUIRED, "enter your id todo")
            ->setHelp("Input id for delete [id] ");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $id = $input->getArgument("id");
        $dataJson = file_get_contents("todo.json");
        $data = json_decode($dataJson, true);
        $item = array_filter($data['todos'], function($v) use($id) {return($v["id"] == $id);});
        if($item){
            foreach ($item as $key => $value) {
                array_splice($data['todos'], $key, 1);
            }
        }

        $dataWrite = json_encode($data, JSON_PRETTY_PRINT);
        if(file_put_contents("todo.json", $dataWrite)){
            $output->writeln("Message : data berhasil dihapus");
        }
        $data = array_map(function($v){return $v['id']." ".$v['title']." ".($v['complete'] ? '[Done]' : '');}, $data["todos"]);
        $output->writeln($data);
        return Command::SUCCESS;
    }
}