<?php

namespace Controller;

use App\Services\ConvertService;
use ErrorException;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class HomeController
{
    const DIRECTORY = './data/';
    const VIEW_PATH_DIRECTORY =  __DIR__.'/../views/home.php';

    /**
     * @param Request $request
     * @return Response
     * @throws ErrorException
     */
    public function handleRequest(Request $request): Response
    {
        if($request->isMethod('GET')){
            return new Response($this->render("",""));
        }
        /**@var UploadedFile $brochureFile **/
        $brochureFile = $request->files->get('fileTrans');
        if (!$brochureFile) {
            return new Response($this->render("please select a file"));
        }
        $newFilename = 'translate.' . $brochureFile->guessExtension();
        $extension = $brochureFile->guessExtension();
        try {
            $brochureFile->move(
                self::DIRECTORY,
                $newFilename
            );
        } catch (FileException $e) {
            die($e->getMessage());
        }
        $this->creatDirectory(self::DIRECTORY);
        $convertService = new ConvertService();
        $convertService->saveWord(self::DIRECTORY.'translate.'.$extension, self::DIRECTORY.'newTranslateFile.'.$extension);
        $convertService->downloadFile(self::DIRECTORY.'newTranslateFile.'.$extension );
        $convertService->cleanDirectory(self::DIRECTORY.'/*');
        return new Response($this->render("please select a file",'success'));
    }

    /**
     * @param string $message
     * @param string $error
     * @return false|string
     */
    public function render( string $message, string $error="error")
    {
        ob_start();
        compact('error','message');
        include self::VIEW_PATH_DIRECTORY;
        return ob_get_clean();

    }
    private function creatDirectory(string $directoryName):void
    {
        if(!\is_dir($directoryName)){
            \mkdir($directoryName);
        }
    }
}