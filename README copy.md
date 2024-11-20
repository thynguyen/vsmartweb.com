<p align="center">
  <img src="https://i.imgur.com/wC58sUI.png" alt="V-Smart Web CMS"/>
</p>

## Cài đặt
Truy cập SSH thực hiện câu lệnh:
```
composer update
```
CHMOD thư mục storage thành
```
777
```
tiếp tực thực hiện lệnh:
```
php artisan storage:link
```
Nếu không sử dụng trình cài đặt ta sử dụng thêm câu lệnh như sau:
tiếp tực thực hiện lệnh:
```
php artisan key:generate
```
tiếp tực thực hiện lệnh:
```
php artisan migrate
```

```php
app()::VERSION //gọi số phiên bản Laravel
```

## Tạo Module mới:
```
php artisan module:make Blog
```
Gọi ra file Blade trong Controllers
<p>
<strong>type</strong> mặc định là "web", có thể chọn giữa "web" và "admin"
</p>
<p>
<strong>data</strong> là một mảng, mặc định là "[]"
</p>

```php
return FileViewTheme('Module Name','blade name','data','type');
```
Đối với file Blade của Widget
```php
return FileViewWidget('module name','blade name','data');
```
Gọi ngôn ngữ trong Module
<p>
  <ul>
    <li>
      <strong>module_name</strong> là tên module viết thường.
    </li>
    <li>
      <strong>lang_file</strong> là tên của file ngôn ngữ.
    </li>
    <li>
      <strong>key</strong> là tên của khoá của ngôn ngữ cần gọi.
    </li>
  </ul>
</p>

```php
trans('module_name::lang_file.key',$array);
or
transmod('module_name::key',$array);
```

### Select Ngôn ngữ
```php
@if(count(LanguageFunc::GetAllLang())>=2)
<div class="language dropdown">
    <a data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="true"> <img src="{{ asset('images/flags') }}/@LangCurrent('flag').png" alt="@LangCurrent('name')" width="22px"> </a>
    <div class="dropdown-menu dropdown-menu-right">
      @foreach (LanguageFunc::GetAllLang() as $lang)
      <a class="dropdown-item" hreflang="{{ $lang['locale'] }}" href="{{ LaravelLocalization::getLocalizedURL($lang['locale'], null, [], true) }}"> <img src="{{ asset('images/flags/'. strtoupper($lang['flag']) .'.png') }}" alt="{{ $lang['name'] }}" width="22px" /> &nbsp; {{ $lang['name'] }} </a>
      @endforeach
    </div>
</div>
@endif
```
## Tạo ảnh Thumb
đặt giá trị này vào những nơi bạn muốn hiện ảnh thumb
```
ThemesFunc::GetThumb('link ảnh',80);
```
ví dụ:
```php
$thumb = ThemesFunc::GetThumb($image,80);
return = $thumb;
```

## Khởi động Module Messenger
Cài đặt thư viện socket.io, ioredis, forever và forever-moniter
```
npm install socket.io ioredis --save
```
```
npm install forever -g
```
```
npm install forever-monitor
```
khởi động thư việc socket vĩnh viễn
```
forever start --minUptime 1000 --spinSleepTime 1000 modules/Messenger/chatserver.js
```
Khởi động Queue:
```
php artisan queue:listen
```

## Webpush notifications channel for Laravel. http://laravel-notification-channels.com
```
composer require laravel-notification-channels/webpush
```
Nếu gặp lỗi ext-gmp thì tiến hành cài đặt php gmp vào chạy lại lệnh.

