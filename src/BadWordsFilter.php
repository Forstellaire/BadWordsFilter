<?php

namespace BadWords;

class BadWordsFilter
{

    public function censureWords(string $string)
    {
        return $this->checkFileCacheExistence($string);
    }

    public function checkFileCacheExistence(string $string)
    {
        if (file_exists("Cache/BadWordsCache.php")) {
            include 'Cache/BadWordsCache.php';
            foreach ($array as $word) {
                if (strpos($string, $word) !== FALSE) {
                    return $string = str_replace($word, "****", $string);
                }
            }
            return $string;
        }

        $this->createFileCache();
    }

    public function getAllDictionnary()
    {
        foreach (new \DirectoryIterator('JSON/Lang/') as $file) {
            if ($file->isFile()) {
                print_r($file->getFilename());
            }
        }
    }

    public function createFileCache()
    {
        $directory = "JSON/Lang/";
        $file = glob($directory . "*.json");
        $filePHP = fopen("Cache/BadWordsCache.php", "a");
        $i = 1;
        fwrite($filePHP, "<?php");
        fwrite($filePHP, "\n");
        fwrite($filePHP, '$array = [');
        fwrite($filePHP, "\n");
        foreach($file as $filename){
            $json = file_get_contents($filename);
            $jsonFile = json_decode($json);
            foreach ($jsonFile as $word) {
                fwrite($filePHP, '"'.$i++.'"'. " => " . '"' .$word. '"' .",");
                fwrite($filePHP, "\n");
            }
        }
        fwrite($filePHP, "]");
        fwrite($filePHP, "\n");
        fwrite($filePHP, "?>");
    }

}

$filter = new BadWordsFilter();
echo $filter->censureWords("tu es un connard");
