<?php

namespace App\Handler;

class CSVHandler {

    private $handler;
    private $columnsNumber;

    public function __construct($filePath, $columnsNumber, $firstRowIsHeader = false)
    {
        $fileSystem = new \Symfony\Component\Filesystem\Filesystem();
        if ($fileSystem->exists($filePath)) {
            $this->handler = fopen($filePath, "r");
            $this->columnsNumber = $columnsNumber;
            if ($firstRowIsHeader) {
                fgetcsv($this->handler, 1500, ",");
            }
        }
    }

    public function getNextRow(){
        $data = fgetcsv($this->handler, 1500, ",");
        if ($data !== FALSE && count($data ) < $this->columnsNumber) {
            return $this->getNextRow();
        }
        return $data;
    }
}