Nếu vẫn lỗi tiến hành sửa file "composer.json" thêm đoạn sau vào "repositories"
```
{ 
    "type": "git", 
    "url": "https://github.com/laravel-notification-channels/webpush" 
}
```
và chạy lại lệnh.
Nếu vẫn chưa được tiến hành thêm tiếp đoạn sau vào "require":
```
"laravel-notification-channels/webpush": "dev-master#93cd1df5e43ff61a1a4d68229ec1908089114a7a",
```
### Cache
Tạo Cache Route
```
php artisan route:cache
```
Xoá Cache Route
```
php artisan route:clear
```
Xoá Cache riêng biệt
```
Cache::forget('key');
```
Xoá tất cả cache
```
Cache::flush();
```
Gọi Cache sau đó tiến hành xoá Cache đó khỏi bộ nhớ Cache
```
Cache::pull('key');
```
Cách lưu data cache
```php
$assets = Cache::remember('allassets', $minutes, function() use ($keywork) {
            return ($keywork)?Assets::with(['com','cat','supplier','affiliate'])->where('company',Auth::user()->departuser->department->parentid)->where(function ($query) use ($keywork){
                $query->where('name','LIKE','%'.$keywork.'%')
                ->orwhere('description','LIKE','%'.$keywork.'%')
                ->orwhere('asset_code_hc','LIKE','%'.$keywork.'%')
                ->orwhere('asset_code_kt','LIKE','%'.$keywork.'%');
            })->orderBy('id')->get():Assets::with(['com','cat','supplier','affiliate'])->where('company',Auth::user()->departuser->department->parentid)->orderBy('id')->get();
        });
```
Lưu Cahe trong thời gian nhất định
```php
Cache::put('test', $data, now()->addMinutes(1));
```
### Format time ago
```php
Carbon::parse($time)->diffForhumans()
```
### Lấy thông tin theo từng trạng thái riêng biệt của Route
```
Route::getFacadeRoot()->current()->uri();
```
### Capcha
link đăng ký capcha
```
https://www.google.com/recaptcha/intro/v3.html
```
thêm mã sau vào bất kỳ chỗ nào muốn hiển thị xác nhận bằng capcha
```
@CapchaSite()
```
sau đó thêm đoạn sau vào function post validator
```
'g-recaptcha-response' => 'required|captcha'
```
### Active Menu
thêm đoạn sau vào vị trí muốn hiển trị class active.
$url là đường dẫn chi tiết của menu
```php
{{ set_active($url) }}
```
### Google map
Thêm đoạn sau vào Controller muốn lấy thông tin google map
```php
getgooglemap($arraymap,$type);
```
trong đó

$type là loại map 
```
('geocoding','directions',...)
```
$arraymap là mảng tuỳ biến của map ví dụ
```php
$arraymap = ['address' =>'38 Hàng Bè, Hàng Bạc, hoàn Kiếm, hà Nội'];
$arraymap = ['latlng' =>'21.063508, 105.885237'];
```
Thêm bản đồ vào website
```
style
- false
- GRAYSCALE
- MIDNIGHT
- BLUE
```
```php
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key={!!env('GOOGLE_MAP_KEY')!!}" ></script>
<script type="text/javascript" src="{{ asset('js/mapit/jquery.mapit.min.js') }}"></script>
<script type="text/javascript">
    $('#map').mapit({
      latitude:    {!!$map['lat']!!},
      longitude:   {!!$map['lng']!!},
      zoom:        16,
      type:        'ROADMAP',
      scrollwheel: false,
      marker: {
        latitude:   {!!$map['lat']!!},
        longitude:  {!!$map['lng']!!},
        icon:       '{{ asset('images/marker_red.png') }}',
        title:      '{!!(CFglobal::cfn('sitename'))?CFglobal::cfn('sitename'):'';!!}',
        open:       false,
        center:     true
      },
      address: '<h5>{!!(CFglobal::cfn('sitename'))?CFglobal::cfn('sitename'):'';!!}</h5><p>{!!trans('Langcore::global.Address')!!}: {!!(CFglobal::cfn('site_address'))?CFglobal::cfn('site_address'):''!!}</p><p>{!!trans('Langcore::global.Phone')!!}: {!!(CFglobal::cfn('site_phone'))?CFglobal::cfn('site_phone'):''!!}</p><p>{!!trans('Langcore::global.Email')!!}: {!!(CFglobal::cfn('site_email'))?CFglobal::cfn('site_email'):''!!}</p>',
      styles: false,
    });
</script>
```
### Mã hoá Hash và giải mã bằng encrypt() và decrypt()
Mã hoá
```
encrypt('Nguyễn Anh Tuấn');
\\eyJpdiI6ImtVajNRZHpub25aWGloWjltQnkxd1E9PSIsInZhbHVlIjoiSzlnWEt1VDVFTHZmbFFrMk5vMS9UcS9Zd3I4Tjhsc3RHMmhLeHgrb2U4bz0iLCJtYWMiOiI3NDlmMzliOTI2ZjViOGM1ZjU0OTEyY2QzOTllYjU3NDQzNWU3ZjI4YWY0MzcwMGM2ZmQ1OTQyMTM0M2U4OTRiIn0=
```
Giải mã
```
$mahoa = encrypt('Nguyễn Anh Tuấn');
decrypt($mahoa);
\\ Nguyễn Anh Tuấn
```
# retry()
cho phép thử bao nhiêu lần nếu tất cả đều thất bại sẽ khoá trong thời gian được chỉ định
```php
return retry(5, function () {
    //code
}, 100);
```

