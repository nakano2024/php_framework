

<?php

    //SQL文を発行してCRUD処理を行う
    class Model implements ModelInterface{

        private DbManagerInterface $dbManager;
        private array $sqlLogs;

        //単体テスト用コンストラクタ
        public function __construct(DbManagerInterface $dbManager)
        {
            $this->dbManager = $dbManager;
        }

        public function getSqlLogs() : void
        {
            var_dump($this->sqlLogs);
        }

        public function selectAll(string $table) : ?array
        {

            $sql = "SELECT * FROM {$table} ";
            $recs = $this->dbManager->doSql($sql);
            $this->sqlLogs[] = $sql;
            if(is_null($recs)){
                return null;
            }
            return $recs;

        }

        public function selectWhere(string $table , string $cond , ...$params)
        {

            $sql = "SELECT * FROM ${table} WHERE ${cond} ";
            $recs = $this->dbManager->doSql($sql , $params);
            $this->sqlLogs[] = $sql;
            if(is_null($recs)){
                return null;
            }
            return $recs;

        }

        public function selectBy(string $table ,string $column , $value )
        {

            $sql = "SELECT * FROM ${table} WHERE ${column} = ? ";
            $recs = $this->dbManager->doSql($sql , [$value]);
            $this->sqlLogs[] = $sql;

            if(is_null($recs)){
                return null;
            }          
            return $recs;

        }

        public function insert(string $table ,array $columns = [], ...$params) : void
        {

            $prepareds = [];
            foreach($columns as $column){
                $prepareds[] = '?';
            }
            $sql = "INSERT INTO ${table}(".implode(',' , $columns).") VALUES(".implode(',' , $prepareds).") ";
            $this->dbManager->doSql($sql , $params);
            $this->sqlLogs[] = $sql;

        }

        public function update(string $table ,array $columns ,string $cond , ...$params) : void
        {

            $prepareds = [];
            foreach($columns as $column){
                $prepareds[] = "${column} = ?";
            }
            $sql = "UPDATE ${table} SET ".implode(',' , $prepareds)." WHERE $cond ";
            $this->dbManager->doSql($sql , $params);
            $this->sqlLogs[] = $sql;
            
        }

        public function delete(string $table ,string $cond , ...$params):void
        {

            $sql = "DELETE FROM ${table} WHERE $cond ";
            $this->dbManager->doSql($sql , $params);
            $this->sqlLogs[] = $sql;
            
        }

    }

?>