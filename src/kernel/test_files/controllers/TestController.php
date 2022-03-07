<?php

    class TestController{

        private array $params;
        public function __construct(array $params){
            $this->params = $params;
        }

        public function getParams() : array{
            return $this->params;
        }

        public function action1(){
            return [1,2,3];
        }

        public function action2(){

        }

    }

?>