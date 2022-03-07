
<?php

    class RoutingManager{

        ///オブジェクトフィールド
        private array $routes;

        public function __construct(array $routeDifinitions){

            $this->routes = $this->compileRoutes($routeDifinitions);

        }

        //routingに登録されたデータを適切な形に変換する
        private function compileRoutes(array $routeDifinitions) : array{

            $routes = array();

            foreach($routeDifinitions as $key_url => $routeParams){
                $key_url= $this->createRegularedUrl($key_url);
                //正規表現変換されたキーを元に配列の要素を作り、格納しなおす
                $routes[$key_url] = $routeParams;
            }

            return $routes;
        }


        private function convertTokenIntoRegular(string $token) : string{
            //トークンが:（コロン）で始まっている場合
            if(strpos($token, ':') === 0){
                //:の1文字目から後ろを全て抽出する
                $tokenName = substr($token , 1);
                //スラッシュ以外の文字であった時の正規表現
                $token = "(?P<${tokenName}>[^/]+)";
            }
            return $token;
        }

        //正規表現化されたUrlを返す
        private function createRegularedUrl(string $url) : string{
            //Urlをスラッシュ毎に区切る
            $tokens = explode('/' , $url);
            //トークンがセミコロン付きのものであったら
            foreach($tokens as $i => $token){
                $tokens[$i] = $this->convertTokenIntoRegular($token);
            }
            return implode('/' , $tokens);
        }

        //URLキーがpathinfoと一致するrouteを探し出す
        public function searchBy($pathInfo) : array{

            foreach($this->routes as $key_url => $route){
                //$pathInfoの値が、正規表現にそのままマッチしていても、正規表現/の形にマッチしていてもどちらでもサーチできる
                if(preg_match("#^${key_url}$#" , $pathInfo , $matches) || preg_match("#^${key_url}/$#" , $pathInfo , $matches) ){
                    $searchedRoute = array_merge($route , $matches);
                    return $searchedRoute;
                }
            }
            //routeが見つからなかった時は404エラーを出す
            throw new Code404Exception("Routing Error!");
        }

    }

?>