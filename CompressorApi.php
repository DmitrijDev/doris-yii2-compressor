<?php
namespace doris\compressor;

use Exception;
use doris\compressor\Services\FileService;
use doris\compressor\Services\RequestService;

/**
 * Class Facade
 *
 * @param FileService $fileService
 * @param RequestService $requestService
 */
class CompressorApi
{
    protected $fileService;
    protected $requestService;

    public final function __construct()
    {
        $this->fileService = new FileService();
        $this->requestService = new RequestService();
    }

    public function compress(int $compressRatio = 85): string
    {
        list($imageExt, $imageContent) = $this->fileService->getImageInfo();

        $compressedImageContent = $this->requestService->sendRequest($imageExt, $imageContent, $compressRatio);

        $compressedImagePath = $this->fileService->saveImage($compressedImageContent);
        if (!$compressedImagePath) {
            throw new Exception("Can't save image");
        };

        return $compressedImagePath;
    }

    public function setPathToImage(string $path): CompressorApi
    {
        $this->fileService->setPathToImage($path);

        return $this;
    }

    public function setPathToSave(string $path): CompressorApi
    {
        $this->fileService->setPathToSave($path);

        return $this;
    }

    public function setAlias(string $alias): CompressorApi
    {
        $this->fileService->alias = trim($alias);

        return $this;
    }

    public function setCustomName(string $name): CompressorApi
    {
        $this->fileService->customName = trim($name);

        return $this;
    }

    public function deleteOriginal(): bool
    {
        return $this->fileService->deleteOriginal();
    }
}
