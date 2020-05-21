<?php

namespace App\Controllers\Admin;

use \Core\View;
use \App\Models\FacebookComment as FacebookCommentModel;
use \App\Request;
use \App\Flash;

class Comment extends Authenticated
{

    public function indexAction()
    {
        $records = FacebookCommentModel::getAll();
        View::renderTemplate('/admin/facebook-comment/index.html',[
            'records' => $records
        ]);
    }

    public function addAction()
    {
        View::renderTemplate('/admin/facebook-comment/add.html');
    }

    public function editAction()
    {
        $id = $this->route_params['id'] ?? null;
        if(isset($id)){
            
            $record = new FacebookCommentModel(); 
            $record = $record->getOne($id);
            
            View::renderTemplate('/admin/facebook-comment/edit.html',[
                'record' => $record
            ]);
        }else{
            throw new \Exception("Id is not specified",404);
        }
    }

    public function saveAction()
    {
        if(Request::isPost()){
            
            
            $record = new FacebookCommentModel($_POST); 
            
            if($record->save()){
                Flash::addMessage("Комментарий добавлен",Flash::SUCCESS);
                $this->redirect("/admin/comment/index");
            }else{

                foreach($record->errors as $value){
                    Flash::addMessage($value,Flash::DANGER);
                }
                View::renderTemplate('/admin/facebook-comment/add.html',[
                    'post' => $_POST
                ]);
                
            } 
        }
    }
    public function saveChangesAction()
    {
        if(Request::isPost()){
            
            $id = $this->route_params['id'] ?? null;
            if(isset($id)){
                $record = new FacebookCommentModel($_POST); 
                
                if($record->saveChanges($id)){
                    Flash::addMessage("Изменения сохранены",Flash::SUCCESS);
                    $this->redirect("/admin/comment/index");
                }else{

                    foreach($record->errors as $value){
                        Flash::addMessage($value,Flash::DANGER);
                    }
                    $record->id = $id;
                    View::renderTemplate('/admin/facebook-comment/edit.html',[
                        'post' => $_POST,
                        'record' => $record
                    ]);
                }
            } else{
                throw new \Exception("Id is not specified",404);
            }
            
        }
    }
    public function deleteAction()
    {
        $id = $this->route_params['id'] ?? null;
        if(isset($id)){
            
            $record = new FacebookCommentModel(); 
            if($record->delete($id)){
                Flash::addMessage("Комментарий удален",Flash::SUCCESS);
                $this->redirect("/admin/comment/index");
            }else{
                Flash::addMessage("Возникла ошибка удаления записи. Обратитесь к разработчику",Flash::DANGER);
                $this->redirect("/admin/comment/index");
            }
        }else{
            throw new \Exception("Id is not specified",404);
        }
    }

}