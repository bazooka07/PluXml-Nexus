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

    protected const MSG_VALID_NAME = _['MSG_VALID_NAME'];
    protected const MSG_VALID_TOLONG1000 = _['MSG_VALID_TOLONG1000'];
    protected const MSG_VALID_TOLONG100 = _['MSG_VALID_TOLONG100'];
    protected const MSG_VALID_FILE = _['MSG_VALID_FILE'];
    protected const MSG_SUCCESS_EDITRESSOURCE = _['MSG_SUCCESS_EDITRESSOURCE'];
    protected const MSG_SUCCESS_DELETERESSOURCE = _['MSG_SUCCESS_DELETERESSOURCE'];
    protected const MSG_ERROR_TECHNICAL_RESSOURCES = _['MSG_ERROR_TECHNICAL_RESSOURCES'];
    protected const MSG_ERROR_INFOS_MISSING_IN_ZIP = 'infos.xml file is missing in Zip archive';
    protected const VIEW_BO = 'pages/backoffice/backoffice.php';
    protected const RESSOURCE = '';

    private String $view = self::VIEW_BO;
    protected String $title = _['BACKOFFICE'];
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
        $datas['title'] = (!empty($this->ressourceType) ? ucfirst(_[strtoupper($this->ressourceType . 's')]) : _['BACKOFFICE']) . ' - Ressources.pluXml.org';
        $datas['h2'] = _['BACKOFFICE'];
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
     * Parse and save the Zip archive file.
     * @param Request $request
     * @param bool $newPlugin
     * @param bool $newFile
     * @return array of errors
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
                        $uploadedFile->moveTo(PUBLIC_DIR . $this->post['file']);
                        # tester infos.xml dans archive zip !!
                        if (!$this->processArchiveZip($targetDir)) {
                            $errors['file'] = MSG_ERROR_INFOS_MISSING_IN_ZIP;
                        }
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
        $infosDone = false;
        $mediaDone = false;

        $zipName = PUBLIC_DIR . $this->post['file'];
        $zip = new \ZipArchive();
        if ($zip->open($zipName))
        {
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

        return $infosDone;
    }
}
