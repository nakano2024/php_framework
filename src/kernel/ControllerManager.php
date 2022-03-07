<?php

    //コントローラーとアクションを特定し、実行する
    class ControllerManager{

        private array $params;
        private $action;
        private string $dir;

        public function __construct(string $dir)
        {
            $this->params = ['action' => '' , 'controller' => ''];
            $this->dir = $dir;
        }

        public function init(ModelInterface $model , SessionManagerInterface $session , array $params ) : void
        {
            
            $this->params = array_replace($this->params , $params);

            //paramsのコントローラー名からクラス名を生成
            $className = ucfirst($this->params['controller']).'Controller';

            //クラスファイル名を作成し、それが読み込み可能でなければ404エラーを出す
            $classFile = "{$this->dir}/${className}.php";
            if(!is_readable($classFile)){
                throw new Code404Exception("Controller Not found!");
            }
            require_once $classFile;

            $controller = new $className($params , $model , $session);

            //アクションを探し出し、見つからなければ404エラーを出す。
            if(!method_exists($controller , $this->params['action'])){
                throw new Code404Exception("Action Not found!");
            }
            $this->action = [$controller , $this->params['action'] ];

        }

        //アクションの戻り値はnullか配列のどちらか
        public function runAction() : ?array
        {

            $actionMethod = $this->action;

            //アクションを呼び出す
            $resultsOfAction = $actionMethod();

            return $resultsOfAction;

        }

    }

?>