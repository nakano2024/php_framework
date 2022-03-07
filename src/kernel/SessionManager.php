<?php

    class SessionManager implements SessionManagerInterface{

        private bool $isStarted = false;

        public function __construct()
        {

            if(!$this->isStarted){
                session_start();
                $this->isStarted = true;
            }

        }

        public function regenerate() : void
        {

            if(!$this->isStarted)return;
            
            session_regenerate_id(true);

        }

        public function set(string $key , $value ) : void
        {

            if(!$this->isStarted)return;
            
            $_SESSION[$key] = $value;
            
        }

        public function get(string $key)
        {

            if(!$this->isStarted)return;

            if(!isset($_SESSION[$key]))
            {
                return null;
            }
            
            return $_SESSION[$key];
            
        }

        public function deleteAll() : void
        {

            if(!$this->isStarted)return;

            $_SESSION = [];

        }

        public function delete(string $key) : void
        {


            if(!$this->isStarted)return;

            if(!isset($_SESSION[$key]))
            {
                return;
            }

            unset($_SESSION[$key]);
            
        }

        public function destroy(): void
        {

            if(!$this->isStarted)return;

            $_SESSION = [];

            if(isset($_COOKIE[session_name()]))
            {
                $cookieParams = session_get_cookie_params();
                setcookie($cookieParams['name'], '',time() - 300 , $cookieParams['path'] , $cookieParams['secure'] , $cookieParams['httponly']);  
            }

            session_destroy();

        }

    }

?>