<?php


namespace atpro\phpmvc;


use atpro\phpmvc\db\Database;
use atpro\phpmvc\db\DbModel;

/**
 * Class Application
 * @package atpro\phpmvc
 */
class Application
{

    public static string $_ROOT_DIR;

    public string $layout = 'main';
    public string $userClass;
    public Router $router;
    public Request $request;
    public Database $db;
    public Response $response;
    public Session $session;
    public static Application $app;
    public ?Controller $controller = null;
    public ?UserModel $user = null;
    public View $view ;

    /**
     * Application constructor.
     * @param $rootPath
     * @param array $config
     */
    public function __construct( $rootPath, array $config )
    {
        $this->userClass = $config['userClass'];
        self::$_ROOT_DIR = $rootPath;
        self::$app = $this;
        $this->request = new Request();
        $this->response = new Response();
        $this->session = new Session();
        $this->router = new Router($this->request, $this->response);

        $this->view = new View();

        $this->db = new Database($config['db']);

        $primaryvalue = $this->session->get('user');
        if ($primaryvalue) {
            $primarykey = $this->userClass::primarykey();
           $this->user =  $this->userClass::findOne([$primarykey => $primaryvalue]);
        }
    }


    /**
     * @return Controller
     */
    public function getController(): Controller
    {
        return $this->controller;
    }

    /**
     * @param Controller $controller
     */
    public function setController(Controller $controller): void
    {
        $this->controller = $controller;
    }


    public function run(): void
    {
       try {
           echo $this->router->resolve();
       }catch (\Exception $e){
           $this->response->setStatusCode($e->getCode());
           echo $this->view->renderView('_error', [
               'exception' => $e
           ]);
       }
    }

    /**
     * @param UserModel $user
     * @return bool
     */
    public function login(UserModel $user): bool
    {
        $this->user = $user;
        $primarykey = $user->primarykey();
        $primaryvalue = $user->{$primarykey};
        $this->session->set('user', $primaryvalue);
        return true;

    }

    /**
     * Permet de deconnecter l'utilisateur
     */
    public function logout()
    {
        $this->user=null;
        $this->session->remove('user');
    }

    /**
     * @return bool
     */
    public static function isGuest(): bool
    {
        return !self::$app->user;
    }
}