<?php include '../inc/session.php' ?>
<!DOCTYPE html>
<html lang="en">

<head>

  <head>
    <?php include 'includes/link.php' ?>
  </head>
</head>
<style>
  .col-md-3.col-sm-6.col-12 {
    cursor: pointer !important;
  }
</style>

<body class="hold-transition sidebar-mini" id="tenantlist">
  <div class="wrapper">
    <?php include 'includes/sidebar.php' ?>


    <div class="content-wrapper">
      <section class="content Pages">
        <div class="container-fluid">

          <div class="row">
            <div class="col-md-3 col-sm-6 col-12">
              <div class="info-box" id="AllCountBox">
                <span class="info-box-icon bg-success"><i class="fa-solid fa-user-group"></i></span>
                <?php
                $sql = "SELECT COUNT(*) AS total_member FROM `member` WHERE `mstatus` IN (1, 0)";
                $query = $conn->query($sql);
                if ($query) {
                  $result = $query->fetch_assoc();
                  $total_member = $result['total_member'];

                ?>
                  <div class="info-box-content">
                    <span class="info-box-text">Total Members</span>
                    <span class="info-box-number"><?php echo $total_member ?></span>
                  </div>
                <?php } ?>
              </div>
            </div>

            <div class="col-md-3 col-sm-6 col-12">
              <div class="info-box" id="maleCountBox">
                <span class="info-box-icon bg-success"><i class="fa-solid fa-person"></i></span>
                <?php
                $sql = "SELECT COUNT(*) AS total_male FROM `member` WHERE `mgender` = 'Male' AND `mstatus` IN (1, 0)";
                $query = $conn->query($sql);
                if ($query) {
                  $result = $query->fetch_assoc();
                  $total_male = $result['total_male'];

                ?>
                  <div class="info-box-content">
                    <span class="info-box-text">Total Male</span>
                    <span class="info-box-number"><?php echo $total_male ?></span>
                  </div>
                <?php } ?>
              </div>
            </div>


            <div class="col-md-3 col-sm-6 col-12">
              <div class="info-box" id="femaleCountBox">
                <span class="info-box-icon bg-success"><i class="fa-solid fa-person-dress"></i></span>
                <?php
                $sql = "SELECT COUNT(*) AS total_female FROM `member` WHERE `mgender` = 'Female' AND `mstatus` IN (1, 0)";
                $query = $conn->query($sql);
                if ($query) {
                  $result = $query->fetch_assoc();
                  $total_female = $result['total_female'];

                ?>
                  <div class="info-box-content">
                    <span class="info-box-text">Total Female</span>
                    <span class="info-box-number"><?php echo $total_female ?></span>
                  </div>
                <?php } ?>
              </div>
            </div>


          </div>
          <div class="row">
            <div class="col-12">

              <div class="card">
                <div class="card-header">
                  <div class="card-title float-left">
                    <h3>Member List</h3>
                  </div>
                  <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#modal-register">
                    <i class="fa-solid fa-user-plus"></i>
                    Register Member
                  </button>
                </div>


                <div class="card-body">
                  <table id="example1" class="table table-striped table-bordered">
                    <thead>
                      <tr>
                        <!-- <th>Reference No.</th> -->
                        <th>Full Name</th>
                        <th>Gender</th>
                        <th>Contact No.</th>
                        <th>Address</th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $display_member = display_member($conn);
                      while ($result = mysqli_fetch_array($display_member)) {
                        extract($result);
                      ?>
                        <tr class="member-row" data-mgender="<?php echo $mgender; ?>">
                          <td><?php echo $mname ?></td>
                          <td><?php echo $mgender ?></td>
                          <td><?php echo $mcontact ?></td>
                          <td><?php echo $maddress ?></td>

                          <td class="text-center">
                            <button class="btn btn-success btn-sm" id="viewfundsBTN" data-member-id="<?php echo $member_id; ?>" data-toggle="modal" data-target="#modal-confirmationViewfunds" ?>
                              <i class="fa-solid fa-sack-dollar"></i> Funds
                            </button>
                            <a class="btn btn-primary btn-sm" href="member-profile.php?member_id=<?php echo $member_id ?>">
                              <i class="fa-solid fa-address-card"></i> View
                            </a>
                            <button class="btn btn-info btn-sm" id="EDITMEMBER" data-member-id="<?php echo $member_id; ?>" data-toggle="modal" data-target="#modal-register-update">
                              <i class="fa-solid fa-user-pen"></i> Edit
                            </button>
                            <!-- Disable the delete button if mstatus is not 0 -->
                            <button class="btn btn-danger btn-sm removemember" data-member-id="<?php echo $member_id; ?>" <?php echo ($mstatus != 0) ? 'disabled' : ''; ?>>
                              <i class="fa-solid fa-user-xmark"></i> Delete
                            </button>
                          </td>
                        </tr>
                      <?php
                      }
                      ?>
                    </tbody>
                  </table>
                </div>

                <div class="modal fade" id="modal-register">
                  <div class="modal-dialog" style="max-width: 600px !important;">
                    <form id="REGISTERMEMBER" class="form-horizontal">
                      <div class="tab-content">
                        <div class="active tab-pane" id="memberform">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h4 class="modal-title">Register Member</h4>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body" style="padding-top:0; padding-bottom:0;">
                              <div class="card-body">
                                <div class="form-group row">
                                  <label class="col-sm-3 col-form-label">Full Name</label>
                                  <div class="col-sm-9">
                                    <input type="text" class="form-control" name="mname" placeholder="Enter your Name" required>
                                  </div>
                                </div>
                                <div class="form-group row">
                                  <label class="col-sm-3 col-form-label">Gender</label>
                                  <div class="col-sm-9">
                                    <select name="mgender" class="form-control custom-select" required>
                                      <option selected disabled>Select one</option>
                                      <option>Male</option>
                                      <option>Female</option>
                                    </select>
                                  </div>
                                </div>
                                <div class="form-group row">
                                  <label class="col-sm-3 col-form-label">Contact No:</label>
                                  <div class="col-sm-9">
                                    <input name="mcontact" type="tel" placeholder="Enter Contact No." class="form-control" maxlength="11" pattern="\d{11}" title="Please enter a valid contact number." required>
                                  </div>
                                </div>
                                <div class="form-group row">
                                  <label class="col-sm-3 col-form-label">Date of Birth</label>
                                  <div class="col-sm-9">
                                    <input name="mbdate" type="date" class="form-control" required>
                                  </div>
                                </div>
                                <div class="form-group row">
                                  <label class="col-sm-3 col-form-label">Address</label>
                                  <div class="col-sm-9">
                                    <input name="maddress" type="text" class="form-control" placeholder="Enter your Address" required>
                                  </div>
                                </div>
                                <div class="form-group row">
                                  <label class="col-sm-3 col-form-label">Capital Amount</label>
                                  <div class="col-sm-9">
                                    <input name="mshare" type="number" class="form-control" placeholder="Enter your share amount" required>
                                  </div>
                                </div>
                                <div class="form-group row">
                                  <label class="col-sm-3 col-form-label">Profile Picture</label>
                                  <div class="col-sm-9">
                                    <div class="custom-file">
                                      <input name="mprofile" type="file" accept=".jpeg, .jpg, .png" class="custom-file-input" required>
                                      <label class="custom-file-label">Choose Profile</label>
                                    </div>
                                  </div>
                                </div>
                                <div class="form-group row">
                                  <label class="col-sm-3 col-form-label">Valid ID</label>
                                  <div class="col-sm-9">
                                    <div class="custom-file">
                                      <input name="mvalidID" type="file" accept=".jpeg, .jpg, .png" class="custom-file-input" required>
                                      <label class="custom-file-label">Choose ValidID</label>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="modal-footer justify-content-between">
                              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                              <button type="button" class="btn btn-primary" id="next-to-beneficiary">Next</button>
                            </div>
                          </div>
                        </div>

                        <div class="tab-pane" id="beneficiaryform">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h4 class="modal-title">Register Beneficiary</h4>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body" style="padding-top:0; padding-bottom:0;">
                              <div class="card-body">
                                <div class="form-group row">
                                  <label class="col-sm-3 col-form-label">Full Name</label>
                                  <div class="col-sm-9">
                                    <input type="text" class="form-control" name="bname" placeholder="Enter your Name" required>
                                  </div>
                                </div>
                                <div class="form-group row">
                                  <label class="col-sm-3 col-form-label">Gender</label>
                                  <div class="col-sm-9">
                                    <select name="bgender" class="form-control custom-select" required>
                                      <option selected disabled>Select one</option>
                                      <option>Male</option>
                                      <option>Female</option>
                                    </select>
                                  </div>
                                </div>
                                <div class="form-group row">
                                  <label class="col-sm-3 col-form-label">Contact No:</label>
                                  <div class="col-sm-9">
                                    <input name="bcontact" type="tel" placeholder="Enter Contact No." class="form-control" maxlength="11" pattern="\d{11}" title="Please enter a valid contact number." required>
                                  </div>
                                </div>
                                <div class="form-group row">
                                  <label class="col-sm-3 col-form-label">Date of Birth</label>
                                  <div class="col-sm-9">
                                    <input name="bdate" type="date" class="form-control" required>
                                  </div>
                                </div>
                                <div class="form-group row">
                                  <label class="col-sm-3 col-form-label">Address</label>
                                  <div class="col-sm-9">
                                    <input name="baddress" type="text" class="form-control" placeholder="Enter your Address" required>
                                  </div>
                                </div>
                                <div class="form-group row">
                                  <label class="col-sm-3 col-form-label">Relationship</label>
                                  <div class="col-sm-9">
                                    <input name="brelation" type="text" class="form-control" placeholder="Enter your Relationship to Member" required>
                                  </div>
                                </div>
                                <div class="form-group row">
                                  <label class="col-sm-3 col-form-label">Profile Picture</label>
                                  <div class="col-sm-9">
                                    <div class="custom-file">
                                      <input name="bprofile" type="file" accept=".jpeg, .jpg, .png" class="custom-file-input" required>
                                      <label class="custom-file-label">Choose Profile</label>
                                    </div>
                                  </div>
                                </div>
                                <div class="form-group row">
                                  <label class="col-sm-3 col-form-label">Valid ID</label>
                                  <div class="col-sm-9">
                                    <div class="custom-file">
                                      <input name="bvalidID" type="file" accept=".jpeg, .jpg, .png" class="custom-file-input" required>
                                      <label class="custom-file-label">Choose ValidID</label>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="modal-footer justify-content-between">
                              <button type="button" class="btn btn-default" id="back-to-member">Back</button>
                              <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                          </div>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>

                <div class="modal fade" id="modal-register-update">
                  <div class="modal-dialog" style="max-width: 600px !important;">
                    <form id="UPDATEMEMBER" class="form-horizontal">
                      <div class="tab-content">
                        <div class="active tab-pane" id="memberform-update">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h4 class="modal-title">Update Member</h4>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body" style="padding-top:0; padding-bottom:0;">
                              <div class="card-body">
                                <div class="form-group row">
                                  <label class="col-sm-3 col-form-label">Full Name</label>
                                  <div class="col-sm-9">
                                    <input type="hidden" name="memberID" id="memberID">
                                    <input type="text" class="form-control" name="mname" id="mname" placeholder="Enter your Name" required>
                                  </div>
                                </div>
                                <div class="form-group row">
                                  <label class="col-sm-3 col-form-label">Gender</label>
                                  <div class="col-sm-9">
                                    <select name="mgender" id="mgender" class="form-control custom-select" required>
                                      <option selected disabled>Select one</option>
                                      <option>Male</option>
                                      <option>Female</option>
                                    </select>
                                  </div>
                                </div>
                                <div class="form-group row">
                                  <label class="col-sm-3 col-form-label">Contact No:</label>
                                  <div class="col-sm-9">
                                    <input name="mcontact" id="mcontact" type="tel" placeholder="Enter Contact No." class="form-control" maxlength="11" pattern="\d{11}" title="Please enter a valid contact number." required>
                                  </div>
                                </div>
                                <div class="form-group row">
                                  <label class="col-sm-3 col-form-label">Date of Birth</label>
                                  <div class="col-sm-9">
                                    <input name="mbdate" id="mbdate" type="date" class="form-control" required>
                                  </div>
                                </div>
                                <div class="form-group row">
                                  <label class="col-sm-3 col-form-label">Address</label>
                                  <div class="col-sm-9">
                                    <input name="maddress" id="maddress" type="text" class="form-control" placeholder="Enter your Address" required>
                                  </div>
                                </div>

                                <div class="form-group row">
                                  <label class="col-sm-3 col-form-label">Profile Picture</label>
                                  <div class="col-sm-9">
                                    <div class="custom-file">
                                      <input name="mprofile" id="mprofile" type="file" accept=".jpeg, .jpg, .png" class="custom-file-input">
                                      <label class="custom-file-label">Choose Profile</label>
                                      <input type="hidden" id="current_mprofile" name="current_mprofile" value="<?php echo $mprofile ?>">
                                    </div>
                                  </div>
                                </div>
                                <div class="form-group row">
                                  <label class="col-sm-3 col-form-label">Valid ID</label>
                                  <div class="col-sm-9">
                                    <div class="custom-file">
                                      <input name="mvalidID" id="mvalidID" type="file" accept=".jpeg, .jpg, .png" class="custom-file-input">
                                      <label class="custom-file-label">Choose ValidID</label>
                                      <input type="hidden" id="current_mvalidID" name="current_mvalidID" value="<?php echo $mprofile ?>">
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="modal-footer justify-content-between">
                              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                              <button type="button" class="btn btn-primary" id="next-to-beneficiary-update">Next</button>
                            </div>
                          </div>
                        </div>

                        <div class="tab-pane" id="beneficiaryform-update">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h4 class="modal-title">Update Beneficiary</h4>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body" style="padding-top:0; padding-bottom:0;">
                              <div class="card-body">
                                <div class="form-group row">
                                  <label class="col-sm-3 col-form-label">Full Name</label>
                                  <div class="col-sm-9">
                                    <input type="text" class="form-control" name="bname" id="bname" placeholder="Enter your Name" required>
                                  </div>
                                </div>
                                <div class="form-group row">
                                  <label class="col-sm-3 col-form-label">Gender</label>
                                  <div class="col-sm-9">
                                    <select name="bgender" id="bgender" class="form-control custom-select" required>
                                      <option selected disabled>Select one</option>
                                      <option>Male</option>
                                      <option>Female</option>
                                    </select>
                                  </div>
                                </div>
                                <div class="form-group row">
                                  <label class="col-sm-3 col-form-label">Contact No:</label>
                                  <div class="col-sm-9">
                                    <input name="bcontact" id="bcontact" type="tel" placeholder="Enter Contact No." class="form-control" maxlength="11" pattern="\d{11}" title="Please enter a valid contact number." required>
                                  </div>
                                </div>
                                <div class="form-group row">
                                  <label class="col-sm-3 col-form-label">Date of Birth</label>
                                  <div class="col-sm-9">
                                    <input name="bdate" id="bdate" type="date" class="form-control" required>
                                  </div>
                                </div>
                                <div class="form-group row">
                                  <label class="col-sm-3 col-form-label">Address</label>
                                  <div class="col-sm-9">
                                    <input name="baddress" id="baddress" type="text" class="form-control" placeholder="Enter your Address" required>
                                  </div>
                                </div>
                                <div class="form-group row">
                                  <label class="col-sm-3 col-form-label">Relationship</label>
                                  <div class="col-sm-9">
                                    <input name="brelation" id="brelation" type="text" class="form-control" placeholder="Enter your Relationship to Member" required>
                                  </div>
                                </div>
                                <div class="form-group row">
                                  <label class="col-sm-3 col-form-label">Profile Picture</label>
                                  <div class="col-sm-9">
                                    <div class="custom-file">
                                      <input name="bprofile" id="bprofile" type="file" accept=".jpeg, .jpg, .png" class="custom-file-input">
                                      <label class="custom-file-label">Choose Profile</label>
                                      <input type="hidden" name="current_bprofile" id="current_bprofile" value="<?php echo $bprofile ?>">
                                    </div>
                                  </div>
                                </div>
                                <div class="form-group row">
                                  <label class="col-sm-3 col-form-label">Valid ID</label>
                                  <div class="col-sm-9">
                                    <div class="custom-file">
                                      <input name="bvalidID" id="bvalidID" type="file" accept=".jpeg, .jpg, .png" class="custom-file-input">
                                      <label class="custom-file-label">Choose ValidID</label>
                                      <input type="hidden" name="current_bvalidID" id="current_bvalidID" value="<?php echo $bvalidID ?>">
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="modal-footer justify-content-between">
                              <button type="button" class="btn btn-default" id="back-to-member-update">Back</button>
                              <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                          </div>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>


                <div class="modal fade" id="modal-confirmationDelete">
                  <div class="modal-dialog piedad">
                    <form id="confirmationDeleteMember">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h4 class="modal-title">Confirm Password</h4>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <input type="password" class="form-control" placeholder="Enter Password" name="admin_pass" required="">
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



      $('#maleCountBox').on('click', function() {
        $('.member-row').show();
        $('.member-row').filter(function() {
          return $(this).data('mgender') !== 'Male';
        }).hide();
      });


      $('#femaleCountBox').on('click', function() {
        $('.member-row').show();
        $('.member-row').filter(function() {
          return $(this).data('mgender') !== 'Female';
        }).hide();
      });


      $('#AllCountBox').on('click', function() {

        $('.member-row').show();

      });



    });
  </script>
</body>

</html>