<?php

    spl_autoload_register(
        function(string $className){
            require_once __DIR__."/${className}.php";
        }
    );
    use PHPUnit\Framework\TestCase;

    class ModelTest extends TestCase{

        private object $model;

        public function setUp():void
        {

            $this->model = new Model(new MockDbManager([]));

        }

        public function testSelect(){

            $results = [
                $this->model->selectAll('test') ,
                $this->model->selectBy('test' , 'column' , 1 ) ,
                $this->model->selectBy('test' , 'prime' , 1 ) ,
                $this->model->selectWhere('test' , 'prime = ?' , 1 ) ,
                $this->model->selectWhere('test' , 'column = ?' , 1 ) 
            ];
            $this->model->getSqlLogs();

            foreach($results as $result){
                $this->assertNotNull($result);
            }

            var_dump($results);

        }

        public function testInsertUpdateDelete(){

            $this->model->insert('test' , ['name' , 'password' , 'email'] , 'tanaka' , 'fdsfadsfdsaf' , 'tanaka@test.jp' );
            $this->model->update('test' , ['name' , 'password' , 'email'] , 'id = ?' , 'yamada' , 'fdassdsvas' , 'yamada@test.jp');
            $this->model->delete('test' , 'id = ?' , 1);
            $this->model->getSqlLogs();
            $this->assertTrue(true);

        }

    }


?>