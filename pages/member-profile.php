<?php include '../inc/session.php' ?>
<!DOCTYPE html>
<html lang="en">

<head>

  <head>
    <?php include 'includes/link.php' ?>
  </head>
</head>
<style>
  p {
    margin-top: 0;
    margin-bottom: 0.1rem !important;
  }

  li.small {
    margin: 0.5rem 0 !important;
  }

  .lead {
    font-size: 2rem !important;
    font-weight: 300;
  }

  .text-sm {
    font-size: 15px !important;
  }

  ul.text-muted {
    font-size: 18px !important;
  }

  .profile-img {
    width: 155px !important;
    height: 155px !important;
    object-fit: cover !important;
  }

  .badge.totalthis {
    padding: 6px 10px !important;
    font-size: 100% !important;
  }

  #invoiceContent p,
  #printPaidInvoice p {
    margin: 0;
    font-size: 13px;
  }

  #invoiceContent h5,
  #printPaidInvoice h5 {
    font-size: 15px;
    font-weight: bold;
  }



  #invoiceContent th,
  #invoiceContent td {
    padding: 8px;
    text-align: left;
  }

  #invoiceContent th {
    background-color: #f8f8f8;
  }

  .text-center {
    text-align: center;
  }

  .text-right {
    text-align: right;
  }

  .border-bottom {
    border-bottom: 1px solid #e0e0e0;
  }

  .lead {
    font-size: 1.25em;
    font-weight: bold;
  }

  address {
    font-size: 13px;
  }
</style>


