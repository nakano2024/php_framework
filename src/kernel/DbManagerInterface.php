<?php

    interface DbManagerInterface{

        public function doSql(string $sql ,array $params = []) : ?array;

    }

?>