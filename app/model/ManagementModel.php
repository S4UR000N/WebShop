<?php
// namespace
namespace app\model;
class ManagementModel extends UserModel
{
    public function management(\app\controller\UserController $parentObject)
    {
        //on GET request execute if | on POST request excecute else
        // Regular Render Branch
        if (!\app\extra\Request::requestMethod()) {
            $fileRepo = new \app\repository\FileRepository();
            $parentObject->viewData['viewFiles'] = $fileRepo->selectUserFilesUnionOtherFiles();
            $parentObject->render_view("in:management", $parentObject->viewData);
        }
        else
        {
            /* Get Superglobals */
            $post = new \app\super\Post();
            $files = new \app\super\Files();
            $post = $post->getPost();
            $files = $files->getFiles();
            // Upload File Branch
            if (!empty($files)) {
                $fileRepo = new \app\repository\FileRepository();
                $invalid = $fileRepo->validateFile($parentObject->viewData);
                // if true then Upload and Save file or Return fail
                if (!$invalid) {
                    // Target dir/file/extension
                    $target_dir = "uploads/" . $this->getUserId();
                    $target_file = $target_dir . $files['img_up']['name'];
                    // Store File
                    if (move_uploaded_file($files['img_up']['tmp_name'], $target_file)) {
                        $file = new \app\model\FileModel();
                        $file->setUserId($this->getUserId());
                        $file->setFileName($files['img_up']['name']);
                        $parentObject->viewData['uploaded'] = $fileRepo->saveFile($file);
                        $parentObject->viewData['viewFiles'] = $fileRepo->selectUserFilesUnionOtherFiles();
                        $parentObject->render_view("in:management", $parentObject->viewData);
                    } else {
                        // Return View With Fail Message
                        array_push($parentObject->viewData, "File Upload Failed!");
                        $parentObject->viewData['viewFiles'] = $fileRepo->selectUserFilesUnionOtherFiles();
                        $parentObject->render_view("in:management", $parentObject->viewData);
                    }
                } // else Send Error Data to View
                else {
                    $parentObject->viewData['invalid'] = $invalid;
                    $parentObject->viewData['viewFiles'] = $fileRepo->selectUserFilesUnionOtherFiles();
                    $parentObject->render_view("in:management", $parentObject->viewData);
                }
            } // Delete File Branch
            else if (array_key_exists('file_id', $post)) {
                $parentObject->viewData['deleted'] = false;
                $fileRepo = new \app\repository\FileRepository();
                $isDeleted = $fileRepo->deleteFile($post['user_id'], $post['file_id']);
                if ($isDeleted) {
                    $unlink = unlink("uploads/" . $this->getUserId() . $post['file_name']);
                }
                if ($isDeleted > 0 && $unlink) {
                    $parentObject->viewData['deleted'] = true;
                }
                $parentObject->viewData['viewFiles'] = $fileRepo->selectUserFilesUnionOtherFiles();
                $parentObject->render_view("in:management", $parentObject->viewData);
            }
        }
    }
}