```php
->middleware('throttle:6,1');
```
### Module Search System
Để thêm một trường tìm kiếm hệ thống vào một Module tiến hành thêm vào file Model tương ứng của Module đó:
```
use Modules\Search\ModuleSearchable;
use Modules\Search\ModuleSearchResult;
use AdminFunc;
```
Tìm 
```
extends Model
```
và thêm vào sau đó 
```
implements ModuleSearchable
```
trong <strong>Class</strong> của Model ta thêm:
```
public $searchableType;
```
Trong 
```php
public function __construct()
```
Thêm:
```php
        $this->searchableType = AdminFunc::ReturnModule('Module Name','title');
```
"Module Name" là tên thư mục chữa Module đó.
Thêm tiếp vào file Model đó:
```php
    public function getSearchResult(): ModuleSearchResult
    {
        $url = route('nameroute',['id'=>$this->id,'slug'=>$this->slug->slug]);

        return new ModuleSearchResult(
            $this,
            $this->title,
            $this->description,
            $url
        );
    }
```
nameroute là tên của route mà chúng ta truyền vào cùng với các biến điều kiện.
Ví dụ:
```php
$url = route('shop.web.detail',['id'=>$this->id,'slug'=>$this->slug->slug]);
```
Tại Folder Module chúng ta thêm một file mới với tên là "search.php" và nội dung của file như sau:
```php
<?php
namespace Modules\ModuleName;
use Modules\ModuleName\Models\NameModel;
use Modules\Search\ModuleModelSearchAspect;

$searchmodule = $searchResults->registerModel(NameModel::class, function(ModuleModelSearchAspect $modelSearchAspect) {
       $modelSearchAspect
          ->addSearchableAttribute('title') 
          ->addSearchableAttribute('description') 
          ->addSearchableAttribute('content')
          ->addExactSearchableAttribute('product_code')
          ->where('active', 1);
});
```
Chú thích:
```
addSearchableAttribute => Trả về kết quả cho một phần trùng khớp
addExactSearchableAttribute => Trả về kết quả khớp chính xác với cả cụm từ
```
Hoặc
```php
<?php
namespace Modules\ModuleName;
use Modules\ModuleName\Models\NameModel;
use Modules\Search\ModuleModelSearchAspect;

$searchmodule = $searchResults->registerModel(NameModel::class,['title','description','content']);
```
### Minifier JS và Css
CSS
```php
ThemesFunc::cssminifier('path/file.css');
```
Đối với file css thuộc module hoặc thêm
```php
ThemesFunc::cssminifier('path/module/file.css','module');
ThemesFunc::cssminifier('path/theme/file.css','theme');
```
ví dụ
```php
ThemesFunc::cssminifier('css/app.css');
ThemesFunc::cssminifier('modules/css/pages/pages.css','module');
ThemesFunc::cssminifier('Themes/vswdefault/assets/css/home.css','theme');
```
JS
```php
ThemesFunc::jsminifier('path/file.js');
```
Đối với file js thuộc module hoặc thêm
```php
ThemesFunc::jsminifier('path/module/file.js','module');
ThemesFunc::jsminifier('path/theme/file.js','theme');
```
ví dụ
```php
ThemesFunc::jsminifier('js/app.js');
ThemesFunc::jsminifier('modules/css/pages/pages.js','module');
ThemesFunc::jsminifier('Themes/vswdefault/assets/js/home.js','theme');
```

