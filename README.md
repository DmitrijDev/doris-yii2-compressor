# Doris image compressor

Установка с composer: <br>
<code>composer require doris/yii2-compressor:@dev</code>

@dev ибо библиотека находится в доработке и ее даже альфой назвать пока нельзя. Однако она
уже вполне работоспасобна.

Использование:<br>
<pre>use doris\compressor\Compressor;
	
$comp = new Compressor();
$image_path = $comp->compress($image, $path, $condition);
</pre>

Параметры:<br>
$image - путь к картинке, не абсолютный ('/images/test.jpg'). Обязательно <br>
$path - путь куда положить картинку ('uploads/images'). Опционально <br>
$condition - степень сжатия. 0 - сжимать полностью, 100 - не сжимать. По умолчанию 85. Опционально

Возвращает валидный путь для подключения на сайте.

Пути работают относительно алиаса @webroot. Поменять алиас можно с так: <br>
<pre>
	$conf = PathHelper::getInstance();
	$conf->setAlias('@webroot');
</pre>
Менять нужно перед инициализацей компрессора!!!

В params необходимо положить следующие настройки:<br>
<pre>
'ImageCompressor' => [
      'key' => "Ключ для текущего сайта",
      'domain' => "Домен на который будет отправлятся запрос"
]
</pre>