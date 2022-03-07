<?php

    spl_autoload_register(
        function(string $className){
            require_once __DIR__."/${className}.php";
        }
    );

    use PHPUnit\Framework\TestCase;

    class ViewManagerTest extends TestCase{

        private array $viewManager;

        public function setUp() : void
        {

            $params = [
                ['controller' => 'controller1' , 'action' => 'action'],
                ['controller' => 'controller2' , 'action' => 'action']
            ];

            foreach($params as $i => $param){
                $this->viewManager[] = new ViewManager(
                    __DIR__.'/test_files/views' ,
                    __DIR__.'/test_files/layouts'
                );
                $this->viewManager[$i]->init($param);
            }


        }

        public function testRender(){

            $result1 = $this->viewManager[0]->render(['value' => 'test']);
            $result2 = $this->viewManager[1]->render(NULL);

            //コントローラー名に対応するレイアウトファイルが存在する場合、そのファイルが読み込まれるか
            $this->assertMatchesRegularExpression(
                '/controller1_layout/',
                $result1
            );

            //引数にアクションの実行結果を格納する配列が渡された時、それがviewファイルに反映されているか
            $this->assertMatchesRegularExpression(
                '/test/',
                $result1
            );

            var_dump($result1);

            //コントローラー名に対応するレイアウトファイルが存在しない場合、デフォルトレイアウトが読み込まれるか
            $this->assertMatchesRegularExpression(
                '/default_layout/',
                $result2
            );
            var_dump($result2);

        }

    }


?>