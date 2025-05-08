<?php include '../inc/session.php'?>
<!DOCTYPE html>
<html lang="en">

<head>

  <head>
    <?php include 'includes/link.php' ?>
  </head>
</head>

<body class="hold-transition sidebar-mini" id="tenantlist">
  <div class="wrapper">
    <?php include 'includes/sidebar.php' ?>
    <?php
    // if (isset($_GET['member_id']) && $_GET['loan_id']) {
    //   $query = mysqli_query($conn, "SELECT monthly_payment.*, member.* FROM `member` INNER JOIN `monthly_payment` ON member.member_id = monthly_payment.member_id WHERE  member.member_id = $member_id AND loan_id = $loan_id");
    //   $result = mysqli_fetch_array($query);
    //   extract($result);
    // }
    // 
    ?>

    <div class="content-wrapper">
      <section class="content Pages">
        <div class="container-fluid">

          <div class="row">
            <div class="col-md-3">


              <div class="card card-primary card-outline">
                <div class="card-body box-profile">
                <ul class="nav nav-pills">
                <?php
                    $query = mysqli_query($conn, "SELECT DISTINCT `loanstarted` FROM `payment_history` ORDER BY `loanstarted` DESC");
                    while ($result = mysqli_fetch_array($query)) {
                      extract($result);
                    ?>
                      <li class="nav-item"><a class="nav-link " href="#unpaid" data-toggle="tab">Unpaid</a></li>
                    <?php   } ?>
                    
                   
                  </ul>

                

                </div>

              </div>

            </div>

            <div class="col-md-9">
              <div class="card">
                <div class="card-body">
                  <div class="tab-content">


                    <div class="tab-pane active" id="unpaid">
                      <div class="table-responsive" style="max-height: 38rem;overflow-y: scroll;">

                      </div>

                    </div>
                    <div class="tab-pane" id="paymenthistory">
                      <div class="table-responsive" style="max-height: 38rem;overflow-y: scroll;">

                      </div>

                    </div>



                  </div>

                </div>

                <div class="modal fade" id="modal-paymentreference">
                  <div class="modal-dialog piedad">
                    <form id="paymentreference" action="../inc/controller.php" method="POST">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h4 class="modal-title">Payment</h4>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <input type="hidden" id="monthly_payment_id" name="monthly_payment_id">
                          <input type="hidden" id="monthlyinterest" name="monthlyinterest">
                          <input type="hidden" id="loan_id" name="loan_id">
                          <div class="form-group">
                            <label>Amount:</label>
                            <input type="text" class="form-control" id="monthlypayment" name="monthlypayment" required readonly>
                          </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                          <button type="submit" name="paymentreference" class="btn btn-primary">Submit Payment</button>
                        </div>
                      </div>
                    </form>

                  </div>

                </div>
                <div class="modal fade" id="modal-confirmationreference">
                  <div class="modal-dialog piedad">
                    <form id="confirmationreference">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h4 class="modal-title">Reference Number</h4>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <input type="hidden" id="memberview" name="member_id">
                          <input type="text" class="form-control" placeholder="Enter Reference Payment" name="reference_payment" required>
                        </div>
                        <div class="modal-footer justify-content-between">
                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                          <button type="submit" class="btn btn-primary">Save changes</button>
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
      $('.image-popup-vertical-fit').magnificPopup({
        type: 'image',
        closeOnContentClick: true,
        mainClass: 'mfp-img-mobile',
        image: {
          verticalFit: true
        }

      });
      $('ul.nav-pills li:first-child a').addClass('active');


    });
  </script>



</body>

</html>