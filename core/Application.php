<?php
namespace app\core;
class Application{
    public static string $ROOT_DIR;
    public Router $router;
    public Request $request;
    public Response $response;
    public Database $db;
    public static Application $app;
    public function __construct($path,array $config)
    {
        self::$app=$this;
        self::$ROOT_DIR=$path;
        $this->response=new Response();
        $this->request=new Request();
        $this->db=new Database($config['db']);
        $this->router=new Router($this->request,$this->response);
    }
    public function run(){
        echo $this->router->resolve();
    }   
}
?>