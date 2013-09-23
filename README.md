#هيكلية بناء التطبيقات : تطبيقي‎

## الإضافات


أخذنا في عين الاعتبار دعم اللغة العربية، ودعم الواجهة من اليمين لليسار. وقد قمنا بتقليص الحجم اكبر قدر ممكن، مع الاحتفاظ بالامكانيات الكاملة لكل من التطبيقات المستخدمة. 

#### إطار تطوير تطبيقات الشابكة ييي Yii Framework 
* حذف الملفات الغير مستخدمة، مثل ملفات الترجمة واللغات الاخرى.
* مراجعة ترجمة النصوص العربية. 
* اضافة ملف الاعدادات المحلية، لتمكين المطور من عمل ضبط محلي من دون مس الضبط العام.


#### محرك البحث "المتوسع" (إلاستيك Elastic Search)
* حيث يعتر داعم قوي للفهرسة والبحث في اللغة العربية، وهو جاهز للاستخدام من دون اي اعدادات معقدة
* بناء سطر اوامر لعملية الفهرسة، حيث يقوم بفهرسة النموذج (Model) حسب الاعدادات، يمكنك الاطلاع على مثال الاعدادات من داخل الملف appii/protected/config/Page_mapping.php


#### نظام التخزين المؤقت "ريديس"

#### واجهة المستخدم المعتمدة على بوت ستراب من تويتر
اعتدمنا الملفات المولدة من مكتبة المطور مؤيد السعدي https://github.com/muayyad-alsadi/bootstrap-rtl








## New Feature
Cache with Redis

Bootstrap Theme

WYSIWYG widget - Redactore

Add Font: Uthman Taha and Uthman Taha Bold

Remove unsed files - like language

Translate text

Add bootstrap

Integrate with elastic search


## Yii structured app
appii <br/>
└──	protected <br/>
│	├──controller   <br/>
│	├──components  <br/>
│	├──config <br/>
│	│	├──main.php <br/>
│	│	├──local.php <br/>
│	├──data <br/>
│	├──extension <br/>
│	│	├──YiiBoosterRtl <br/>
│	│	├──imperavi-redactor-widget <br/>
│	│	├──mailer <br/>
│	│	├──redis <br/>
│	├──models <br/>
│	├──runtime <br/>
│	├──tests <br/>
│	├──view <br/>
│	│	├──. <br/>
│	│	├──. <br/>
│	│	├──etc <br/>
└──public_web <br/>

	

## Requirment 
## Redis  <br/>
yum install php-redis<br/>

Elastic <br/>
wget https://download.elasticsearch.org/elasticsearch/elasticsearch/elasticsearch-0.90.0.noarch.rpm <br/>
sudo yum install elasticsearch-0.90.0.noarch.rpm <br/>
service elasticsearch start <br/>


## Create Index (Elastic)
go to appii/protected <br/>
./cmdrun elastic create <br/>
./cmdrun elastic map --type=MODEL_NAME <br/>
./cmdrun elastic import --type=MODEL_NAME <br/>
./cmdrun elastic  search --term=SEARCH --type=MODEL_NAME


## Done with APPII
<a href=http://ameen.ojuba.org/>http://ameen.ojuba.org</a>
