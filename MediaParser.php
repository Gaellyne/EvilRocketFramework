<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Bukharov Sergey
 * Date: 14.09.11
 * Time: 20:36
 *
 * Управление парсерами
 * @desc Ищет файлы, соотвествующие категории контента,
 * если таковая задана и запускает их.
 *
 */
 
class Evil_MediaParser
{
    //имена файлов с парерами
    private $parserFiles = array();

    //необходимые для текущего парсинга парсеры
    private $classParser = array();


    function __construct()
    {
      //  if (! $this->getFilesWithParsers()) return false;
    }

    //mock object
    public function parse($contentType = null)
    {
        return array ("AVG Anti-Virus Free Edition 201" => array(
    				        "desc" 	 => "Protect your computer from viruses and malicious programs",
    				        "date" 	 => "2011-09-08",
    				        "rating"   => "9",
    				       "download" => "1,044,81")
  					);
/*        if (! $this->getParsersClass($contentType)) return false;

        return $this->classParser;*/
        //инстанцирование и запуск парсеров
    }

    protected function getFilesWithParsers()
    {
        $handle = opendir('Parser');
        if (!$handle)
            throw new Exception('Dir not exist');

        while (false !== ($fileName = readdir($handle))) {
            array_push($this->parserFiles, $fileName);
        }

        if (empty($this->parserFiles)) return null;

        return $this->parserFiles;
    }

    protected function getParsersClass($contentType = null)
    {
        foreach ($this->parserFiles as $key => $parser) {
            //если парсер не нужного типа
            if ((!is_null($contentType)) && (stripos($parser, $contentType) === false))
                continue;

            $className = explode('.', $parser, 1);

            if (!class_exists($className))
                throw new Exception("Parser $className not exist, but file $parser is found");

            array_push($this->classParser, $className);
        }

        if (empty($this->classParser)) return null;
        return $this->classParser;
    }    
}