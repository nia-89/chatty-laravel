<?php 

namespace App\Services\Parser\WhatsApp;

abstract class FileParser {

    public function parseFile(String $chat) {

        $lines = preg_split("/\r\n|\n|\r/", $chat);

        return $this->parse($lines);

    }

    abstract protected function parse(iterable $lines);
}