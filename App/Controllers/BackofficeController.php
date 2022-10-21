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

    protected const MSG_VALID_FILE = 'Invalid file (extension must be zip and size inferior to 10MB';

    protected const MSG_SUCCESS_EDITRESSOURCE = '%s saved with success';

    protected const MSG_SUCCESS_DELETERESSOURCE = '%s deleted with success';

    protected const MSG_ERROR_TECHNICAL_RESSOURCES = 'Technical error or %s name already exist';

    protected const VIEW_BO = 'pages/backoffice/backoffice.php';

    private String $view = self::VIEW_BO;

    protected String $ressourceType = '';

    protected String $dirTarget = '';

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
    protected function ressourceValidator(Request $request, bool $newRessource = false, bool $newFile = false): array
    {
        $errors = [];
        $post = $request->getParsedBody();
        $uploadedFiles = $request->getUploadedFiles();
        if (empty($uploadedFiles['file'])) {
            throw new Exception('No file has been send');
        }

        if (!empty($post['description'])) {
            Validator::alnum('. , - _')->length(1, 999)->validate($post['description']) || $errors['description'] = self::MSG_VALID_TOLONG1000;
        }
        if (!empty($post['versionRessource'])) {
            Validator::alnum('. , - _')->length(1, 99)->validate($post['versionRessource']) || $errors['versionRessource'] = self::MSG_VALID_TOLONG100;
        }
        if (!empty($post['versionPluxml'])) {
            Validator::alnum('.')->length(1, 99)->validate($post['versionPluxml']) || $errors['versionPluxml'] = self::MSG_VALID_TOLONG100;
        }
        if (!empty($post['link'])) {
            Validator::url()->length(1, 99)->validate($post['link']) || $errors['link'] = self::MSG_VALID_URL;
        }

        if ($newRessource) {
            Validator::notEmpty()->alnum()
                ->noWhitespace()
                ->length(1, 99)
                ->validate($post['name']) || $errors['name'] = self::MSG_VALID_NAME;
        }

        if ($newRessource || $newFile) {
            // Uploaded file move, rename and validation
            $uploadedFile = $uploadedFiles['file'];
            if ($uploadedFile->getError() === UPLOAD_ERR_OK) {
                $filename = $post['name'] . '.zip';
                $dirTmp = PUBLIC_DIR . DIR_TMP;
                $uploadedFile->moveTo($dirTmp . DIRECTORY_SEPARATOR . $filename);
                Validator::notEmpty()->extension('zip')
                    ->size(NULL, PLUGINS_MAX_SIZE)
                    ->validate($dirTmp . DIRECTORY_SEPARATOR . $filename) || $errors['file'] = self::MSG_VALID_FILE;
            } else {
                $errors['error'] = self::MSG_ERROR_TECHNICAL_PLUGINS;
            }
        }

        return $errors;
    }
}
