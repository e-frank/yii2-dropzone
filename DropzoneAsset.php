<?php
namespace x1\dropzone;

class DropzoneAsset extends \yii\web\AssetBundle
{
	public $sourcePath = '@x1/dropzone/assets';
	
	public $js         = [
		'min/dropzone.min.js',
	];

	public $css         = [
		// 'min/dropzone.min.css',
		'dropzone.css',
		'basic.css',
	];

}
?>