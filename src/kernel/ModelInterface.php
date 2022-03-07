<?php

    interface ModelInterface{

        public function selectAll(string $table) : ?array;
        public function selectWhere(string $table , string $cond , ...$params);
        public function selectBy(string $table ,string $column , $value );
        public function insert(string $table ,array $columns , ...$params) : void;
        public function update(string $table ,array $columns ,string $cond , ...$params) : void;
        public function delete(string $table ,string $cond , ...$params) : void;

    }

?>