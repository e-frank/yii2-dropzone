<?
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

	public $config = [];

	public function run() {
		$view = $this->view;
		DropzoneAsset::register($view);
		$view->registerJs(sprintf(<<<EOD
// dropzone loader
var x1 = x1 || {}; x1.dropzone = x1.dropzone || {};
var x1.dropzone.%1\$s = new Dropzone("div#%1\$s", %2\$s);
console.log('dropzone', x1.dropzone)
EOD;
, $this->id, Json::encode($this->config, JSON_PRETTY_PRINT));

		return $this->view->render('@x1/dropzone/views/dropzone', [
			'id'        => $this->id,
			'model'     => $this->model,
			'attribute' => $this->attribute,
			'name'      => $this->name,
			'value'     => $this->value,
			'url'       => $this->url,
		]);
	}

}

?>