<?php

class MainClass
{
    public function showDirectory() {
        $dir= scandir(__DIR__);
        return $dir;
    }

    public function readFile($file) {
        $data = file_get_contents($file);
        // $return_data = 
        return $data;
    }

}