### Html::decode
```php
{!!Html::decode(Form::label('title', trans('Langcore::global.Title').'<span class="text-danger">(*)</span>',['class' =>'col-sm-3 col-form-label']))!!}
```

### Route tạo subdomain
```php
Route::group(['domain' => '{subdomain}.worx.vn'], function()
{
    Route::any('/', function($subdomain)
    {
        return 'Subdomain123 ' . $subdomain;
    });
});

// Route::group(['prefix' => LaravelLocalization::setLocale(),'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath','theme:theme','CoreMW\RunWidget','CoreMW\CloseSite']], function () {
//  $namespacevswu = 'Modules\VSWUserWeb\Http\Controllers';
//  Route::namespace($namespacevswu)->group(function(){
//    Route::domain('{subdomain}.'.request()->server->get('SERVER_NAME'))->group(function () {
//      Route::name('vswuserweb.web.subdomain.')->group(function () {
//          Route::get('/', 'SubDomainPagesController@usermain')->name('usermain');
//      });
//    });
//  });
// });
```
thêm subdomain.domain.com vào server_name của file v-host của nginx.

### Lấy thông tin pagespeed google
```
https://www.googleapis.com/pagespeedonline/v5/runPagespeed?url={domain}
```
Code lấy ảnh thumb website
```php
$siteURL = "https://worx.vn/";

    //call Google PageSpeed Insights API
    $googlePagespeedData = file_get_contents("https://www.googleapis.com/pagespeedonline/v5/runPagespeed?url=$siteURL&screenshot=true&strategy=mobile");

    //decode json data
    $googlePagespeedData = json_decode($googlePagespeedData, true);

    //screenshot data
    $screenshot = $googlePagespeedData['lighthouseResult']['audits']['final-screenshot']['details']['data'];
    $screenshot = str_replace(array('_','-'),array('/','+'),$screenshot);
    return "<img src=\"".$screenshot."\" />";
```

## Fix lỗi livewire/livewire.js net::ERR_ABORTED 404 (Not Found)
```
php artisan livewire:publish --assets
```

## Hỗ trợ tích hợp cổng thanh toán trực tuyến
```
composer require phpviet/laravel-omnipay
```
nếu lỗi chạy lệnh sau:
```
composer req php-http/guzzle7-adapter phpviet/laravel-omnipay
```
Sau khi cài đặt xong bạn cần phải publish config file để thiết lập thông số cho cổng thanh toán bạn cần tích hợp, publish thông qua câu lệnh:
```
php artisan vendor:publish --provider="PHPViet\Laravel\Omnipay\OmnipayServiceProvider" --tag="config"
```

### Vue
```
npm install npm-run-all --save
npm install vue-tag-editor-set --save
npm install ckeditor4-vue
npm install laravel-vue-pagination
npm install vuelidate --save
npm install --save @rightbraintechbd/vue-awesome-icon-picker
npm install --save @fortawesome/free-regular-svg-icons
npm install vue-select --save
npm install bootstrap bootstrap-vue
npm i vue-debounce
npm i bootstrap-icons
npm install yoastseo --save
```

### Fix lỗi
```
$ rm package-lock.json
$ rm -rf node_modules
$ npm install

-------------
npm config set python "c:\Python\27\python.exe"
```

### API cloudflare.com;
```
composer require cloudflare/sdk:dev-master
```

```php
use Cloudflare\API\Auth\APIKey;
use Cloudflare\API\Adapter\Guzzle;
```
thêm tương ứng với từng tính năng muốn sử dụng ví dụ:
```php
use Cloudflare\API\Endpoints\DNS;
use Cloudflare\API\Endpoints\User;
```
ví dụ gọi danh sách DNS của một domain
```php
$key     = new APIKey('user@example.com', 'apiKey');
$adapter = new Guzzle($key);
$dns    = new DNS($adapter);
dd($dns->listRecords('zoneID'));
```
Cách lấy APIKEY :
```
https://wiki.matbao.net/kb/huong-dan-ket-noi-cloudflare-voi-website-wordpress/
```