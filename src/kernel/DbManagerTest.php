<?php
    spl_autoload_register(
        function(string $className){
            require_once __DIR__."/${className}.php";
        }
    );

    use PHPUnit\Framework\TestCase;

    class DbManagerTest extends TestCase{

        private ?object $dbManager;

        public function setUp() : void
        {

            $this->dbManager = new DbManager([
                'dsn' => 'mysql:host=db_server;dbname=test;charset=utf8',
                'user_name' => 'root',
                'passwd' => 'root_pswd'
            ]);
            $this->dbManager->connect();
            $this->assertTrue(true);

        }

        public function testDoSql() : void
        {

            //レコードを取得できるSQL文を投げた時、取得できれば良い
            $this->assertNotNull(
                $this->dbManager->doSql('SELECT * FROM test_table WHERE id = 10')
            );

            //レコードが空となるSQL文を投げたときにnullが帰ってこれば良い
            $this->assertNull(
                $this->dbManager->doSql('SELECT * FROM test_table WHERE id = 1 && id = 2')
            );

        }

    }

?>