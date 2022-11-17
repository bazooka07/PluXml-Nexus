<?php
/**
 * Facade
 */
namespace App\Facades;

use Psr\Container\ContainerInterface;
use App\Models\UserModel;
use Psr\Http\Message\UploadedFileInterface;

class Facade
{

    static public function getAuthorUsernameById(ContainerInterface $container, Int $id)
    {
        $userModel = new UserModel($container, $id);
        return !empty($userModel->id) ? $userModel->username : null;
    }

    /**
     * Moves the uploaded file to the upload directory and assigns it a unique name
     * to avoid overwriting an existing uploaded file.
     *
     * From SLIM 4 documentation
     * https://www.slimframework.com/docs/v4/cookbook/uploading-files.html
     *
     * @param string $directory
     *            directory to which the file is moved
     * @param UploadedFileInterface $uploaded
     *            file uploaded file to move
     * @return string filename of moved file
     */
    static public function moveUploadedFile(String $directory, UploadedFileInterface $uploadedFile)
    {
        $extension = pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION);
        $basename = bin2hex(random_bytes(8)); // see http://php.net/manual/en/function.random-bytes.php
        $filename = sprintf('%s.%0.8s', $basename, $extension);

        $uploadedFile->moveTo($directory . DIRECTORY_SEPARATOR . $filename);

        return $filename;
    }
}