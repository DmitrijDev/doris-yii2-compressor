# Doris image compressor

Установка с composer: <br>
<code>composer require doris/yii2-compressor:@dev</code>

@dev ибо библиотека находится в доработке и ее даже альфой назвать пока нельзя. Однако она
уже вполне работоспасобна.

Использование:<br>
<code>use doris\compressor\Compressor;</code>
	
<code>$comp = new Compressor();</code><br>
<code>$image_path = $comp->compress($image, $path, $condition);</code>

Параметры:<br>
$image - путь к картинке, не абсолютный ('/images/test.jpg'). Обязательно <br>
$path - путь куда положить картинку ('uploads/images'). Опционально <br>
$condition - степень сжатия. 0 - сжимать полностью, 100 - не сжимать. По умолчанию 85. Опционально

Возвращает валидный путь для подключения на сайте.

Пути работают относительно алиаса @webroot. Поменять алиас можно с так: <br>
<code>$comp->setAlias('@root')</code>

В params необходимо положить следующие настройки:<br>
<pre>
'ImageCompressor' => [
      'key' => $key,
      'domain' => $serve_domain
]
</pre>