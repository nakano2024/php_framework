<?php

    class ClassAutoLoader{

        protected array $dirs;

        public function __construct(){
            spl_autoload_register([$this , 'loadClassCallback']);
        }

        public function setDirs($dirName) : void{
            $this->dirs[] = $dirName;
        }

        public function loadClassCallback($className) : void{
            foreach($this->dirs as $dir){
                $filePass = "${dir}/${className}.php";
                //ファイルパスが読み込み不可であった場合、次のループへ
                if(!is_readable($filePass))continue;
                require_once($filePass);
                return; 
            }
        }
    }

?>