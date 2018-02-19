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
<ul>
<li>$image - путь к картинке, не абсолютный ('\images\test.jpg'). <strong>Важно!</strong> 
Передавать нужно не ссылку на картинку, а путь через обратный слеш. Обязательно. </li>
<li>$path - путь куда положить картинку ('uploads/images'). Опционально. </li>
<li>$condition - степень сжатия. 0 - сжимать полностью, 100 - не сжимать. По умолчанию 85. Опционально. </li>
</ul>

Возвращает валидный путь для подключения на сайте.

Пути работают относительно алиаса @webroot. Поменять алиас можно с так: <br>
<pre>
$conf = PathHelper::getInstance();
$conf->setAlias('@webroot');
</pre>
Менять нужно перед инициализацей компрессора!!!

В <code>common/config/params</code> необходимо положить следующие настройки:<br>
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
	'compressor' => 'doris\compressor\console\Console',
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