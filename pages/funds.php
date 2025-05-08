<?php include '../inc/session.php'?>
<!DOCTYPE html>
<html lang="en">

<head>

  <head>
    <?php include 'includes/link.php' ?>
  </head>
</head>
<style>
  #invoiceContent p {
    margin: 0;
    font-size: 13px;
  }

  #invoiceContent h5 {
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
      $query = mysqli_query($conn, "SELECT member.*, beneficiary.* FROM `member` INNER JOIN beneficiary ON member.member_id = beneficiary.member_id WHERE member.member_id = $member_id");
      $result = mysqli_fetch_array($query);
      extract($result);
    }

    ?>

    <div class="content-wrapper">
      <section class="content Pages">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-3 col-sm-6 col-12">
              <div class="info-box">
                <span class="info-box-icon bg-success"><i class="fa-solid fa-sack-dollar"></i></span>
                <?php
                $query = mysqli_query($conn, "SELECT SUM(mshare) AS total_share FROM share WHERE `member_id` = $_GET[member_id]");
                if ($query) {
                  $result = mysqli_fetch_assoc($query);
                  $total_share = isset($result['total_share']) ? $result['total_share'] : 0.00;
                } else {
                  $total_share = 0.00;
                }
                ?>
                <div class="info-box-content">
                  <span class="info-box-text">Total Shares</span>
                  <span class="info-box-number"><?php echo number_format($total_share, 2); ?></span>
                </div>
              </div>

            </div>
          </div>
          <div class="row">
            <div class="col-12">

              <div class="card">
                <div class="card-header">
                  <div class="card-title float-left">
                    <h3><?php echo $mname ?> Shares</h3>
                  </div>
                  <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#modal-addfunds">
                    <i class="fa-solid fa-plus"></i>
                    Share Amount
                  </button>
                </div>


                <div class="card-body">
                  <table id="example1" class="table table-striped table-bordered">
                    <thead>
                      <tr>
                        <th style="width: 20%;">OR No.</th>
                        <th style="width: 20%;">Share Amount</th>
                        <th style="width: 20%;">Type</th>
                        <th style="width: 20%;">Date</th>
                        <th style="width: 20%;"></th>
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
                          <td class="text-center">
                            <button class="btn btn-info btn-sm" id="EDITFUNDS" data-share-id="<?php echo $share_id; ?>" data-toggle="modal" data-target="#modal-updatefunds" <?php echo $isMostRecent ? '' : 'disabled'; ?>>
                              <i class="fa-solid fa-user-pen"></i> Edit
                            </button>
                            <button class="btn btn-primary btn-sm" id="viewreciept"
                              data-share-id="<?php echo $share_id; ?>"
                              data-toggle="modal" data-target="#modal-viewinvoice">
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

                <div class="modal fade" id="modal-addfunds">
                  <div class="modal-dialog" style="max-width: 400px;">
                    <form id="ADDNEWFUNDS">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h4 class="modal-title">Add Share Amount</h4>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <label>Capital Amount</label>
                          <input type="hidden" name="member_id" value="<?php echo $_GET['member_id'] ?>">
                          <input name="mshare" type="number" class="form-control" placeholder="Enter your share amount" required>
                        </div>
                        <div class="modal-footer justify-content-between">
                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                          <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                      </div>
                    </form>

                  </div>

                </div>


                <div class="modal fade" id="modal-updatefunds">
                  <div class="modal-dialog" style=" max-width: 400px;">
                    <form id="EDITFUNDSFORM">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h4 class="modal-title">Update Share Amount</h4>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <label>Capital Amount</label>
                          <input type="hidden" name="shareID" id="shareID">
                          <input name="mshare" id="mshare" type="number" class="form-control" placeholder="Enter your share amount" required>
                        </div>
                        <div class="modal-footer justify-content-between">
                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                          <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                      </div>
                    </form>

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
      $('#next-to-beneficiary').on('click', function() {
        $('#memberform').removeClass('active');
        $('#beneficiaryform').addClass('active');
      });

      $('#back-to-member').on('click', function() {
        $('#beneficiaryform').removeClass('active');
        $('#memberform').addClass('active');
      });


      $('#next-to-beneficiary-update').on('click', function() {
        $('#memberform-update').removeClass('active');
        $('#beneficiaryform-update').addClass('active');
      });

      $('#back-to-member-update').on('click', function() {
        $('#beneficiaryform-update').removeClass('active');
        $('#memberform-update').addClass('active');
      });
    });
  </script>
</body>

</html>