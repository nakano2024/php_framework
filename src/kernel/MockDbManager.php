<?php

    class MockDbManager implements DbManagerInterface{

        public function __construct(array $params){}

        public function doSql(string $sql ,array $params = []) : ?array{
            
            $recs1 = [
                ['name' => 'tanaka' , 'age' => 25 , 'created_at' => '2022-3-4 00:00:00'],
                ['name' => 'yamada' , 'age' => 30 , 'created_at' => '2022-3-4 00:10:00']
            ];

            $recs2 = [
                ['name' => 'tanaka' , 'age' => 25 , 'created_at' => '2022-3-4 00:00:00']
            ];

            //レコードを2つ以上取得できるパターン
            if(preg_match('/SELECT/' , $sql) && preg_match('/column/' , $sql) || 
            preg_match('/SELECT/' , $sql) && !preg_match('/WHERE/' , $sql)){
                return $recs1;
            }

            //レコードをひとつだけ取得できるパターン
            if(preg_match('/SELECT/' , $sql) && preg_match('/prime/' , $sql) ){
                return $recs2;
            }

            return null;
        }

    }

?>