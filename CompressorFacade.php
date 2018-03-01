<?php
namespace doris\compressor;

use doris\compressor\services\FileService;
use doris\compressor\services\RequestService;

/**
 * Class Facade
 *
 * @param FileService $fileService
 * @param RequestService $requestService
 */
class CompressorFacade
{
    protected $fileService;
    protected $requestService;

    private $errorMessage;

    public final function __construct()
    {
        $this->fileService = new FileService();
        $this->requestService = new RequestService();
    }

    public function compress(): bool
    {
        $imageExt = $this->fileService->getImageExt();
        $imageContent = $this->fileService->getImageContent();

        if ($this->requestService->sendRequest($imageExt, $imageContent)) {

            if ($this->fileService->saveImage($this->requestService->getResponse())) {
                return true;
            };

            $this->errorMessage = 'Can\t save the image';
            return false;
        };

        $this->errorMessage = $this->requestService->getResponse();
        return false;
    }

    public function setPathToImage(string $path): CompressorFacade
    {
        $this->fileService->imagePath = trim(str_replace('/', '\\', $path));

        return $this;
    }

    public function setPathToSave(string $path): CompressorFacade
    {
        $this->fileService->pathToSave = trim(str_replace('/', '\\', $path));

        return $this;
    }

    public function setAlias(string $alias): CompressorFacade
    {
        $this->fileService->alias = trim($alias);

        return $this;
    }

    public function setCustomName(string $name): CompressorFacade
    {
        $this->fileService->customName = trim($name);

        return $this;
    }

    public function deleteOriginal(bool $flag): CompressorFacade
    {
        $this->fileService->deleteOriginal = $flag;

        return $this;
    }

    public function setCompressRatio(int $ratio): CompressorFacade
    {
        $this->requestService->conditionRatio = $ratio;

        return $this;
    }

    public function getCompressedImagePath(): string
    {
        return $this->fileService->getCompressedImagePath();
    }

    public function getErrorMessage()
    {
        return $this->errorMessage;
    }
}
