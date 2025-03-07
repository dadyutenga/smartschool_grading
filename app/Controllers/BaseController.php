<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use App\Libraries\AuthLibrary;
use App\Models\SessionModel;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    protected $helpers = ['form', 'url'];

    /**
     * Session instance
     */
    protected $session;

    /**
     * Auth library instance
     */
    protected $auth;

    protected $currentSession;

    /**
     * @return void
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.
        $this->session = \Config\Services::session();
        $this->auth = new \App\Libraries\AuthLibrary();
        
        // Get current session
        $sessionModel = new SessionModel();
        $this->currentSession = $sessionModel->getCurrentSession();
    }

    // Check if user is logged in
    protected function requireLogin()
    {
        if (!$this->auth->isLoggedIn()) {
            return redirect()->to('/auth/login');
        }
    }
    
    // Check if user has specific role
    protected function requireRole($roles)
    {
        $this->requireLogin();
        
        $userRole = $this->auth->getRole();
        $roles = is_array($roles) ? $roles : [$roles];
        
        if (!in_array($userRole, $roles)) {
            return redirect()->to('/dashboard')->with('error', 'You do not have permission to access this page');
        }
    }
}
