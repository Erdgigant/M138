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

    // ACTIONS

    /**
     * Just renders the view of the action
     *
     * @param $name
     * @param $arguments
     */
    public function __call($name, $arguments)
    {
        echo $this->initializeView($this->action)->render();
    }

    public function login()
    {
        var_dump($_POST);die();
    }
}