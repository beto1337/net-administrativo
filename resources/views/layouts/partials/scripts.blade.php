<!-- REQUIRED JS SCRIPTS -->

<!-- jQuery 2.1.4 -->
<script src="{{ asset('/plugins/jQuery/jQuery-2.1.4.min.js') }}"></script>
<!-- Bootstrap 3.3.2 JS -->
<script src="{{ asset('/js/bootstrap.min.js') }}" type="text/javascript"></script>
<!-- AdminLTE App -->

<script src="{{ asset('/js/app.min.js') }}" type="text/javascript"></script>

<!-- Optionally, you can add Slimscroll and FastClick plugins.
      Both of these plugins are recommended to enhance the
      user experience. Slimscroll is required when using the
      fixed layout. -->

      <script src="{{ asset('js/plugins/canvas-to-blob.min.js')}}" type="text/javascript"></script>
      <!-- sortable.min.js is only needed if you wish to sort / rearrange files in initial preview.
           This must be loaded before fileinput.min.js -->
      <script src="{{ asset('js/plugins/sortable.min.js')}}" type="text/javascript"></script>
      <!-- purify.min.js is only needed if you wish to purify HTML content in your preview for HTML files.
           This must be loaded before fileinput.min.js -->
      <script src="{{ asset('js/plugins/purify.min.js')}}" type="text/javascript"></script>
      <!-- the main fileinput plugin file -->
      <script src="{{ asset('js/fileinput.min.js')}}"></script>
      <script src="{{ asset('js/locales/es.js')}}"></script>
      <!-- bootstrap.js below is needed if you wish to zoom and view file content
           in a larger detailed modal dialog -->
           <script type="text/javascript" src="{{ asset('js/moment.min.js')}}"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" type="text/javascript"></script>
      <!-- optionally if you need a theme like font awesome theme you can include
          it as mentioned below -->
          <!-- bootstrap time picker -->

          <script type="text/javascript" src="{{ asset('js/transition.js')}}"></script>
          <script type="text/javascript" src="{{ asset('js/collapse.js')}}"></script>
      <script src="{{asset('themes/fa/theme.js')}}"></script>
      <script src="{{ asset('js/locales/ar.js')}}"></script>
      <script src="{{ asset('plugins/select2/select2.full.min.js')}}"></script>
      <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js')}}"></script>
      <script src="{{ asset('plugins/datatables/dataTables.bootstrap.min.js')}}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
<script src="{{ asset('plugins/daterangepicker/daterangepicker.js')}}"></script>
<script src="{{ asset('plugins/datepicker/bootstrap-datepicker.js')}}"></script>
      <script>

      $("#input-700").fileinput({
          language: "es",
          uploadUrl: "http://localhost/file-upload-single/1", // server upload action
          uploadAsync: true,
          maxFileCount: 10
      });

      </script>

      <!-- Optionally, you can add Slimscroll and FastClick plugins.
            Both of these plugins are recommended to enhance the
            user experience. Slimscroll is required when using the
            fixed layout. -->
