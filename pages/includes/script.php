<script type="text/javascript" src="../../dist/js/jquery.js"></script>
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../../plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<script src="../../plugins/jquery-mousewheel/jquery.mousewheel.js"></script>
<script src="../../plugins/raphael/raphael.min.js"></script>
<script src="../../plugins/chart.js/Chart.min.js"></script>
<script src="../../plugins/sparklines/sparkline.js"></script>
<script src="../../plugins/jquery-ui/jquery-ui.min.js"></script>
<script src="../../plugins/summernote/summernote-bs4.min.js"></script>
<script src="../../plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="../../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="../../plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="../../plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="../../plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="../../plugins/jszip/jszip.min.js"></script>
<script src="../../plugins/pdfmake/pdfmake.min.js"></script>
<script src="../../plugins/pdfmake/vfs_fonts.js"></script>
<script src="../../plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="../../plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="../../plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<script src="../../plugins/ekko-lightbox/ekko-lightbox.min.js"></script>
<script src="../../plugins/filterizr/jquery.filterizr.min.js"></script>
<script src="../../dist/js/adminlte.min.js"></script>
<script src="../../plugins/jquery-knob/jquery.knob.min.js"></script>
<script src="../../plugins/moment/moment.min.js"></script>
<script src="../../plugins/daterangepicker/daterangepicker.js"></script>
<script src="../../plugins/bs-stepper/js/bs-stepper.min.js"></script>
<!-- <script src="../../dist/js/pages/dashboard.js"></script> -->
<script src="../../plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<script src="../../plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<script src="../../plugins/select2/js/select2.full.min.js"></script>
<script src="../dist/js/sweetalert2.all.min.js"></script>
<script src="../../dist/manific/jquery.magnific-popup.min.js"></script>
<script src="../../inc/main.js"></script>



<script>
  $("#example1").DataTable({
    "responsive": true,
    "lengthChange": false,
    "autoWidth": false,
    "searching": true,
    "ordering": false,
    "buttons": ["copy", "csv", "excel", "pdf", "print"]
  }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

  $(document).ready(function() {
    $("table tr").each(function(index) {
      $(this).delay(index * 100).queue(function(next) {
        $(this).addClass("fade-in");
        next();
      });
    });
  });

  $('.select2').select2()
  $('.select2bs4').select2({
    theme: 'bootstrap4'
  })


  function printInvoice() {
  // Open a new window for printing
  var printWindow = window.open('', '_blank');
  var content = document.getElementById("invoiceContent").innerHTML;

  // Write HTML structure and content for the print window
  printWindow.document.write(`
  <html>
  <head>
    <title>Print Receipt</title>
    <style>
      /* General Styles for 50mm thermal paper */
      body {
        width: 50mm;
        margin: 0;
        padding: 0;
        font-family: Arial, sans-serif; /* Set default font */
        font-size: 10px; /* Smaller font size for narrower paper */
      }

      /* Styles for invoice content */
      #invoiceContent {
        padding: 20px; /* Minimal padding */
        box-sizing: border-box;
      }

      #invoiceContent h5 {
        font-size: 12px; /* Header title adjusted for smaller paper */
        font-weight: bold;
        text-align: center;
        margin: 5px 0;
        line-height: 1.4;
      }

      #invoiceContent p, #invoiceContent address {
        margin: 5px 0;
        font-size: 10px; /* Paragraph and address size */
        font-style: normal;
        line-height: 1.4;
        text-align: left !important;
      }

      .labelpayment {
        gap: 1px;
      }

      .border-bottom {
        border-bottom: 1px solid #e0e0e0;
        margin-bottom: 3px;
        padding-bottom: 3px;
      }

      .table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 8px;
      }

      .table th, .table td {
        padding: 2px;
        font-size: 9px; /* Table content adjusted for smaller paper */
        text-align: left;
      }

      .lead {
        font-size: 11px; /* Highlighted text slightly larger */
        font-weight: bold;
      }

    
      #monthlypayments {
        font-size: 11px; /* Monthly payment details adjusted */
      }

      /* Footer message styling */
      .footer-message {
        text-align: center;
        margin-top: 5px;
        font-size: 8px; /* Footer message smaller */
      }
    </style>
  </head>
  <body onload="window.print(); window.close();">
    <div id="invoiceContent">
      ${content}
    </div>
  </body>
  </html>
  `);
  printWindow.document.close();
}

function printPaidInvoice() {
  // Open a new window for printing
  var printWindow = window.open('', '_blank');
  var content = document.getElementById("printPaidInvoice").innerHTML;

  // Write HTML structure and content for the print window
  printWindow.document.write(`
  <html>
  <head>
    <title>Print Receipt</title>
    <style>
      /* General Styles for 50mm thermal paper */
      body {
        width: 50mm;
        margin: 0;
        padding: 0;
        font-family: Arial, sans-serif; /* Set default font */
        font-size: 10px; /* Smaller font size for narrower paper */
      }

      /* Styles for invoice content */
      #invoiceContent {
        padding: 20px; /* Minimal padding */
        box-sizing: border-box;
      }

      #invoiceContent h5 {
        font-size: 12px; /* Header title adjusted for smaller paper */
        font-weight: bold;
        text-align: center;
        margin: 5px 0;
        line-height: 1.4;
      }

      #invoiceContent p, #invoiceContent address {
        margin: 5px 0;
        font-size: 10px; /* Paragraph and address size */
        font-style: normal;
        line-height: 1.4;
        text-align: left !important;
      }

      .labelpayment {
        gap: 1px;
      }

      .border-bottom {
        border-bottom: 1px solid #e0e0e0;
        margin-bottom: 3px;
        padding-bottom: 3px;
      }

      .table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 8px;
      }

      .table th, .table td {
        padding: 2px;
        font-size: 9px; /* Table content adjusted for smaller paper */
        text-align: left;
      }

      .lead {
        font-size: 11px; /* Highlighted text slightly larger */
        font-weight: bold;
      }

    
      #monthlypayments {
        font-size: 11px; /* Monthly payment details adjusted */
      }

      /* Footer message styling */
      .footer-message {
        text-align: center;
        margin-top: 5px;
        font-size: 8px; /* Footer message smaller */
      }
    </style>
  </head>
  <body onload="window.print(); window.close();">
    <div id="invoiceContent">
      ${content}
    </div>
  </body>
  </html>
  `);
  printWindow.document.close();
}


</script>