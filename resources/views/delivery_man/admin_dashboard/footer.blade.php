@foreach ($appsettings as $setting)

<footer id="footer" class="footer">
    <div class="copyright"> {{ $setting['panel_footer_text'] }}</div>
  </footer>
@endforeach
