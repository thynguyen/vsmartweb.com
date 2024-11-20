    @include(CFglobal::cfn('theme').'::cookieConsent.index')
    @ScriptTheme()
    
    <script src="https://code.jquery.com/jquery-migrate-3.0.0.min.js"></script>
    <script src="{{ ThemesFunc::jsminifier('js/cleavejs/cleave.min.js') }}"></script>
    
    <script src="{{ ThemesFunc::jsminifier('Themes/'.CFglobal::cfn('admintheme').'/assets/js/pnotify.custom.min.js','theme') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.js"></script>

    
    <script type="text/javascript" src="{{ ThemesFunc::jsminifier('Themes/'.CFglobal::cfn('theme').'/assets/js/vendor/jquery.jside.menu.js','theme') }}"></script>
    <script type="text/javascript" src="{{ ThemesFunc::jsminifier('Themes/'.CFglobal::cfn('theme').'/assets/js/template.js.php','theme') }}"></script>
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