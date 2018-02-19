<?php

namespace doris\compressor\Helpers;

use Yii;

class PathHelper
{

	private $alias = '@webroot/';
	private static $_instance = null;
	public $name; // file name
	public $dirPath; // path to directory with file
	public $filePathToGet; // full path with file to get
	public $filePathToSet; // full path with file to set
	public $returnPath; // path for site insert

	public function setAlias($alias)
	{
		self::$_instance->alias = $alias;
	}

	/**
	 * @param null $img path to image with image
	 * @param bool $path path to save image
	 * @return bool
	 */
	public function setData($img = null, $path = false)
	{
		if (!$img) {
			return false;
		}

        $tmp = explode('\\', $img);
		self::$_instance->name = end($tmp);

		if ($path) {
			self::$_instance->dirPath = Yii::getAlias(self::$_instance->alias . $path);
			self::$_instance->returnPath = $path . '/' . self::$_instance->name;

			if (!file_exists(self::$_instance->dirPath)) {
				mkdir(self::$_instance->dirPath, 0775, true);
			}
		} else {
			array_pop($tmp);
			$tmp = implode('/', $tmp);

			self::$_instance->dirPath = Yii::getAlias(self::$_instance->alias . $tmp);
			self::$_instance->returnPath = $img;
		}

		self::$_instance->filePathToGet = Yii::getAlias('@webroot') . $img;
		self::$_instance->filePathToSet = self::$_instance->dirPath . '/' . self::$_instance->name;

		echo(self::$_instance);die();

		return true;
	}

	private function __construct()
	{
	}

	protected function __clone()
	{
	}

	static public function getInstance()
	{
		if (is_null(self::$_instance)) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}
}