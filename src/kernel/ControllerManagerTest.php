<?php

    spl_autoload_register(
        function(string $className){
            require_once __DIR__."/${className}.php";
        }
    );
  
    use PHPUnit\Framework\TestCase;

    class ControllerManagerTest extends TestCase{

        private array $controllerManagers;

        public function setUp() : void
        {

            $routes = [
                ['controller' => 'test' ,'action' => 'action1' ],
                ['controller' => 'test' ,'action' => 'action2' ]
            ];
            foreach($routes as $i => $route){
                $this->controllerManagers[] = new ControllerManager(__DIR__.'/test_files/controllers');
                $this->controllerManagers[$i]->init($route ,new MockModel , new MockSessionManager);
            }

        }

        public function testRunAction() : void
        {

            $result1 = $this->controllerManagers[0]->runAction();
            $result2 = $this->controllerManagers[1]->runAction();

            $this->assertNotNull($result1);
            var_dump($result1);
            $this->assertNull($result2);
            var_dump($result2);

        }

    }

?>