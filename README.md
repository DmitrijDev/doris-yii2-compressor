# Doris image compressor

Установка с composer: <br>
<code>composer require doris/yii2-compressor:@dev</code>

Пример использования:<br>
<pre>
use doris\compressor\CompressorFacade;

$compressor = new CompressorFacade();
$compressor->setPathToImage('/images/test.png')
	->setPathToSave('/uploads/products')
	->setAlias('@web')
	->setCustomName('mockup')
	->setCompressRatio(85)
	->deleteOriginal(true);

if($compressor->compress()) {
	$imagePath = $compressor->getCompressedImagePath()
} else {
	throw new Exception($compressor->getErrorMessage());
}
</pre>

Класс CompressorFacade имеет ряд сеттеров (реализован паттерн текучего интерфейса):
<ul>
	<li>setPathToImage - путь к картинке относительно заданого псевдонима. Обязательно.</li>
	<li>setPathToSave - путь к дериктории для сохранения изображения относительно заданого псевдонима. Если не задан - картинка будет перезаписана. Опционально.</li>
	<li>setAlias - задает псевдоним пути. По умолчанию '@webroot'. Опционально.</li>
	<li>setCustomName - устанавливает новое имя для сжатой картинки. Опционально.</li>
	<li>setCompressRatio - устанавливает степень сжатия картинки. По умолчанию 85. Опционально.</li>
	<li>deleteOriginal - удаляет оригинал картинки после сжатия. По умолчанию false. Опционально.</li>
</ul>

Несколько геттеров (имеют смысл только после сжатия картинки):
<ul>
	<li>getCompressedImagePath - отдаёт путь к картинке без псевдонима, можно сразу выгружать на сайт.</li>
	<li>getErrorMessage - отдаёт сообщение с ошибкой, если такая возникла.</li>
</ul>

И метод для сжатия картинки
<ul>
	<li>compress - возвращает результат сжатия как boolean.</li>
</ul>

Для установки ключа и домена в <code>common/config/params</code> необходимо положить следующие настройки:<br>
<pre>
'ImageCompressor' => [
      'key' => "Ключ для текущего сайта",
      'domain' => "Домен на который будет отправлятся запрос"
]
</pre>
Параметры:
<ul>
<li>$key - Ключ который генерируется на сайте и привязан к определенному проекту.</li>
<li>$domain - Домен с протоколом, к примеру http://test.com.ua</li>
</ul>

Если есть желание использовать библиотеку с консоли стоит зарегистрировать модуль в <code>console/config/main</code>
<pre>
'modules' => [
	'compressor' => 'doris\compressor\modules\console\Handler',
],
</pre>

Команда для сжатия картинок через консоль:
<pre>
yii compressor $path $recursive
</pre>

Параметры:
<ul>
<li>$path - Путь к изображением начиная с web. К примеру <code>\images</code>. Обязательно.</li>
<li>$recursive - Флаг который указывает нужно ли перебирать дочерние дериктории. 
Если true - будет перебирать все вложенные дериктории. По умолчанию true. Опционально.</li>
</ul>