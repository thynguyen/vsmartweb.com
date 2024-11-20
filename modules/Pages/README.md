
## Thêm một block html vào builder
mở file "blocks-bootstrap4.js" thêm vào cuối file
```php
Vvveb.Blocks.add("bootstrap4/nameblock", {
    name: "Bootstrap 4 Responsive Pricing Table",
    dragHtml: '<img src="' + Vvveb.baseUrl + 'icons/product.png">',    
    image: "https://startbootstrap.com/assets/img/screenshots/snippets/pricing-table.jpg",
    html: `Nội dung HTML`,
}); 
```
tìm đoạn:
```
Vvveb.BlocksGroup['Bootstrap 4 Snippets'] = [];
```
thêm vào trong thẻ "[]"
```
"bootstrap4/nameblock"
```


```php
<script type="text/javascript">
var urluploadfile = '{!!route('pages.admin.uploadfile')!!}';
$(document).ready(function() 
{
	$(".component-properties-tab").show();
	$("#filemanager").hide();

   @if($page->content)
   Vvveb.Builder.init('{!!$contentfile!!}', function() {});
   @else
   // Vvveb.Builder.init('{!!route('pages.web.builderhtml',['title'=>$page->title])!!}', function() {});
   Vvveb.Builder.init('{!!$datatemp['url']!!}', function() {});
   @endif

	Vvveb.Gui.init();
	Vvveb.FileManager.init();
	Vvveb.Sections.init();
	Vvveb.FileManager.addPages(
	[
		{name:"theme-default", title:"Theme Default",  url: "{!!route('pages.web.builderhtml',['title'=>$page->title])!!}", file: "{!!route('pages.web.builderhtml',['title'=>$page->title])!!}", assets: ['{{ themes(CFglobal::cfn('theme').':css/style.css') }}']},
      {name:"narrow-jumbotron", title:"Jumbotron",  url: "{!!asset('modules/js/pages/builder/templates/narrow-jumbotron/index.php')!!}", file: "{!!asset('modules/js/pages/builder/templates/narrow-jumbotron/index.php')!!}", assets: ['{!!asset('modules/js/pages/builder/templates/narrow-jumbotron/narrow-jumbotron.css')!!}']},
      {name:"stylish-portfolio", title:"Stylish Portfolio",  url: "{!!asset('modules/js/pages/builder/templates/stylish-portfolio/index.php')!!}", file: "{!!asset('modules/js/pages/builder/templates/stylish-portfolio/index.php')!!}", assets: ['{!!asset('templates/stylish-portfolio/css/landing-page.min.css')!!}']},
      {name:"creative", title:"Creative",  url: "{!!asset('modules/js/pages/builder/templates/creative/index.php')!!}", file: "{!!asset('modules/js/pages/builder/templates/creative/index.php')!!}", assets: ['{!!asset('templates/creative/css/landing-page.min.css')!!}']},
      {name:"resume", title:"Resume",  url: "{!!asset('modules/js/pages/builder/templates/resume/index.php')!!}", file: "{!!asset('modules/js/pages/builder/templates/resume/index.php')!!}", assets: ['{!!asset('templates/resume/css/styles.css')!!}','{!!asset('templates/resume/js/scripts.js')!!}']},
		{name:"landing-page", title:"Landing page",  url: "{!!asset('modules/js/pages/builder/templates/landing-page/index.php')!!}", file: "{!!asset('modules/js/pages/builder/templates/landing-page/index.php')!!}", assets: ['{!!asset('templates/landing-page/css/landing-page.min.css')!!}']},
		{name:"album", title:"Album",  url: "{!!asset('modules/js/pages/builder/templates/album/index.php')!!}", file: "{!!asset('modules/js/pages/builder/templates/album/index.php')!!}", folder:"content", assets: ['{!!asset('modules/js/pages/builder/templates/album/album.css')!!}']},
		{name:"blog", title:"Blog",  url: "{!!asset('modules/js/pages/builder/templates/blog/index.php')!!}", file: "{!!asset('modules/js/pages/builder/templates/blog/index.php')!!}", folder:"content", assets: ['{!!asset('modules/js/pages/builder/templates/blog/blog.css')!!}']},
		{name:"carousel", title:"Carousel",  url: "{!!asset('modules/js/pages/builder/templates/carousel/index.php')!!}",  file: "{!!asset('modules/js/pages/builder/templates/carousel/index.php')!!}", folder:"content", assets: ['{!!asset('modules/js/pages/builder/templates/carousel/carousel.css')!!}']},
		{name:"offcanvas", title:"Offcanvas",  url: "{!!asset('modules/js/pages/builder/templates/offcanvas/index.php')!!}", file: "{!!asset('modules/js/pages/builder/templates/offcanvas/index.php')!!}", folder:"content", assets: ['{!!asset('modules/js/pages/builder/templates/offcanvas/offcanvas.css')!!}','{!!asset('modules/js/pages/builder/templates/offcanvas/offcanvas.js')!!}']},
		{name:"pricing", title:"Pricing",  url: "{!!asset('modules/js/pages/builder/templates/pricing/index.php')!!}", file: "{!!asset('modules/js/pages/builder/templates/pricing/index.php')!!}", folder:"ecommerce", assets: ['{!!asset('modules/js/pages/builder/templates/pricing/pricing.css')!!}']},
		{name:"product", title:"Product",  url: "{!!asset('modules/js/pages/builder/templates/product/index.php')!!}", file: "{!!asset('modules/js/pages/builder/templates/product/index.php')!!}", folder:"ecommerce", assets: ['{!!asset('modules/js/pages/builder/templates/product/product.css')!!}']},
	]);
	@if(!$page->content)
	Vvveb.FileManager.loadPage('theme-default');
   @endif
});
</script>
```