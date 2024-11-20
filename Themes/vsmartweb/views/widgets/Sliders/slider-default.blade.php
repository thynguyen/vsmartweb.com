<div class="tw-hero-slider owl-carousel">
   @foreach($sliders as $slider)
	@if($slider->template && File::exists(base_path('Themes/'.CFglobal::cfn('theme').'/views/widgets/Sliders/templates/'.$slider->template->template.'.blade.php')))
	@include('widgets.Sliders.templates.'.$slider->template->template)
	@endif
   @endforeach
</div>