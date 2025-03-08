<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

<script src="{{ asset('dashboard/js/apexcharts.min.js')}}"></script>
<script src="{{ asset('dashboard/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{ asset('dashboard/js/chart.min.js')}}"></script>
<script src="{{ asset('dashboard/js/echarts.min.js')}}"></script>
<script src="{{ asset('dashboard/js/quill.min.js')}}"></script>
{{-- <script src="{{ asset('dashboard/js/simple-datatables.js')}}"></script> --}}
<script src="{{ asset('dashboard/js/tinymce.min.js')}}"></script>
<script src="{{ asset('dashboard/js/validate.js')}}"></script>
<script src="{{ asset('dashboard/js/main.js')}}"></script>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-bs4.min.js"></script>
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script> --}}
<script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.0.8/js/dataTables.bootstrap5.js"></script>
<script src="https://cdn.datatables.net/buttons/3.0.2/js/dataTables.buttons.js"></script>
<script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.bootstrap5.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.print.min.js"></script>
@livewireScripts
@stack('scripts')
<script>

</script>
<script>
    $('#example').DataTable({
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

<script>
    window.addEventListener('close-modal', event => {
        $('#studentModal').modal('hide');
        $('#updateStudentModal').modal('hide');
        $('#deleteStudentModal').modal('hide');
        $('#ProductModal').modal('hide');

        $('#SubscriptionModal').modal('hide');
        $('#updateSubscriptionModal').modal('hide');
        $('#deleteSubscriptionModal').modal('hide');
        $('#deleteProductModal').modal('hide');
    })

    // for image upload
    function setupUploader(dropAreaId, inputId, browseButtonId, acceptedTypes) {
        const fileDropArea = document.getElementById(dropAreaId);
        const fileInput = document.getElementById(inputId);
        const browseFilesButton = document.getElementById(browseButtonId);

        fileDropArea.addEventListener('dragover', (event) => {
            event.preventDefault();
            fileDropArea.classList.add('active');
        });

        fileDropArea.addEventListener('dragleave', () => {
            fileDropArea.classList.remove('active');
        });

        fileDropArea.addEventListener('drop', (event) => {
            event.preventDefault();
            fileDropArea.classList.remove('active');
            handleFiles(event.dataTransfer.files, acceptedTypes);
        });

        fileDropArea.addEventListener('click', () => {
            fileInput.click();
        });

        browseFilesButton.addEventListener('click', (event) => {
            event.stopPropagation();
            fileInput.click();
        });

        fileInput.addEventListener('change', (event) => {
            handleFiles(event.target.files, acceptedTypes);
        });

        function handleFiles(files, acceptedTypes) {
            for (const file of files) {
                if (acceptedTypes.includes(file.type)) {
                    alert(`File accepted: ${file.name}`);
                } else {
                    alert(`File type not accepted: ${file.name}`);
                }
            }
        }
    }
    setupUploader('image-drop-area', 'imageInput', 'browseImagesButton', ['image/jpeg', 'image/png', 'image/gif']);
    setupUploader('video-drop-area', 'videoInput', 'browseVideosButton', ['video/mp4', 'video/webm', 'video/ogg']);
    var priceTypeSelect = document.getElementById("price_type");
        var pricePart = document.getElementById("price_part");
        function togglePricePart() {
            if (priceTypeSelect.value === "regular") {
                pricePart.style.display = "block";
            } else {
                pricePart.style.display = "none";
            }
        }
        togglePricePart();
        priceTypeSelect.addEventListener("change", togglePricePart);

</script>
<script>
    document.getElementById('filter').addEventListener('change', function() {
        const customDateRange = document.getElementById('custom-date-range');
        if (this.value === 'custom') {
            customDateRange.style.display = 'block';
        } else {
            customDateRange.style.display = 'none';
        }
    });
</script>
</body>
</html>
