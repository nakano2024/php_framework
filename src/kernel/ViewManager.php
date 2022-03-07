<?php

    class ViewManager{

        private array $params;
        private string $viewDir;
        private string $layoutDir;
        private string $viewFileName;
        private string $layoutFileName;
        private string $defaultLayoutFile;

        public function __construct(string $viewDir , string $layoutDir){
            $this->params = ['action' => '' , 'controller' => ''];
            $this->viewDir = $viewDir;
            $this->layoutDir = $layoutDir;
            $this->defaultLayoutFile = "{$this->layoutDir}/default.php";

        }

        public function init(array $params) : void{

            $this->params = array_replace($this->params , $params);
            $this->viewFileName = "{$this->viewDir}/{$params['controller']}/{$params['action']}.php";
            $this->layoutFileName = "{$this->layoutDir}/{$params['controller']}.php";

        }

        private function mergeViewLayout(string $content) : string{

            //バッファリングのスタート
            ob_start();
            ob_implicit_flush();
            
            //controllerに対応するlayoutファイルが存在する場合はそれをレイアウトとして読み込む
            if(is_readable($this->layoutFileName)){
                //レイアウトファイル内の$contentに引数の値が埋め込まれる
                require_once $this->layoutFileName;
                return ob_get_clean();
            }

            //コントローラに対応するレイアウトが存在しなければデフォルトのレイアウトファイルを読み込む
            if(is_readable($this->defaultLayoutFile)){
                require_once $this->defaultLayoutFile;
                return ob_get_clean();
            }

            //レイアウトが存在しなかった場合は、$contentの値をそのまま返す
            return $content;

        }

        public function render(?array $resultsOfAction) : string{

            //ビューファイルが見つからなかったとき404エラーを出す
            if(!is_readable($this->viewFileName)){
                throw new Code404Exception("View File Not Found");
            }

            //アクションで定義された変数をviewで使えるように展開する
            if(!is_null($resultsOfAction)){
                extract($resultsOfAction);
            }
            
            //バッファリングのスタート
            ob_start();
            ob_implicit_flush();

            //viewファイルの読み込み
            require_once $this->viewFileName;

            //バッファリングの実行結果を文字列として保管
            $content = ob_get_clean();
            
            //コンテンツとレイアウトファイルを統合する
            $content = $this->mergeViewLayout($content);

            //var_dump(htmlspecialchars($content));
            return $content;

        }
        
    }

?>