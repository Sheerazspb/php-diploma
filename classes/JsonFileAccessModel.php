<?php
    class JsonFileAccessModel 
    {
        protected $fileName;
        protected $file;

        public function __construct($name, $lang_id = null) 
        {
            if ($lang_id != null) {
                $this->fileName = Config::FILES_PATH . $lang_id . '/' . $name . '.json';
            } else {
                $this->fileName = Config::DATABASE_PATH . $name . '.json';
            }
        }

        private function connect($mode) 
        {
            $this->file = fopen($this->fileName, $mode);
            return $this->file;
        }

        private function disconnect() 
        {
            fclose($this->file);
        }

        public function read() 
        {
            if (file_exists($this->fileName) && filesize($this->fileName) > 0) {
                $content = fread($this->connect('r'), filesize($this->fileName));
                $this->disconnect();
                return $content;
            }
        }

        public function write($string) 
        {
            fwrite($this->connect('w'), $string);
            $this->disconnect();
        }

        public function readJson() 
        {
            $content = fread($this->connect('r'), filesize($this->fileName));
            $jsonContent = json_encode($content, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            $this->disconnect();
            return $jsonContent;
        }

        public function writeJson($string) 
        {
            $jsonString = json_encode($string, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            fwrite($this->connect('w'), $jsonString);
            $this->disconnect();
        }
    }
?>