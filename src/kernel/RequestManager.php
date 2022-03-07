<?php

    class RequestManager{

        //HTTPメソッドがpostかどうか調べる
        public function isPost() : bool{
            if($_SERVER['REQUEST_METHOD'] === 'POST' ){
                return true;
            }
            return false;
        }

        public function getGets() : array
        {
            //var_dump($_GET);
            return $_GET;
        }

        public function getPosts() : array
        {
            //var_dump($_POST);
            return $_POST;
        }

        public function hostName() : string{
            return $_SERVER['HTTP_HOST'];
        }

        public function isSsl() : bool{
            if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on'){
                return true;
            }
            return false;
        }

        private function requestUri() : string{
            return $_SERVER['REQUEST_URI'];
        }

        private function baseUrl() : string{

            $requestUri = $this->requestUri();
            $scriptName = $_SERVER['SCRIPT_NAME'];

            //var_dump($requestUri);
            //var_dump($_SERVER['SCRIPT_NAME']);
            //フロントコントローラーファイルがURLに含まれる
            if(strpos($requestUri , $scriptName) === 0){
                return $scriptName;
            }
            
            //フロントコントローラーファイルがURLに含まれない
            //scriptNameのディレクトリがルートディレクトリ/であった場合、/を削除して返す
            if(preg_match("#^/$#" , dirname($scriptName), $matches)){
                //var_dump($matches);
                return str_replace($matches[0] ,"",dirname($scriptName));
            }

            //scriptNameのディレクトリがルートでない場合
            return dirname($scriptName);

        }

        public function pathInfo() : string{

            $requestUri = $this->requestUri();
            $baseUrl = $this->baseUrl();
            //var_dump($baseUrl);

            //URIにゲットパラメータがあった場合
            if(($pos = strpos($requestUri , '?')) !== false){
                $requestUri = substr($requestUri , 0, $pos);
            }

            $pathInfo = str_replace($baseUrl , "" , $requestUri);
            //var_dump($pathInfo);
            return $pathInfo;
        }

    }


?>