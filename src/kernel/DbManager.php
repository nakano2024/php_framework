<?php

    class DbManager implements DbManagerInterface{

        private ?object $pdoObj;
        private array $params;

        public function __construct(array $params)
        {

            //データベース接続用のパラメータを受け取る
            $this->params = ['dsn' => '' , 'user_name' => '' , 'passwd' => ''];
            $this->params = array_replace($this->params , $params);

        }
        
        public function connect() : void
        {
            //データベースへの接続を行う
            $this->pdoObj = new PDO(
                $this->params['dsn'] , 
                $this->params['user_name'] , 
                $this->params['passwd']
            );
            $this->pdoObj->setAttribute(PDO::ATTR_ERRMODE , PDO::ERRMODE_EXCEPTION);

        }

        public function __destruct(){

            //全ての接続を開放
            $this->pdoObj = null;

        }

        //SQL文を実行する
        public function doSql(string $sql ,array $params = []) : ?array{

            if(is_null($this->pdoObj)){
                return null;
            }
            //sql文の実行
            $stmt = $this->pdoObj->prepare($sql);
            $stmt->execute($params);

            //レコードがない場合はnullを返す
            $recs = array();
            if(empty($recs = $stmt->fetchAll(PDO::FETCH_ASSOC))){
                return null;
            }
            //var_dump($recs);
            return $recs;

        }

    }

?>