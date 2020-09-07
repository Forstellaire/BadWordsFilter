<?php

namespace BadWords;

class BadWordsFilter
{

    /**
     * @param string $string
     * @param string|null $dictionnary
     * @return mixed|string
     */
    public function censureWords(string $string, string $dictionnary = null)
    {
        //Check if $dictionary is null or not to get the right file
        if ($dictionnary === null) {
            return $this->checkFileCacheExistence($string, 'BadWordsCache');
        }

        //If $dictionnary is true we gonna get one dictionnary to filter and if doesn't exist we need to create it
        if (file_exists(__DIR__ . "/Cache/$dictionnary.php")) {
            return $this->checkFileCacheExistence($string, "$dictionnary");
        } else {
            $this->createFileCache($dictionnary, false);
        }
    }

    /**
     * @param string $string
     * @param $dictionnary
     * @return mixed|string
     */
    public function checkFileCacheExistence(string $string, $dictionnary)
    {
        //Get the CacheFile to replace the bad words
        if (file_exists(__DIR__ . "/Cache/$dictionnary.php")) {
            include __DIR__ . '/Cache/'.$dictionnary.'.php';
            foreach ($array as $word) {
                if (strpos($string, $word) !== FALSE) {
                    return $string = str_replace($word, "****", $string);
                }
            }
            //If the string do not contain any badwords, we just return the string
            return $string;
        }
        //If the file does not exist, we gonna create it
        $this->createFileCache(null, true);
    }

    /**
     * @param string|null $dictionnary
     * @param bool $all
     */
    public function createFileCache(string $dictionnary = null, bool $all = true)
    {
        //Get the directory of all the files in JSON
        $directory = __DIR__ . "/JSON/Lang/";
        $i = 1;

        if ($all === true) {
            $file = glob($directory . "*.json");
            $filePHP = fopen(__DIR__ . "/Cache/BadWordsCache.php", "a");
        } else {
            $file = glob($directory . "$dictionnary.json");
            $filePHP = fopen(__DIR__ . "/Cache/$dictionnary.php", "a");
        }

        //Write inside the file to create an array with all the words
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
