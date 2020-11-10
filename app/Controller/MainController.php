<?php

namespace BeeJee\Controller;

use BeeJee\Model\Task;

class MainController extends Controller
{
    private $taskModel;

    public function __construct($container) {
        $this->taskModel = new Task($container);
        parent::__construct($container);
    }

    public function taskList($curPage, $orderBy, $sort) {
        $pageCount = $this->taskModel->pageCount();
        if (!in_array($orderBy, ['username', 'email', 'state']))
            $orderBy = 'username';
        $tasks = $this->taskModel->get($curPage, $orderBy, $sort);
        echo $this->renderer->render('tasklist.twig', ['tasks' => $tasks, 'maxPage' => $pageCount, 'curPage' => $curPage, 'orderBy' => $orderBy, 'sort' => $sort, 'user' => $this->user]);
    }

    public function logout() {
        unset($_SESSION['user']);
    }

    public function login() {
        $success = false;
        $errors = [];
        // best authorization process ever released
        if (isset($_POST['login']) && isset($_POST['password']) && $_POST['login'] == 'admin' && $_POST['password'] == '123'){
            $success = true;
            $_SESSION['user'] = true;
        }
        else{
            $errors[] = 'Credentials are incorrect';
        }
        echo json_encode(['success' => $success, 'errors' => $errors]);
    }

    public function index() {
        echo $this->renderer->render('index.twig', ['user' => $this->user]);
    }

    public function complete ($id){
        if ($this->user)
            $this->taskModel->complete($id);
        echo json_encode(['success' => true]);
    }

    public function edit($id = 0) {
        $success = true;
        $errors = [];
        $username = $_POST['username'];
        $email = $_POST['email'];
        $description = $_POST['description'];
        if ($id == 0){
            if ((!$username || !$email || !$description)){
                $success = false;
                $errors[] = 'All fields must be filled';            
            }
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
                $success = false;
                $errors[] = 'E-Mail address is not valid';
            }
        }
        if ($success){
            if ($id == 0)
                $this->taskModel->add(['username' => $username, 'email' => $email, 'description' => $description]);
            else
                $this->taskModel->edit($id, ['description' => $description]);
        }
        echo json_encode(['success' => $success, 'errors' => $errors]);
    }
}