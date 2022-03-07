<?php

//各クラスを実際に動かす
class Host{

    //インスタンス用
    private object $requestManager;
    private object $routingManager;
    private object $dbManager;
    private object $sessionManager;
    private object $controllerManager;
    private object $viewManager;
    private object $responseManager;

    //通常データ用
    private string $rootDir;
    private array $configs;

    public function __construct(string $rootDir)
    {

        $this->rootDir = $rootDir;
        $this->setConfigs();
        $this->requestManager = new RequestManager();
        $this->routingManager = new RoutingManager($this->getRoutes());
        $this->dbManager = new DbManager($this->configs['db_info']);
        $this->sessionManager = new SessionManager();
        $this->sessionManager->regenerate();
        $this->controllerManager = new ControllerManager("{$this->rootDir}/app/controllers");
        $this->viewManager = new ViewManager("{$this->rootDir}/app/views" , "{$this->rootDir}/app/layouts");
        $this->responseManager = new ResponseManager();

    }

    private function setConfigs() : void
    {

        $this->configs = [

            'debug_mode' => true,
            'db_info' =>
            [
                'dsn' => 'mysql:host=db_server;dbname=test;charset=utf8' ,
                'user_name' => 'root' ,
                'passwd' => 'root_pswd'
            ]
        
        ];

        //configファイルに値が設定されていた場合は、各値を上書きする
        require_once "{$this->rootDir}/app/config.php";

        //array_mergeによって、configファイル内で、設定されてるconfigsの要素で、各キーに対応する要素を上書きできる
        $this->configs = array_replace($this->configs , $configs);
        
    }
    
    public function run() : void
    {

        //正常
        try{
            $this->normalRoutine();
        }
        //404エラー
        catch(Code404Exception $e){
            $this->exceptionRoutine($e);
            $this->responseManager->setStatus(404 , 'Not Found');
        }
        //データベース関係のエラー
        catch(PDOException $e){
            $this->exceptionRoutine($e);
            $this->responseManager->setStatus(501 , 'Not Implemented');
        }
        finally{
            $this->responseManager->send();
        }

    }

    //通常の処理
    private function normalRoutine() : void
    {

        //var_dump($this->requestManager->isPost());

        //データベース接続
        $this->dbManager->connect();

        //リクエスされたURIからルートを取得
        $pathInfo = $this->requestManager->pathInfo();
        $params = $this->routingManager->searchBy($pathInfo);

        //postとgetをparamsに含める
        $params = array_merge($params , $this->requestManager->getGets() , $this->requestManager->getPosts());
        
        //controllerManagerにルーティングで特定されたパラメーターと、モデルオブジェクト、セッションマネージャーオブジェクトを渡す
        $this->controllerManager->init( new Model($this->dbManager) , $this->sessionManager , $params );
        $resultsOfAction = $this->controllerManager->runAction();
        
        //viewManagerがビューを特定
        $this->viewManager->init($params);
        $content = $this->viewManager->render($resultsOfAction);
        
        //ビューをレスポンス
        $this->responseManager->setContent($content);

    }

    //例外が起こった場合の処理
    private function exceptionRoutine(object $e) : void
    {

        //例外の種類に対応したレイアウトファイルを取得
        $fileName = 'exception_layouts/'.get_class($e).'.php';
        $message = "";

        //デバッグモードの場合はエラーメッセージを表示する
        if($this->configs['debug_mode']){
            $message = $e->getMessage();
        }

        //例外用のテンプレートファイルをバッファリングする
        ob_start();
        ob_implicit_flush();
        require_once $fileName;
        $content = ob_get_clean();

        //コンテンツのセット
        $this->responseManager->setContent($content);       

    }

    private function getRoutes() : array
    {

        require_once "{$this->rootDir}/app/routes.php";
        return $routes;

    }

}

?>