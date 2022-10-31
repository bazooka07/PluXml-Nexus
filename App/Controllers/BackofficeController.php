<?php
/**
 * BackofficeController
 */
namespace App\Controllers;

use App\Facades\AuthFacade;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Respect\Validation\Validator;

class BackofficeController extends Controller
{

    protected const MSG_VALID_NAME = 'Must be alphanumeric with no whitespace';
    protected const MSG_VALID_TOLONG1000 = 'Invalid or to long (1000 characters max)';
    protected const MSG_VALID_TOLONG100 = 'Invalid or to long (100 characters max)';
    protected const MSG_VALID_FILE = 'Invalid zip archive file or more big than 10MB';
    protected const MSG_SUCCESS_EDITRESSOURCE = '%s saved with success';
    protected const MSG_SUCCESS_DELETERESSOURCE = '%s deleted with success';
    protected const MSG_ERROR_TECHNICAL_RESSOURCES = 'Technical error or %s name already exist';

    protected const VIEW_BO = 'pages/backoffice/backoffice.php';

    private String $view = self::VIEW_BO;
    protected String $ressourceType = '';
    protected String $dirTarget = '';
    protected Array $post = [];
    protected String $mediaName = 'icon';

    /**
     * PHP view renderer
     *
     * @param Response $response
     * @param String $filename
     * @param array $datas
     * @return Response
     */
    public function render(Response $response, $filename, $datas = [])
    {
        $datas['title'] = (!empty($this->ressourceType) ? ucfirst($this->ressourceType) . 's' : 'Backoffice') . ' Ressources - PluXml.org';
        $datas['h2'] = 'Backoffice';
        $datas['adminUser'] = AuthFacade::isAdmin($this->container, $this->currentUser);

        return parent::render($response,
            $filename,
            $datas
        );
    }

    /**
     *
     * @param Request $request
     * @param Response $response
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function show(Request $request, Response $response): Response
    {
        return $this->render($response, $this->view);
    }

    /**
     * Validate request body for a plugin save or edit
     *
     * @param Request $request
     * @param bool $newPlugin
     * @param bool $newFile
     * @return array
     * @throws Exception
     */
    protected function ressourceValidator(Request $request, bool $newRessource = false): array
    {
        $errors = [];
        $this->post = $request->getParsedBody();

        if ($newRessource) {
            Validator::notEmpty()->alnum()
                ->noWhitespace()
                ->length(1, 99)
                ->validate($this->post['name']) || $errors['name'] = self::MSG_VALID_NAME;
        }

        if (empty($errors))
        {
            $uploadedFiles = $request->getUploadedFiles();
            $uploadedFile = $uploadedFiles['file'];
            if ($newRessource || $uploadedFile->getSize() > 0) {
                // Uploaded file move, rename and validation
                if (empty($uploadedFiles['file'])) {
                    throw new Exception('No file has been send');
                }
                if (
                    $uploadedFile->getError() === UPLOAD_ERR_OK and
                    $uploadedFile->getClientMediaType() == 'application/zip' and
                    $uploadedFile->getSize() < PLUGINS_MAX_SIZE
                ) {
                    $targetDir = $this->dirTarget . DIRECTORY_SEPARATOR . str_pad($this->post['author'], 2, '0', STR_PAD_LEFT);
                    if (is_dir(PUBLIC_DIR . $targetDir) or mkdir(PUBLIC_DIR . $targetDir))
                    {
                        $this->post['file'] = $targetDir . DIRECTORY_SEPARATOR . $this->post['name'] . '.zip';
                        # tester infos.xml dans archive zip !!
                        $uploadedFile->moveTo(PUBLIC_DIR . $this->post['file']);
                        $this->processArchiveZip($targetDir);
                    } else {
                        $errors['file'] = MSG_ERROR_TECHNICAL_RESSOURCES;
                    }
                } else {
                    $errors['error'] = self::MSG_VALID_FILE;
                }
            }
        }

        if (!empty($this->post['description'])) {
            # Validator::alnum('. , - _')->length(1, 999)->validate($this->post['description']) || $errors['description'] = self::MSG_VALID_TOLONG1000;
            Validator::regex('#^[^<>?!=]{1,999}$#')->validate($this->post['description']) || $errors['description'] = self::MSG_VALID_TOLONG1000;
        }
        if (!empty($this->post['version'])) {
            Validator::regex('#^\d+\.\d+(?:\.\d+(?:[+_-]\w*)?)?$#')->length(1, 99)->validate($this->post['version']) || $errors['version'] = self::MSG_VALID_TOLONG100;
        }
        if (!empty($this->post['pluxml'])) {
            Validator::version()->length(1, 99)->validate($this->post['pluxml']) || $errors['pluxml'] = self::MSG_VALID_TOLONG100;
        }
        if (!empty($this->post['link'])) {
            Validator::url()->length(1, 99)->validate($this->post['link']) || $errors['link'] = self::MSG_VALID_URL;
        }

        if (!empty($errors))
        {
            foreach(array('file', 'media',) as $fld)
            {
                if (!empty($this->post[$fld]))
                {
                    $filename = PUBLIC_DIR . $this->post[$fld];
                    if (file_exists($filename))
                    {
                        unlink($filename);
                    }
                }
            }
        }
        return $errors;
    }

    protected function processArchiveZip($targetDir)
    {
        $zipName = PUBLIC_DIR . $this->post['file'];
        $zip = new \ZipArchive();
        if ($zip->open($zipName))
        {
            $infosDone = false;
            $mediaDone = false;
            for($i=0; $i<$zip->numFiles; $i++)
            {
                $entry = $zip->getNameIndex($i);
                if(preg_match('#^/?[^/]+/infos.xml$#', $entry))
                {
                    $infos = $zip->getFromIndex($i);
                    $xml = new \SimpleXMLElement($infos);
                    if (!empty($xml->description))
                    {
                        $this->post['description'] = $xml->description->__toString();
                    }
                    if (!empty($xml->version))
                    {
                        $this->post['version'] = $xml->version->__toString();
                    }
                    if (!empty($xml->site))
                    {
                        $this->post['link'] = $xml->site->__toString();
                    }
                    if (!empty($xml->date))
                    {
                        $this->post['date'] = $xml->date->__toString();
                    }
                    $infosDone = true;
                } elseif (preg_match('#^/?[^/]+/' . $this->mediaName. '(\.(?:jpe?g|png|gif|bmp|webp))$#', $entry, $matches)) {
                    $this->post['media'] = $targetDir . DIRECTORY_SEPARATOR . $this->post['name'] . $matches[1];
                    # $zip->extractTo(PUBLIC_DIR . $targetDir, $entry);
                    copy('zip://' . $zipName . '#' . $entry, PUBLIC_DIR . $this->post['media']);
                    $mediaDone = true;
                }

                if ($infosDone and $mediaDone)
                {
                    break;
                }
            }
        }
    }
}
