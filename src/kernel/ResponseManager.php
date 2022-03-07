<?php

    //HTTPレスポンスのヘッダーなどの情報を管理し、コンテンツ（HTML）のレンダリングも行う

    class ResponseManager{

        //ステータスコード
        protected int $status_code;
        protected string $status_massage;

        //ヘッダー情報
        protected array $httpHeaders;

        //コンテンツデータ
        protected string $content;

        public function __construct(){
            $this->httpHeaders = [];
            $this->status_code = 200;
            $this->status_massage = 'OK';
        }

        public function setStatus(int $code , string $massage) : void{
            $this->status_code = $code;
            $this->status_massage = $massage;
        }

        public function setHeader(string $key , $value) : void{
            //存在する配列の要素への重複格納を防止する
            if(!is_set($this->httpHeaders[$key])){
                $this->httpHeaders[$key] = $value;
            }
        }

        public function setContent(string $content) : void{
            $this->content = $content;
        }

        public function send() : void{
            //ステータスコードのヘッダを追加
            header("HTTP/1.1 {$this->status_code} {$this->status_massage}");

            //任意のヘッダを追加
            foreach($this->httpHeaders as $key => $httpHeader){
                header("${key} : {$this->httpHeaders}");
            }

            //コンテンツを出力
            echo $this->content;
        }

    }

    //$responseManager = new ResponseManager("HelloWorld");
    //$responseManager->send();

?>