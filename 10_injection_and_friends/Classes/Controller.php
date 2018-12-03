<?php

class Controller
{

    const ACTIONS = [
        'index',
        'login'
    ];

    /**
     * @var string
     */
    protected $action = 'index';

    /**
     * Controller constructor.
     */
    public function __construct()
    {
        if(isset($_GET['action'])){
            $this->action = $_GET['action'];
        }

        if(!in_array($this->action, self::ACTIONS)){
            throw new Exception('Invalid action: ' . $this->action);
        }
    }

    /**
     * Executes $this->action
     */
    public function execute()
    {
        $method = $this->action;
        $this->$method();
    }

    /**
     * Initializes the fluid view
     *
     * @param string $templateName
     * @return \TYPO3Fluid\Fluid\View\ViewInterface
     */
    protected function initializeView(string $templateName) : \TYPO3Fluid\Fluid\View\ViewInterface
    {
        $templateRootPath = __DIR__ . '/../Templates/';

        $view = new \TYPO3Fluid\Fluid\View\TemplateView();
        $view->getTemplatePaths()->setLayoutPathAndFilename($templateRootPath . 'Layout.html');
        $view->getTemplatePaths()->setTemplatePathAndFilename($templateRootPath . $templateName . '.html');

        return $view;
    }

    /**
     * @param $name
     * @param $arguments
     * @return void
     */
    protected function renderView($name, $arguments = [])
    {
        $view = $this->initializeView($name);
        $view->assignMultiple($arguments);
        echo $view->render();
    }

    // ACTIONS

    /**
     * Just renders the view of the action
     *
     * @param $name
     * @param $arguments
     */
    public function __call($name, $arguments)
    {
        $this->renderView($name);
    }

    public function login()
    {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $db = new Database();
        if($db->checkLogin($username, $password)){
            $this->renderView('user', ['username' => $username]);
        } else {
            $this->renderView('index', [
                'message' => 'Could not login',
                'username' => $username
            ]);
        }
    }
}