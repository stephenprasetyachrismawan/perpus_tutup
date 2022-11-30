    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>

    <script src="assets/DataTables/DataTables-1.10.18/js/jquery.dataTables.min.js"></script>
    <script src="assets/DataTables/DataTables-1.10.18/js/dataTables.bootstrap4.min.js"></script>

    <script src="assets/DataTables/Buttons-1.5.6/js/dataTables.buttons.min.js"></script>
    <script src="assets/DataTables/Buttons-1.5.6/js/buttons.bootstrap4.min.js"></script>
    <script src="assets/DataTables/JSZip-2.5.0/jszip.min.js"></script>
    <script src="assets/DataTables/pdfmake-0.1.36/pdfmake.min.js"></script>
    <script src="assets/DataTables/pdfmake-0.1.36/vfs_fonts.js"></script>
    <script src="assets/DataTables/Buttons-1.5.6/js/buttons.html5.min.js"></script>
    <script src="assets/DataTables/Buttons-1.5.6/js/buttons.print.min.js"></script>
    <script src="assets/DataTables/Buttons-1.5.6/js/buttons.colVis.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
    <script src="assets/js/jquery.easing.min.js"></script>
    <script src="js/sb-admin-2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js" integrity="sha256-+C0A5Ilqmu4QcSPxrlGpaZxJ04VjsRjKu+G82kl5UJk=" crossorigin="anonymous"></script>

    <script>
        $(document).ready(function() {
            var table = $('#table').DataTable({
                buttons: ['copy', 'csv', 'print', 'excel', 'pdf', 'colvis'],
                dom: "<'row'<'col-md-3'l><'col-md-5'B><'col-md-4'f>>" +
                    "<'row'<'col-md-12'tr>>" +
                    "<'row'<'col-md-5'i><'col-md-7'p>>",
                lengthMenu: [
                    [5, 10, 25, 50, 100, -1],
                    [5, 10, 25, 50, 100, "All"]
                ],
                search: {
                    search: "<?php if (isset($_POST['searchbtn'])) echo $_POST['searchkey']  ?>"
                }
            });
            var table2 = $('#riwayat').DataTable();
            var table3 = $('#anggota').DataTable();
            var table4 = $('#pinjam').DataTable();

            table.buttons().container()
                .appendTo('#table_wrapper .col-md-5:eq(0)');

            var $select = $('select').selectize({
                sortField: 'text'
            });
        });

        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }

        $(".confirmAlert").on("click", function() {
            var getLink = $(this).attr('href');
            Swal.fire({
                title: "Yakin hapus data?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                confirmButtonText: 'Ya',
                cancelButtonColor: '#3085d6',
                cancelButtonText: "Batal"

            }).then(result => {
                if (result.isConfirmed) {
                    window.location.href = getLink;
                }
            });
            return false;
        });

        $(".confirmPinjam").on("click", function(){
            var judul = $(this).data('judul');
            var link = $(this).attr('href');
            Swal.fire({
                title: "Apakah anda ingin melakukan permintaan peminjaman terhadap buku \"".concat(judul).concat("\"?"),            
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                confirmButtonText: 'Ya',
                cancelButtonColor: '#3085d6',
                cancelButtonText: "Batal",
            }).then(result => {
                if(result.isConfirmed){
                    window.location.href = link;
                }
            });
            return false;
        });

        $(".confirmKembali").on("click", function() {
            var getLink = $(this).attr('href');
            var id = $(this).data('id');
            var buku = $(this).data('buku');
            Swal.fire({
                title: "Yakin Kembalikan Buku ".concat(buku).concat(', dengan ID Peminjaman ').concat(id).concat('?'),
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                confirmButtonText: 'Ya',
                cancelButtonColor: '#3085d6',
                cancelButtonText: "Batal"

            }).then(result => {
                if (result.isConfirmed) {
                    window.location.href = getLink;
                }
            });
            return false;
        });

        function valid() {
            var file = document.getElementById('pic');
            var filePath = file.value;
            var [pic] = file.files;

            var ekstensi = /(\.jpg|\.jpeg|\.png)$/i;

            if (!ekstensi.exec(filePath)) {
                Swal.fire('Masukan file gambar', '', 'error');
                file.value = '';
                document.getElementById('display').hidden = true;
                document.getElementById('display').src = "";
                return false;
            }
            var src = document.getElementById('display').src;
            if (pic) {
                document.getElementById('display').src = URL.createObjectURL(pic);
                document.getElementById('display').hidden = false;
            }
        }
        $.fn.dataTable.ext.errMode = 'none';
    </script>
    </body>

    </html>