## Tuỳ chỉnh giao diện Slider
Nếu như kiểu slider đều giống nhau thì trong file blade của slide tai viết thuộc tính như bình thường, nhưng nếu kiểu slider biến động không đồng nhất thì trong file blade ta viết như sau
```php
   @foreach($sliders as $slider)
	@if($slider->template && File::exists(base_path('Themes/'.CFglobal::cfn('theme').'/views/widgets/Sliders/templates/'.$slider->template->template.'.blade.php')))
	@include('widgets.Sliders.templates.'.$slider->template->template)
	@endif
   @endforeach
```
Và trong thư mục chứa các file hiển thị của slider trong giao diện ta thêm một thư mục:
```
templates
```
lúc này trong thư mục "templates" ta tiến hành thêm vào đó các file blade là kiểu dáng của slider và nội dung của các file này ta tiến hành viết như bình thường.

Thuộc tính sẽ được viết trong các file kiểu mẫu:
```php
$slider->image
$slider->title
$slider->description
$slider->link
```
thuộc tính gọi đường dẫn tài nguyên assets
```php
themes('images/slider/pattern_arrow2.png')
```