<?php

    require_once __DIR__.'/ClassAutoLoader.php';

    use PHPUnit\Framework\TestCase;

    class ClassAutoLoaderTest extends TestCase{

        public function setUp() : void
        {

            $autoLoader = new ClassAutoLoader();
            $autoLoader->setDirs(__DIR__);

        }

        public function test()
        {
            
            //インスタンス化したクラスが自動で読み込まれているか調べる
            $obj1 = new MockModel();
            $this->assertInstanceOf('MockModel' , $obj1);
            
        }

    }

?>