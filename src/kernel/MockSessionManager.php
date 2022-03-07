<?php

    class MockSessionManager implements SessionManagerInterface{

        public function set(string $key , $value ) : void{}
        public function get(string $key){}
        public function delete(string $key) : void{}
        public function destroy(): void{}
        
    }

?>