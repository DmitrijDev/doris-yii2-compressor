<?php

namespace doris\compressor;

use Yii;
use yii\base\Component;

use doris\compressor\Helpers\PathHelper;
use doris\compressor\Helpers\ConfigHelper;
use doris\compressor\Services\RequestService;

class Compressor extends Component
{

	/**
	 * @param string $img path to image with image
	 * @param string $path path to save image
	 * @param int $condition condition of image compress, from 0 to 100
	 * @return mixed path to put image on page
	 * @throws \Exception
	 */
	public function compress($img = null, $path = null, $condition = null)
	{
		$pathHelper = PathHelper::getInstance();

		if(!$pathHelper->setData($img, $path)){
			throw new \Exception("Image param can't be empty.");
		};

		$config = ConfigHelper::getParams($condition);

		if ($path) {
			if (file_exists($pathHelper->filePathToSet)) {
				return $pathHelper->returnPath;
			}
		}

		$request = new RequestService();
		$image = $request->getCompressed($config);

		if (!$image) {
			return $img;
		}

		file_put_contents($pathHelper->filePathToSet, $image);

		return $pathHelper->returnPath;
	}

}