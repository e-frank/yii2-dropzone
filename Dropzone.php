<?php
namespace x1\dropzone;

use Yii;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;
use yii\web\JsExpression;
use yii\web\View;
use yii\helpers\Url;


class Dropzone extends \yii\widgets\InputWidget {

	public static $autoIdPrefix = 'x1Dropzone';

	private $defaults = [
		'autoProcessQueue'   => true,
		// 'thumbnailWidth'  => 80,
		// 'thumbnailHeight' => 80,
		// 'parallelUploads' => 20,
		'dictDefaultMessage' => '',
		'params'             => ['foo' => 'bar'],
	];

	public $config   = [];
	public $url      = null;
	public $isBody   = false;
	public $multiple = true;

	public function init() {

		$this->config = ArrayHelper::merge($this->defaults, $this->config);

		if ($this->url == null && !isset($this->config['url'])) {
			throw new \yii\base\InvalidConfigException("'url' must be set for dropzone");
		}

		if (!isset($config['url'])) {
			$this->config['url'] = $this->url;
		}

		$this->config = ArrayHelper::merge($this->config, ['params' => [
			Yii::$app->request->csrfParam => Yii::$app->request->csrfToken
		]]);

	}

	public function run() {
		$view = $this->view;
		DropzoneAsset::register($view);

		$element  = ($this->isBody) ? 'document.body' : '#' . $this->id;
		$config   = Json::encode(((object) $this->config), JSON_PRETTY_PRINT);
		$js       = <<<EOD
if (typeof x1 === 'undefined') { var x1 = {}; }
x1 = $.extend({}, x1, { dropzone: {}});

Dropzone.autoDiscover = false;

// x1 jquery dropzone loader
(function( $ ) {
 
    $.fn.dropzone = function( options ) {
 
        options = $.extend({
            config: {}
        }, options);

		options.config = $.extend({
            previewsContainer: "#" + options.id + " .previews"
		}, options.config);

 
        this.each(function(index, item) {

			x1.dropzone[options.id] = new Dropzone(item, options.config);
			var myDropzone          = x1.dropzone[options.id];

			myDropzone.on("totaluploadprogress", function(progress) {
				document.querySelector("#" + options.id + " .progress").style.opacity = "1";
				// document.querySelector("#" + options.id + " .progress-bar").style.width = progress + "%%";
			});

			myDropzone.on("sending", function(file) {
				document.querySelector("#" + options.id + " .progress").style.opacity = "1";
				if (options.multiple === true) {
					myDropzone.removeAllFiles();
				}
				// // And disable the start button
				// file.previewElement.querySelector(".start").setAttribute("disabled", "disabled");
			});

			myDropzone.on("queuecomplete", function() {
				document.querySelector("#" + options.id + " .progress").style.opacity = "0";
			});

        });
 
        return this; 
    };
 
}( jQuery ));


(function(name) {

	// // myDropzone.on("addedfile", function(file) {
	// //   // Hookup the start button
	// //   file.previewElement.querySelector(".start").onclick = function() { myDropzone.enqueueFile(file); };
	// // });


	// // // Setup the buttons for all transfers
	// // // The "add files" button doesn't need to be setup because the config
	// // // `clickable` has already been specified.
	// // document.querySelector("#actions .start").onclick = function() {
	// //   myDropzone.enqueueFiles(myDropzone.getFilesWithStatus(Dropzone.ADDED));
	// // };
	// // document.querySelector("#actions .cancel").onclick = function() {
	// //   myDropzone.removeAllFiles(true);
	// // };


})("idOfDropzone")

EOD;


	
		$view->registerJs($js, $view::POS_READY);
		$view->registerJs(sprintf("$('%s').dropzone(%s);", ($this->isBody) ? 'document.body' : '#' . $this->id, Json::encode([
			'id'       => $this->id,
			'multiple' => $this->multiple,
			'config'   => (object)$this->config,
		])), $view::POS_READY);


		return $this->view->render('@x1/dropzone/views/dropzone', [
			'id'        => $this->id,
			'model'     => $this->model,
			'attribute' => $this->attribute,
			'name'      => $this->name,
			'value'     => $this->value,
			'config'    => $this->config,
		]);

	}

}

?>