<body class="hold-transition sidebar-mini" id="tenantlist">
  <div class="wrapper">
    <?php include 'includes/sidebar.php' ?>

    <?php

    if (isset($_GET['member_id'])) {
      $memberID = $_GET['member_id'];
      $query = mysqli_query($conn, "SELECT member.*, beneficiary.* FROM `member` INNER JOIN beneficiary ON member.member_id = beneficiary.member_id WHERE member.member_id = $memberID");
      $result = mysqli_fetch_array($query);
      extract($result);
    }

    ?>
    <div class="content-wrapper">
      <section class="content Pages">
        <div class="container-fluid">

          <div class="card-body">
            <div class="row">
              <div class="col-12 col-sm-6 d-flex align-items-stretch flex-column">
                <div class="card  bg-light d-flex flex-fill">
                  <div class="card-header text-muted border-bottom-0">
                    MEMBER
                  </div>
                  <div class="card-body pt-0">
                    <div class="row">
                      <div class="col-7">
                        <h2 class="lead" style="font-weight: 100 !important;"><b><?php echo $mname ?></b></h2>
                        <p class="text-muted text-sm"><b>Gender: </b><?php echo $mgender ?></p>
                        <p class="text-muted text-sm"><b>Birthdate: </b><?php echo $bdate ?></p>
                        <ul class="ml-4 mb-0 fa-ul text-muted">
                          <li class="small"><span class="fa-li"><i class="fas fa-lg fa-building"></i></span> Address: <?php echo $maddress ?></li>
                          <li class="small"><span class="fa-li"><i class="fas fa-lg fa-phone"></i></span> Phone #: <?php echo $mcontact ?></li>
                        </ul>
                      </div>
                      <div class="col-5 text-center">
                        <a class="image-popup-vertical-fit" href="../image/member/PROFILE/<?php echo $mprofile ?>">
                          <img src="../image/member/PROFILE/<?php echo $mprofile ?>" alt="user-avatar" class="img-circle img-fluid profile-img">
                        </a>
                  
                      </div>
                    </div>
                  </div>
                  <div class="card-footer">
                    <div class="text-right">

                    </div>
                  </div>
                </div>
              </div>

              <div class="col-12 col-sm-6 d-flex align-items-stretch flex-column">
                <div class="card bg-light d-flex flex-fill">
                  <div class="card-header text-muted border-bottom-0">
                    BENEFICIARY
                  </div>
                  <div class="card-body pt-0">
                    <div class="row">
                      <div class="col-7">
                        <h2 class="lead" style="font-weight: 100 !important;"><b><?php echo $bname ?></b></h2>
                        <p class="text-muted text-sm"><b>Relationship: </b><?php echo $brelation ?></p>
                        <p class="text-muted text-sm"><b>Gender: </b><?php echo $bgender ?></p>
                        <p class="text-muted text-sm"><b>Birthdate: </b><?php echo $bdate ?></p>
                        <ul class="ml-4 mb-0 fa-ul text-muted">
                          <li class="small"><span class="fa-li"><i class="fas fa-lg fa-building"></i></span> Address: <?php echo $baddress ?></li>
                          <li class="small"><span class="fa-li"><i class="fas fa-lg fa-phone"></i></span> Phone #: <?php echo $bcontact ?></li>
                        </ul>
                      </div>
                      <div class="col-5 text-center">
                        <a class="image-popup-vertical-fit" href="../image/beneficiary/PROFILE/<?php echo $bprofile ?>">
                          <img src="../image/beneficiary/PROFILE/<?php echo $bprofile ?>" alt="user-avatar" class="img-circle img-fluid profile-img">
                        </a>

                      </div>
                    </div>
                  </div>
                  <div class="card-footer">
                    <div class="text-right">

                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header p-2">
                    <div class="card-tools">
                      <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                      </button>

                    </div>
                    <ul class="nav nav-pills">
                      <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">Total Shares</a></li>
                      <li class="nav-item"><a class="nav-link" href="#timeline" data-toggle="tab">Existing Loan</a></li>
                      <li class="nav-item"><a class="nav-link" href="#paymentsummary" data-toggle="tab">Payment History</a></li>
                      <li class="nav-item"><a class="nav-link" href="#loanhistory" data-toggle="tab">Loan History</a></li>
                      <li class="nav-item"><a class="nav-link" href="#validID" data-toggle="tab">Valid ID</a></li>
                    </ul>
                  </div>
                  <div class="card-body ">
                    <div class="tab-content">
                      <div class="tab-pane active" id="activity">
                        <div class="card-header pl-0">
                          <div class="card-title float-left">
                            <?php
                            $query = mysqli_query($conn, "SELECT SUM(mshare) AS total_share FROM share WHERE `member_id` = $memberID");
                            if ($query) {
                              $result = mysqli_fetch_assoc($query);
                              $total_share = isset($result['total_share']) ? $result['total_share'] : 0.00;
                            } else {
                              $total_share = 0.00;
                            }
                            ?>
                            <h3 class="badge badge-success totalthis">Total Funds: <?php echo number_format($total_share, 2) ?></h3>
                          </div>
                        </div>
                        <table id="example1" class="table table-striped table-bordered">
                          <thead>
                            <tr>
                              <th>OR No.</th>
                              <th>Share Amount</th>
                              <th>Type</th>
                              <th>Date</th>
                              <th>Invoice</th>
                            </tr>
                          </thead>

                          <tbody>
                            <?php

                            $maxShareIdQuery = mysqli_query($conn, "SELECT MAX(share_id) AS max_share_id FROM `share` WHERE member_id = $_GET[member_id]");
                            $maxShareIdResult = mysqli_fetch_assoc($maxShareIdQuery);
                            $maxShareId = $maxShareIdResult['max_share_id'];

                            $display_member_funds_table = display_member_funds_table($conn);
                            while ($result = mysqli_fetch_array($display_member_funds_table)) {
                              extract($result);

                              $isMostRecent = ($share_id == $maxShareId);

                            ?>
                              <tr>
                                <td><?php echo $invoice_number ?></td>
                                <td><?php echo number_format($mshare, 2) ?></td>
                                <td><?php echo $type ?></td>
                                <td><?php echo date('M d, Y', strtotime($date)); ?></td>
                                <td> <button class="btn btn-primary btn-sm" id="viewreciept"
                                    data-share-id="<?php echo $share_id; ?>"
                                    data-toggle="modal" data-target="#modal-viewinvoice">
                                    <i class="fa-solid fa-file-invoice"></i>Receipt
                                  </button></td>
                              </tr>
                            <?php
                            }
                            ?>
                          </tbody>
                        </table>
                      </div>

                      <div class="tab-pane" id="timeline">
                        <div class="card-header pl-0">
                          <div class="card-title float-left">
                            <?php
                            $query = mysqli_query($conn, "SELECT SUM(monthlypayment) AS total_monthlyunpaid FROM monthly_payment WHERE `member_id` = $memberID AND `status` = 'Unpaid'");
                            if ($query) {
                              $result = mysqli_fetch_assoc($query);
                              $total_monthlyunpaid = isset($result['total_monthlyunpaid']) ? $result['total_monthlyunpaid'] : 0.00;
                            } else {
                              $total_monthlyunpaid = 0.00;
                            }
                            ?>
                            <a href="">
                              <h3 class="badge badge-warning totalthis" style="color: #fff;">Existing Balance: <?php echo number_format($total_monthlyunpaid, 2) ?></h3>
                            </a>
                          </div>
                        </div>
                        <table id="example2" class="table table-striped table-bordered">
                          <thead>
                            <tr>
                              <th style="width: 25%;">OR No.</th>
                              <th style="width: 25%;">Due Date</th>
                              <th style="width: 25%;">Monthly Payment</th>
                              <th style="width: 25%;">Status</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                            $displayunpaidinProfile = displayunpaidinProfile($conn);

                            while ($result = mysqli_fetch_array($displayunpaidinProfile)) {
                              extract($result);
                            ?>
                              <tr>

                                <td><?php echo $reference_payment ?></td>
                                <td><?php echo date('M d, Y', strtotime($duedate)) ?></td>
                                <td><a href="view-loan.php?member_id=<?php echo $member_id ?>&loan_id=<?php echo $loan_id ?>"><?php echo $monthlypayment ?></a></td>
                                <td class="project-state">
                                  <span class="badge badge-warning" style="color: #fff;">Unpaid</span>
                                </td>
                              </tr>
                            <?php

                            }
                            ?>
                          </tbody>

                        </table>

                      </div>


                      <div class="tab-pane" id="paymentsummary">

                        <table id="example3" class="table table-striped table-bordered">
                          <thead>
                            <tr>
                              <th>OR No.</th>
                              <th>Due Date</th>
                              <th>Monthly Payment</th>
                              <th>Date Payment</th>
                              <th>Status</th>
                              <th>Receipt</th>

                            </tr>
                          </thead>
                          <tbody>
                            <?php
                            $displayProfilePaid = displayProfilePaid($conn);

                            while ($result = mysqli_fetch_array($displayProfilePaid)) {
                              extract($result);
                            ?>
                              <tr>

                                <td><?php echo $reference_payment ?></td>
                                <td><?php echo date('M d, Y', strtotime($duedate)) ?></td>
                                <td><?php echo number_format($monthlypayment, 2) ?></td>
                                <td><?php echo date('M d, Y', strtotime($datepayment)) ?></td>
                                <td class="project-state">
                                  <span class="badge badge-success" style="color: #fff;">Paid</span>
                                </td>
                                <td>
                                  <button class="btn btn-primary btn-sm" id="paidviewinvoice"
                                    data-history-id="<?php echo $payment_history_id; ?>"
                                    data-toggle="modal" data-target="#modal-paidviewinvoice">
                                    <i class="fa-solid fa-file-invoice"></i>Receipt
                                  </button>
                                </td>
                              </tr>
                            <?php

                            }
                            ?>
                          </tbody>

                        </table>

                      </div>

                      <div class="tab-pane" id="loanhistory">

                        <table id="example4" class="table table-striped table-bordered">
                          <thead>
                            <tr>

                              <th>Started</th>
                              <th>Purpose</th>
                              <th>Amount</th>
                              <th>Tenure</th>
                              <th>Interest</th>
                              <th>T/Interest</th>
                              <th>M/Interest</th>
                              <th>T/Payment</th>
                              <th>M/Payment</th>



                            </tr>
                          </thead>
                          <tbody>
                            <?php
                            $displayPaidLoanProfile = displayPaidLoanProfile($conn);
                            while ($result = mysqli_fetch_array($displayPaidLoanProfile)) {
                              extract($result);
                            ?>
                              <tr>
                                <td><?php echo date('M d, Y', strtotime($loanstarted)) ?></td>
                                <td><?php echo $purpose ?></td>
                                <td><?php echo number_format($amount, 2) ?></td>
                                <td><?php echo $tenure ?> Month</td>
                                <td><?php echo $interest ?>%</td>
                                <td><?php echo $totalinterest ?></td>
                                <td><?php echo $monthlyinterest ?></td>
                                <td><?php echo $totalpayment ?></td>
                                <td><?php echo $monthlypayment ?></td>


                              </tr>
                            <?php
                            }
                            ?>
                          </tbody>
                        </table>

                      </div>
                      <div class="tab-pane" id="validID">

                        <div class="row">
                          <?php
                          if (isset($_GET['member_id'])) {
                            $memberID = $_GET['member_id'];
                            $query = mysqli_query($conn, "SELECT member.*, beneficiary.* FROM `member` INNER JOIN beneficiary ON member.member_id = beneficiary.member_id WHERE member.member_id = $memberID");
                            while ($result = mysqli_fetch_array($query)) {
                              extract($result);
                          ?>
                              <div class="col-md-6">
                                <a class="image-popup-vertical-fit" href="../image/member/ID/<?php echo $mvalidID ?>">
                                  <img src="../image/member/ID/<?php echo $mvalidID ?>" alt="user-avatar" class="img-fluid profile-img" style="width:100% !important; height:240px !important;border-radius:10px !important">
                                </a>
                              </div>
                              <div class="col-md-6">
                                <a class="image-popup-vertical-fit" href="../image/beneficiary/ID/<?php echo $bvalidID ?>">
                                  <img src="../image/beneficiary/ID/<?php echo $bvalidID ?>" alt="user-avatar" class="img-fluid profile-img" style="width:100% !important; height:240px !important;border-radius:10px !important">
                                </a>
                              </div>
                          <?php

                            }
                          }
                          ?>

                        </div>

                      </div>

                    </div>

                  </div>
                  <div class="modal fade" id="modal-viewinvoice">
                    <div class="modal-dialog piedad" style="max-width: 365px  !important;">
                      <form id="confirmationreference">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h4 class="modal-title">Funds Receipt</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body" id="invoiceContent">
                            <div class="invoice p-3 mb-3">
                              <!-- Header Section -->
                              <div class="row">
                                <div class="col-12 text-left">
                                  <strong>
                                    <h5>Pineapple Growers and Farmer's Association</h5>
                                  </strong>
                                </div>
                              </div>

                              <!-- Invoice Details -->
                              <div class="row my-3 mt-0 mb-0">
                                <div class="col-6">
                                  <p>Invoice Date: <span id="date"></span></p>
                                  <p>OR No: <span id="invoice_number"></span></p>
                                </div>
                              </div>

                              <!-- Billing Information -->
                              <div class="row border-bottom pb-3 mb-3">
                                <div class="col-12 text-left">
                                  <address>
                                    <strong>From:</strong><br>
                                    Pineapple Growers and Farmer's Association<br>
                                    P-7 Sering Basilisa, Dinagat Islands<br>
                                    Philippines
                                  </address>
                                </div>

                                <div class="col-12">
                                  <address>
                                    <strong>Billed To:</strong><br>
                                    <span id="mname"></span><br>
                                    <span id="maddress"></span><br>
                                    <span id="mcontact"></span>
                                  </address>
                                </div>
                              </div>



                              <div class="row">
                                <div class="col-12">
                                  <strong class="d-flex labelpayment" style="gap: 1px;">
                                    <h5 class="labelpayment">Payment For</h5>
                                    <h5 id="type"></h5>
                                  </strong>
                                </div>

                              </div>

                              <div class="row">
                                <div class="col-12">
                                  <div class="d-flex">
                                    <p>Amount:</p>
                                    <p><strong id="mshares"></strong></p>
                                  </div>
                                </div>
                              </div>

                              <!-- Footer Message -->
                              <div class="row mt-4">
                                <div class="col-12 text-center">
                                  <p>Thank you! We appreciate your trust in us and look forward to serving you again.</p>
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-default" onclick="printInvoice()">
                              <i class="fas fa-print"></i> Print
                            </button>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>

                  <div class="modal fade" id="modal-paidviewinvoice">
                    <div class="modal-dialog piedad" style="max-width: 365px  !important;">
                      <form id="confirmationreference">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h4 class="modal-title">Payment Receipt</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body" id="printPaidInvoice">
                            <div class="invoice p-3 mb-3">
                              <!-- Header Section -->
                              <div class="row">
                                <div class="col-12 text-left">
                                  <strong>
                                    <h5>Pineapple Growers and Farmer's Association</h5>
                                  </strong>
                                </div>
                              </div>

                              <!-- Invoice Details -->
                              <div class="row my-3 mt-0 mb-0">
                                <div class="col-6">
                                  <p>Invoice Date: <span id="paymentDueDate"></span></p>
                                  <p>OR No: <span id="invoiceNumber"></span></p>
                                </div>
                              </div>

                              <!-- Billing Information -->
                              <div class="row border-bottom pb-3 mb-3">
                                <div class="col-12 text-left">
                                  <address>
                                    <strong>From:</strong><br>
                                    Pineapple Growers and Farmer's Association<br>
                                    P-7 Sering Basilisa, Dinagat Islands<br>
                                    Philippines
                                  </address>
                                </div>

                                <div class="col-12">
                                  <address>
                                    <strong>Billed To:</strong><br>
                                    <span id="mnames"></span><br>
                                    <span id="maddresss"></span><br>
                                    <span id="mcontacts"></span>
                                  </address>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-12">
                                  <strong class="d-flex labelpayment" style="gap: 1px;">
                                    <h5 class="labelpayment">Payment For</h5>
                                    <h5 id="types"></h5>
                                  </strong>
                                </div>

                              </div>
                              <div class="row">
                                <div class="col-12">
                                  <div class="d-flex">
                                    <p>Due Date:</p>
                                    <p id="duedate"></p>
                                  </div>
                                  <div class="d-flex">
                                    <p>Amount:</p>
                                    <p><strong id="monthlypayments"></strong></p>
                                  </div>
                                </div>
                              </div>

                              <!-- Footer Message -->
                              <div class="row mt-4">
                                <div class="col-12 text-center">
                                  <p>Thank you! We appreciate your trust in us and look forward to serving you again.</p>
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-default" onclick="printPaidInvoice()">
                              <i class="fas fa-print"></i> Print
                            </button>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>

              </div>

            </div>
          </div>





        </div>

      </section>

    </div>



    <footer class="main-footer">
    </footer>
    <aside class="control-sidebar control-sidebar-dark">
    </aside>
  </div>
  <?php include 'includes/script.php' ?>
  <script>
    $(document).ready(function() {
      $('.image-popup-vertical-fit').magnificPopup({
        type: 'image',
        closeOnContentClick: true,
        mainClass: 'mfp-img-mobile',
        image: {
          verticalFit: true
        }
      });

      $("#example2").DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "searching": true,
        "ordering": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print"]
      }).buttons().container().appendTo('#example2_wrapper .col-md-6:eq(0)');

      $("#example3").DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "searching": true,
        "ordering": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print"]
      }).buttons().container().appendTo('#example3_wrapper .col-md-6:eq(0)');
      $("#example4").DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "searching": true,
        "ordering": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print"]
      }).buttons().container().appendTo('#example4_wrapper .col-md-6:eq(0)');


    });
  </script>

</body>

</html>