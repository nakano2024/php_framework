<?php

    spl_autoload_register(
        function(string $className){
            require_once __DIR__."/${className}.php";
        }
    );

    use PHPUnit\Framework\TestCase;

    class RoutingManagerTest extends TestCase{

        private object $routingManager;

        public function setUp() : void
        {
            $routes = [
                '/url' => ['contoller' =>  'a' , 'action' => 'index'],
                '/url/:id' => ['controller' => 'a' , 'action' => 'show']
            ];
            $this->routingManager = new RoutingManager($routes);
        }

        public function testSearchBy() : void
        {

            $this->assertNotNull(
                $this->routingManager->searchBy('/url')
            );

            $this->assertNotNull(
                $this->routingManager->searchBy('/url/')
            );
            var_dump($this->routingManager->searchBy('/url/'));

            $this->assertNotNull(
                $this->routingManager->searchBy('/url/1')
            );
            var_dump($this->routingManager->searchBy('/url/1'));

            $this->assertNotNull(
                $this->routingManager->searchBy('/url/1/')
            );   
            var_dump($this->routingManager->searchBy('/url/1/'));

        }

    }

?>