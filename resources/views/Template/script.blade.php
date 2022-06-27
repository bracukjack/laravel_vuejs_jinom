<script src="{{ asset('js/app.js') }}"></script>

<!-- DataTables -->
<script src="{{ asset ('/plugins/datatables/jquery.dataTables.js/') }}"></script>
<script src="{{ asset ('/plugins/datatables/dataTables.bootstrap4.js/') }}"></script>

<script>
  $(function () {
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false
    });
  });
</script>

