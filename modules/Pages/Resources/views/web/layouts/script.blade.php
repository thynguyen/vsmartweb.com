    @ScriptTheme('disable')
    <script src="{{ ThemesFunc::jsminifier('js/cleavejs/cleave.min.js') }}"></script>
    <script src="{{ ThemesFunc::jsminifier('Themes/'.CFglobal::cfn('admintheme').'/assets/js/pnotify.custom.min.js','theme') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.js"></script>
    <script src="{{ ThemesFunc::jsminifier('Themes/'.CFglobal::cfn('theme').'/assets/js/slidebars.min.js','theme') }}"></script>
    <script src="{{ ThemesFunc::jsminifier('Themes/'.CFglobal::cfn('theme').'/assets/js/templates.js','theme') }}"></script>
    @yield('footer')
    @stack('scripts')
    <script type="text/javascript">
        $("#start").rateYo({
            fullStar: true,
            precision: 2,
            starWidth: "25px",
            onChange: function (rating, rateYoInstance) {
                $(this).next().text(rating);
                $('#vote').val(rating);
            }
        });
    </script>
    {!! Assets::renderFooter() !!}
    <div class="modal fade" id="formmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
            </div>
        </div>
    </div>
    @RoutesSys
  </body>
</html>