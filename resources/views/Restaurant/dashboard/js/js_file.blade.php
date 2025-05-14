<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

<script src="{{ asset('dashboard/js/apexcharts.min.js')}}"></script>
<script src="{{ asset('dashboard/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{ asset('dashboard/js/chart.min.js')}}"></script>
<script src="{{ asset('dashboard/js/echarts.min.js')}}"></script>
<script src="{{ asset('dashboard/js/quill.min.js')}}"></script>
<script src="{{ asset('dashboard/js/tinymce.min.js')}}"></script>
<script src="{{ asset('dashboard/js/validate.js')}}"></script>
<script src="{{ asset('dashboard/js/main.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-bs4.min.js"></script>
<script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.0.8/js/dataTables.bootstrap5.js"></script>
<script src="https://cdn.datatables.net/buttons/3.0.2/js/dataTables.buttons.js"></script>
<script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.bootstrap5.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.print.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
        $('.select-delivery-zone').select2({
            placeholder: 'Select a street',
            allowClear: true
        });
        $('.edit-select-delivery-zone').select2({
            placeholder: 'Select a street',
            allowClear: true
        });
    });
</script>

<script>
    $('#datatables').DataTable({
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
        destroy: true,
        "order": [[0, 'desc']]

    });
</script>

<script>
    $(document).ready(function() {
        $('#summernote').summernote({
            height: 250 // set the height to 300px or any height you prefer
        });
    });
</script>
</body>
</html>
