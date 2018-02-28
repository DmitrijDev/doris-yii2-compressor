# Doris image compressor

Установка с composer: <br>
<code>composer require doris/yii2-compressor:@dev</code>

@dev ибо библиотека находится в доработке и ее даже альфой назвать пока нельзя. Однако она
уже вполне работоспасобна.

Использование:<br>
<pre>use doris\compressor\Compressor;
	
$config = new CompressorConfig();
$config->imagePath = '/images/test.png';
        
$pathToImage = Compressor::compress($config);
</pre>

$config - объект класса CompressorConfig. Возможно установить следующие параметры:
<ul>
	<li> imagePath: string - путь к картинке относительно алиаса ('/images/test.png). Обязательно. </li>
	<li> alias: string - установка псевдонима пути от которого будут работать остальные параметры ('@web'). Опционально. По умолчанию '@webroot'. </li>
	<li> conditionRatio: int - степень сжатия. Опционально. По умолчанию 85. </li>
	<li> pathToSave: string - путь к папке в которую будет сохранена картинка относительно алиаса ('uploads/products'). Опционально. Если задан не будет - картинка перезапишется. </li>
	<li> customName: string - присвоит созданной картинке переданое имя (к примеру 'test'). Опционально. Будет работать только если задан параметр pathToSave. </li>
	<li> deleteOriginal: bool - удалит оригинал в случае успешного сжатия. Опционально. Будет работать только если задан параметр pathToSave. По молчанию false. </li>
</ul>

Возвращает валидный путь для подключения на сайте.

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