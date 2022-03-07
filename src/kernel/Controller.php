<?php

    abstract class Controller{

        protected array $params;
        protected ModelInterface $model;
        protected SessionManagerInterface $session;

        public function __construct(array $params , ModelInterface $model ,SessionManagerInterface $session ){
            $this->model = $model;
            $this->session = $session;
            $this->params = $params;
        }        
        
        protected function redirectTo(string $url) : void{
            header("Location: ${url}");
            exit;
        }

        protected function forward404(string $message = "") : void{
            throw new Code404Exception($message);
        }

    }


?>