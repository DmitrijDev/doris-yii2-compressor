# Установка и настройка
<code>composer require doris/yii2-compressor:@dev</code>

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

# Работа с сайта

Пример использования:<br>
<pre>
use doris\compressor\CompressorApi;

try {
$compressor = new CompressorApi();
$compressor->setPathToImage('/images/test.png')
	->setPathToSave('/uploads/products')
	->setAlias('@web')
	->setCustomName('mockup')

$imagePath = $compressor->compress(77);

catch (Exception $e) {
    $message = $e->getMessage();
}
</pre>

Класс CompressorFacade имеет ряд сеттеров (реализован паттерн текучего интерфейса):
<ul>
	<li>setPathToImage - путь к картинке относительно заданого псевдонима. Обязательно.</li>
	<li>setPathToSave - путь к дериктории для сохранения изображения относительно заданого псевдонима. Если не задан - картинка будет перезаписана. Опционально.</li>
	<li>setAlias - задает псевдоним пути. По умолчанию '@webroot'. Опционально.</li>
	<li>setCustomName - устанавливает новое имя для сжатой картинки. Опционально.</li>
</ul>

И несколько методов:
<ul>
	<li>compress - возвращает валидный путь для подключения картинки на сайте. Принимает параметр указывающий степень сжатия (от 0 до 100). По умолчанию 85.</li>
	<li>deleteOriginal - удаляет оригинал картинки. Возвращает результат удаления как true или false.</li>
</ul>

Каждая ошибка (к примеру если по указаному пути картинка не была найдена) генерирует exception по-этому рекомендуется использовать конструкцию try catch дя его обработки.

# Работа с консоли

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