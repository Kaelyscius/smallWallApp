<?php

namespace App\Controller;

use \App;
use \Core\HTML\BootstrapForm;

class SmallWallAppController extends AppController
{
    public function __construct()
    {
        parent::__construct();
        $this->loadModel('Message');
        $this->loadModel('Category');
        $this->loadModel('MessageCategory');

    }

    public function index()
    {
        $_SESSION["formid"] = md5(rand(0, 10000000));
        $messages           = $this->Message->getAllMessageOrderDesc();
        $messagescategories = $this->MessageCategory->getCategoriesByMessages();
        $categories         = $this->Category->extract('id_category', 'title');
        $errors             = $this->errors;
        $form               = new BootstrapForm();
        $this->render('smallwallapp.index', compact('form', 'categories', 'messages', 'messagescategories', 'errors'));

    }

    public function add()
    {
        if (!empty($_POST)) {
            // var_dump($_POST);
            // die;
            if (isset($_POST["submit"])) {
                if ($_POST["formid"] == $_SESSION["formid"]) {
                    $_SESSION["formid"] = '';
                    $validator          = $this->validator($_POST);
                    if (count($validator) === 0) {
                        $message = $this->Message->create([
                            'username' => $_POST['username'],
                            'message'  => $_POST['message'],
                            'date'     => date("Y-m-d H:i:s"),
                        ]);
                        $lastIdMessage = App::getInstance()->getDb()->lastInsertId();

                        foreach ($_POST['title'] as $id_category) {
                            $messagescategories = $this->MessageCategory->create([
                                'id_message'  => $lastIdMessage,
                                'id_category' => $id_category,
                            ]);
                        }

                    }
                }
                return $this->index();
            }
        }
    }

    private function validator($fields)
    {
        if (!isset($fields['title'])) {
            $fields['title'] = array();
        }
        if (isset($fields['username']) && $fields['username'] == '') {
            $this->errors[] = 'Vous n\'avez pas saisi de pseudo';
        }
        if (isset($fields['message']) && $fields['message'] == '') {
            $this->errors[] = 'Vous n\'avez pas saisi de message';
        }
        if (count($fields['title']) === 0) {
            $this->errors[] = 'Vous devez choisir au moins une catégorie';
        }

        return $this->errors;
    }

}
