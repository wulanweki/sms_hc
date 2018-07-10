<style>
  .input-group{
    padding-bottom: 5px;
  }

  .hiddenRow {
    padding: 0 !important;
  }

  .modal {
        display:    none;
        position:   fixed;
        z-index:    1000;
        top:        0;
        left:       0;
        height:     100%;
        width:      100%;
        background: rgba( 255, 255, 255, .8 ) 
                    url('assets/img/Preloader_6.gif') 
                    50% 50% 
                    no-repeat;
    }

    body.loading {
        overflow: hidden;   
    }

    body.loading .modal {
        display: block;
    }
</style>

<div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="panel panel-default">
        <!-- Default panel contents -->
          <div class="panel-heading"><span class="glyphicon glyphicon-home" aria-hidden="true"></span><b> Add Candidate</b></div>
          <div class="panel-body">
            <div class="col-md-6">
              <form id="frmSave">
                <div class="form-group">
                  <div class="input-group">
                    <div class="row-fluid">
                      <select name="source" id="source" class="selectpicker" data-show-subtext="true" data-live-search="true" onchange="setsource(this)">
                        <option data-subtext="Select One" value="0">Source From</option>;
                        <option data-subtext="" value="1">External Resource</option>
                        <option data-subtext="" value="2">Internal Resource</option>
                      </select>
                    </div>
                  </div>
                  <!-- <div class="radio">
                    <div class="col-md-6">
                      <label><input type="radio" name="source" id="source" value="1">External Resource</label>
                    </div>
                    <div class="col-md-6">
                      <label><input type="radio" name="source" id="source" value="2">Internal Resource</label>
                    </div>
                    <br>
                  </div> -->
                </div>
                
                <div class="form-group" id="iSource" style="display:none;">
                  <div class="input-group">
                  <div class="row-fluid">
                    <select name="employee" id="employee" class="selectpicker" data-show-subtext="true" data-live-search="true">
                        <option data-subtext="Select one" value="0">Employee</option>
                        <?php
                        $sqlEmployee = "SELECT nama, nik FROM tb_datapribadi WHERE resign = 'N' AND atasan1 <> '0000000' ORDER BY nama";
                        $dataEmployee = $conn->query($sqlEmployee);

                        if ($dataEmployee->num_rows > 0) {
                          while($rowEmployee = $dataEmployee->fetch_assoc()) {
                        ?>
                            <option data-subtext="<?php echo $rowEmployee["nik"] ?>" value="<?php echo $rowEmployee["nik"] ?>"><?php echo $rowEmployee["nama"] ?></option>
                        <?php
                          }
                        } 
                        ?>
                      </select>
                    </div>
                  </div>
                </div>

                <div class="form-group" id="eSource">
                  <div class="input-group">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>    
                    <input type="hidden" name="req_id" id="req_id" class="form-control" placeholder="req_id" required value="<?php echo $_GET["idReq"] ?>">
                    <input type="hidden" name="typeSave" id="typeSave" class="form-control" value="addCandidate">
                    <input type="hidden" name="userLogin" id="userLogin" class="form-control" value="<?php echo $_SESSION["user"] ?>">
                    <input type="text" name="name" id="name" class="form-control" placeholder="Name" required >
                  </div>
                  <div class="input-group">
                    <div class="radio">
                      <div class="col-md-6">
                        <label><input type="radio" name="gender" id="gender" value="1">Male</label>
                      </div>
                      <div class="col-md-6">
                        <label><input type="radio" name="gender" id="gender" value="2">Female</label>
                      </div>
                      <br>
                    </div>
                  </div>
                  <div class="input-group">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>    
                    <input type="mail" name="email" id="email" class="form-control" placeholder="Email" required>
                  </div>
                  <div class="input-group">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-phone"></span></span>    
                    <input type="text" name="phone" id="phone" class="form-control" placeholder="Mobile Phone">
                  </div>
                  <div class="input-group">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-home"></span></span>    
                    <textarea class="form-control" name="address" id="address" cols="30" rows="3" placeholder="Address"></textarea>
                  </div>
                </div>
                <div class="form-group">
                  <div class="input-group">
                    <label for="cv">Curiculum Vitae (optional)</label>
                    <input type="file" id="cv" name="cv">
                    <p class="help-block">Upload CV File (.doc, .docx, .pdf only).</p>
                  </div>
                </div>
                <!-- <div id="preview"><img src="no-image.jpg" /></div> -->
                <hr>
                <div class="input-group">
                  <button id="saveCandidate" type="button" class="btn btn-info" aria-haspopup="true">Save</button>
                </div>
              </form>
            </div>

            <div class="col-md-6">
              <?php
              $sqlRequest = "SELECT a.id, DATE_FORMAT(a.req_date, '%d-%M-%Y') req_date, a.req_number, a.detail_pos, a.qty, DATE_FORMAT(a.deadline, '%d-%M-%Y') deadline, a.status, b.nama_div_ext, c.nama, d.jabatan, a.sfpt,
                          (SELECT COUNT(id) FROM sm_hc_candidate WHERE req_id = a.id) candidate
                          FROM sm_hc_request a
                          LEFT JOIN tbldivmaster b ON a.division = b.id
                          LEFT JOIN tb_datapribadi c ON a.pic = c.nik
                          LEFT JOIN tb_jabatan d ON a.position = d.id
                          WHERE a.id = ".$_GET["idReq"]." LIMIT 1";
              $dataRequest = $conn->query($sqlRequest);

              if ($dataRequest->num_rows > 0) {
                while($rowRequest = $dataRequest->fetch_assoc()) {
              ?>
                <p>
                  <small>Request Number</small><br>
                  <label><?php echo $rowRequest["req_number"] ?></label>
                </p>
                <p>
                  <small>Request Date</small><br>
                  <label><?php echo $rowRequest["req_date"] ?></label>
                </p>
                <p>
                  <small>PIC</small><br>
                  <label><?php echo $rowRequest["nama"] ?></label> <i><small><?php echo $rowRequest["nama_div_ext"] ?></small></i>
                </p>
                <p>
                  <small>For Position</small><br>
                  <label><?php echo $rowRequest["jabatan"] ?></label>
                </p>
                <p>
                  <small>Additional Request</small><br>
                  <label><?php echo $rowRequest["detail_pos"] ?></label>
                </p>
                <p>
                  <small>Deadline</small><br>
                  <label style="color:red;"><?php echo $rowRequest["deadline"] ?></label>
                </p>
                <p name="set">
                  <small>Standard for Practical Test</small>
                  <div class="input-group col-md-3">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-pencil"></span></span>
                    <input type="text" name="standardPT" id="standardPT" class="form-control" placeholder="" maxlength="6" value="<?php echo $rowRequest["sfpt"] ?>">
                  </div>
                  <div class="input-group col-md-3">
                    <button id="saveSfPT" type="button" class="btn btn-danger" aria-haspopup="true">Set</button>
                  </div>
                </p>
              <?php
                }
              }
              ?>
            </div>
          </div>
          <hr>
          <div class="panel-body">
            <div class="col-md-12">
              <h3 id="cl" name="cl">Candidate List</h3>
              <div class="alert alert-danger" role="alert">
                <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                <span class="sr-only">Error:</span>
                <b>Note : T1 : <i>TPA</i>, T2 : <i>Practical Test</i>, T3 : <i>Interview</i>, T4 : <i>Psikotest</i></b>
              </div>
              <!-- Table -->
              <form id="frmTestResult">
                <table class="table">
                  <thead>
                    <tr>
                      <th>No.</th>
                      <th>Input Date</th>
                      <th>Name</th>
                      <!-- <th>Email</th> -->
                      <!-- <th>Gender</th> -->
                      <!-- <th>Address</th> -->
                      <th>Phone</th>
                      <th>T1</th>
                      <td></td> 
                      <th>T2</th>
                      <td></td> 
                      <th>T3</th>
                      <td></td> 
                      <th>T4</th>
                      <th></th>
                      <th></th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $sqlRequest = "SELECT a.*, DATE_FORMAT(a.created_at,'%d %M %Y %h:%i:%s') created_at,tpa,practical,
                                CASE 
                                  WHEN interview = 0 THEN 'N/A'
                                  WHEN interview = 1 THEN 'P'
                                  WHEN interview = 2 THEN 'R'
                                END Tinterview,
                                CASE 
                                  WHEN psikotest = 0 THEN 'N/A'
                                  WHEN psikotest = 1 THEN 'P'
                                  WHEN psikotest = 2 THEN 'R'
                                END Tpsikotest,
                                CASE WHEN a.gender = 1 THEN 'Male' ELSE 'Female' END gender,
                                b.sfpt,
                                (SELECT count(id) FROM sm_hc_comment WHERE cad_id = a.id) comment
                                FROM sm_hc_candidate a
                                LEFT JOIN sm_hc_request b ON a.req_id = b.id
                                WHERE req_id = ".$_GET["idReq"]."
                                ORDER BY a.created_at DESC";
                    $dataRequest = $conn->query($sqlRequest);

                    if ($dataRequest->num_rows > 0) {
                      $no = 1;
                      while($rowRequest = $dataRequest->fetch_assoc()) {
                    ?>
                    <tr data-toggle="collapse" data-target="#demo<?php echo $no ?>" class="accordion-toggle">
                      <td><?php echo $no ?></td>
                      <td><?php echo $rowRequest["created_at"] ?></td>
                      <td><b>
                        <?php echo $rowRequest["name"] ?><br>
                          <small><a href="mailto:<?php echo $rowRequest["email"] ?>" target="_top"><?php echo $rowRequest["email"] ?></a></small>
                        </b><br>
                        <select name="switch" id="switch" class="selectpicker" data-show-subtext="true" data-live-search="true" onchange="switchto(this)">
                          <option data-subtext="to req ..." value="0">Switch</option>
                          <?php
                          $sqlSwitch = "SELECT a.id, a.req_number, b.nama FROM sm_hc_request a 
                                          LEFT JOIN tb_datapribadi b ON a.pic = b.nik WHERE a.status IN (1) AND a.id <> ".$_GET["idReq"]." ORDER BY a.req_date DESC";
                          $dataSwitch = $conn->query($sqlSwitch);

                          if ($dataSwitch->num_rows > 0) {
                            while($rowSwitch = $dataSwitch->fetch_assoc()) {
                          ?>
                              <option data-subtext="<?php echo $rowSwitch["nama"] ?>" value="<?php echo $rowRequest["id"]."||".$rowSwitch["id"]."||".$rowSwitch["req_number"] ?>"><?php echo $rowSwitch["req_number"] ?></option>
                          <?php
                            }
                          } 
                          ?>
                        </select>
                      </td>
                      <td><?php echo $rowRequest["phone"] ?></td>
                      <?php
                      if($rowRequest["tpa"]<15){
                        echo "<td style=\"background-color:#FF6666\"><b>".$rowRequest["tpa"]."</b></td>";
                      }else{
                        echo "<td style=\"background-color:#66FF66\"><b>".$rowRequest["tpa"]."</b></td>";
                      }
                      ?>
                      <td></td> 
                      <?php
                      if($rowRequest["practical"] < $rowRequest["sfpt"]){
                        echo "<td style=\"background-color:#FF6666\"><b>".$rowRequest["practical"]."</b></td>";
                      }else{
                        echo "<td style=\"background-color:#66FF66\"><b>".$rowRequest["practical"]."</b></td>";
                      }
                      ?>
                      <td></td> 
                      <?php
                      if($rowRequest["Tinterview"] == "R"){
                        echo "<td style=\"background-color:#FF6666\"><b>".$rowRequest["Tinterview"]."</b></td>";
                      }elseif($rowRequest["Tinterview"] == "P"){
                        echo "<td style=\"background-color:#66FF66\"><b>".$rowRequest["Tinterview"]."</b></td>";
                      }else{
                        echo "<td><b>".$rowRequest["Tinterview"]."</b></td>";
                      }
                      ?>
                      <td></td> 
                      <?php
                      if($rowRequest["Tpsikotest"] == "R"){
                        echo "<td style=\"background-color:#FF6666\"><b>".$rowRequest["Tpsikotest"]."</b></td>";
                      }elseif($rowRequest["Tpsikotest"] == "P"){
                        echo "<td style=\"background-color:#66FF66\"><b>".$rowRequest["Tpsikotest"]."</b></td>";
                      }else{
                        echo "<td><b>".$rowRequest["Tpsikotest"]."</b></td>";
                      }
                      ?>
                      <td>    
                        <button id="openInputResult" type="button" class="btn btn-success btn-xs"><b>Input Result</b></button>
                      </td>
                      <td>
                        <?php 
                        if($rowRequest["cvfile"]!=="-"){
                        ?>
                        <a class="btn btn-info btn-xs" target="_blank" role="button" href="files/<?php echo $rowRequest["cvfile"] ?>">CV</a>
                        <?php
                        }
                        ?>
                      </td>
                      <td>
                        <a class="btn btn-danger btn-xs" role="button" href="#" data-toggle="tooltip" title="List of Comment Here" onclick="commentList(<?php echo $rowRequest["id"] ?>)"><span class="glyphicon glyphicon-comment"></span> <?php echo $rowRequest["comment"] ?></a>
                      </td>
                    </tr>
                    <tr >
                      <td colspan="16" class="hiddenRow">
                        <div style="padding-top:10px; padding-bottom:10px;" class="accordian-body collapse" id="demo<?php echo $no ?>"> 
                          <table>
                            <tr>
                              <td>
                                <b>Test Result for <?php echo $rowRequest["name"] ?> : &nbsp;</b>
                                <input type="hidden" name="typeSave" id="typeSave" value="testResult">
                                <input type="hidden" name="userLogin" id="userLogin" value="<?php echo $_SESSION["user"] ?>">
                                <input type="hidden" name="req_id" id="req_id" value="<?php echo $rowRequest["req_id"] ?>">
                                <input type="hidden" name="cad_id[]" id="cad_id" value="<?php echo $rowRequest["id"] ?>">
                                <input type="hidden" name="sfpt[]" id="sfpt" value="<?php echo $rowRequest["sfpt"] ?>">
                              </td>
                              <td>
                                <div class="input-group">
                                  <input type="mail" name="tpa[]" id="tpa" class="form-control" placeholder="T1 - TPA" value="<?php echo $rowRequest["tpa"] ?>" required>
                                </div>
                              </td>
                              <td>
                                <div class="input-group">
                                  <input type="mail" name="practical[]" id="practical" class="form-control" placeholder="T2 - Practical" value="<?php echo $rowRequest["practical"] ?>" required>
                                </div>
                              </td>
                              <td>
                                <div class="input-group">
                                  <div class="row-fluid">
                                    <select name="interview[]" id="interview" class="selectpicker" data-show-subtext="true" data-live-search="true">
                                      <?php 
                                      if($rowRequest["interview"] == 0){
                                        echo "<option data-subtext=\"Select One\" value=\"0\" selected>Interview</option>";
                                      }elseif($rowRequest["interview"] == 1){
                                        echo "<option data-subtext=\"To Next Step\" value=\"1\" selected>Pass</option>";
                                      }elseif($rowRequest["interview"] == 2){            
                                        echo "<option data-subtext=\"Cukup Sampai Disini\" value=\"2\" selected>Reject</option>";
                                      }
                                      ?>
                                      <option data-subtext="Select One" value="0">Interview</option>;
                                      <option data-subtext="To Next Step" value="1">Pass</option>
                                      <option data-subtext="Cukup Sampai Disini" value="2">Reject</option>
                                    </select>
                                  </div>
                                </div>
                              </td>
                              <td>
                                <div class="input-group">
                                  <div class="row-fluid">
                                    <select name="psikotes[]" id="psikotes" class="selectpicker" data-show-subtext="true" data-live-search="true">
                                      <?php 
                                      if($rowRequest["psikotest"] == 0){
                                        echo "<option data-subtext=\"Select One\" value=\"0\" selected>Psikotes</option>";
                                      }elseif($rowRequest["psikotest"] == 1){
                                        echo "<option value=\"1\" selected>Recomended</option>";
                                      }elseif($rowRequest["psikotest"] == 2){            
                                        echo "<option subtext=\"Banyak yang lebih baik dari dia\" value=\"2\" selected>Not Recomended</option>";
                                      }
                                      ?>
                                      <option data-subtext="Select One" value="0">Psikotes</option>
                                      <option data-subtext="" value="1">Recomended</option>
                                      <option data-subtext="Banyak yang lebih baik dari dia" value="2">Not Recomended</option>
                                    </select>
                                  </div>
                                </div>
                              </td>
                            </tr>
                          </table>
                        </div> 
                      </td>
                    </tr>
                  </tbody>
                    <?php
                      $no += 1;
                      }
                    }
                    ?>

                </table>
                <div class="input-group" style="float:right;">
                  <button id="saveTestResult" type="button" class="btn btn-info" aria-haspopup="true">Save All Candidate's Test Result</button>
                </div>
              </form>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
  <div class="modal" id="modal"></div>
  <script src="assets/js/jquery.min.js"></script>
  <script>
    function setsource(ad){
      var vSource = ad.value;

      if(vSource==1){
        $("#iSource").hide();
        $("#eSource").show();  
      }else if(vSource==2){
        $("#iSource").show();
        $("#eSource").hide();  
      }
    }

    function switchto(req_id){
      var id = req_id.value;
      var splitid = id.split("||");

      alertify.confirm("Switch Candidate", "Are you sure to switch this candidate to Request " + splitid[2] + "?", 
      function(a){
    
        var dataRequest = {req_id:splitid[1], cad_id:splitid[0], typeSave:"switchCan", userLogin:"<?php echo $_SESSION['user'] ?>"};

        $.ajax({
          data: dataRequest,
          type: "POST",
          url: "process.php",
          success: function(data){
            // alert(data);
            if(data=="true"){
              window.location = "http://www.edii.local/sms_hc/index.php?mn=3&&idReq=" + <?php echo $_GET["idReq"] ?> ;
            }else{
              alertify.alert("Switch Candidate Failed, contact your Administrator")
            }
          }
        });
      },
      function(){

      });
    }

    function comment(idCad){
      alertify.prompt('Please enter your comments, press Enter to save.', 'Comment here', 
        function(evt, value){ 
          var dataRequest = {cad_id:idCad, comment:value, typeSave:"setComment", userLogin:"<?php echo $_SESSION['user'] ?>"};

          $.ajax({
            data: dataRequest,
            type: "POST",
            url: "process.php",
            success: function(data){
              // alert(data);
              if(data=="true"){
                alertify.message('Your comment: ' + value + ' saved.');
                // window.location = "http://www.edii.local/sms_hc/index.php?mn=3&&idReq=" + <?php echo $_GET["idReq"] ?> ;
              }else{
                alertify.alert("SMSHC", "Insert Failed, contact your Administrator")
              }
            }
          });
        }
      ).set('basic',true);
    }

    function commentList(idCad){
      var dataRequest = {cad_id:idCad, typeSave:"getComments", userLogin:"<?php echo $_SESSION['user'] ?>"};

      $.ajax({
        data: dataRequest,
        type: "POST",
        url: "process.php",
        success: function(data){
          // alertify.alert('Comments',data).maximize(); 
          alertify.prompt(data, 'Comment here, press Enter to save.', 
            function(evt, value){ 
              var dataRequest = {cad_id:idCad, comment:value, typeSave:"setComment", userLogin:"<?php echo $_SESSION['user'] ?>"};

              $.ajax({
                data: dataRequest,
                type: "POST",
                url: "process.php",
                success: function(data){
                  // alert(data);
                  if(data=="true"){
                    alertify.message('Your comment: ' + value + ' saved.');
                    // window.location = "http://www.edii.local/sms_hc/index.php?mn=3&&idReq=" + <?php echo $_GET["idReq"] ?> ;
                  }else{
                    alertify.alert("SMSHC", "Insert Failed, contact your Administrator")
                  }
                }
              });
            }
          ).set('basic',true).maximize();     
        }
      }); 
    }

    $(document).ready(function(){


      // $("#source").click(function() {
      //   var vSource = ($("#source").val());
      //   alert(vSource);
      //   if(vSource==1){
      //     $("#iSource").hide();
      //     $("#eSource").show();  
      //   }else if(vSource==2){
      //     $("#iSource").show();
      //     $("#eSource").hide();  
      //   }
      // })

      // Save Candidate
      $("#saveCandidate").click(function(){
        $("#modal").show();

        // var a = $("input[name$='source']").val();
        // alert(a);
        var dataCandidate = $("#frmSave").serialize();
        var file_data = $('#cv').prop('files')[0];   
        var form_data = new FormData(); 

        form_data.append('req_id', $("#req_id").val());
        form_data.append('name', $("#name").val());
        form_data.append('email', $("#email").val());
        form_data.append('gender', $("#gender").val());
        form_data.append('phone', $("#phone").val());
        form_data.append('address', $("#address").val());
        form_data.append('userLogin', $("#userLogin").val());
        form_data.append('source', $("#source").val());
        form_data.append('employee', $("#employee").val());
        form_data.append('file', file_data);
        form_data.append('typeSave', $("#typeSave").val());

        $.ajax({
          url: "processUpload.php",
          type: "POST",
          data: form_data,
          processData: false,
          contentType: false,
          success: function(data){

            if(data!=="true"){
              $("#modal").hide();
              alertify.alert("Invalid Insert Process or Failed Upload, Try Again.");
            }else{
              window.location = "http://www.edii.local/sms_hc/index.php?mn=3&&idReq=" + <?php echo $_GET["idReq"] ?> ;
            }

          }
        });
      });

      $("#saveTestResult").click(function(){
        var standardPT = $("#standardPT").val();
        var dataCandidate = $("#frmTestResult").serialize();

        if(standardPT!='0.00'){
          $.ajax({
            data: dataCandidate,
            type: "POST",
            url: "process.php",
            success: function(data){
              if(data=="false"){
                alertify.alert("Insert Failed.");
              }else{
                window.location = "http://www.edii.local/sms_hc/index.php?mn=3&&idReq=" + <?php echo $_GET["idReq"] ?> ;
              }
            }
          });
        }else{
          alertify.alert("Standard Value for Practical Test is Null")
        }
      });

      // Support for AJAX loaded modal window.
      // Focuses on first input textbox after it loads the window.
      $("#openInputResult").click(function(e) {
        e.preventDefault();
        var url = $(this).attr('href');
        if (url.indexOf('#') == 0) {
          $(url).modal('open');
        } else {
          $.get(url, function(data) {
            $('<div class="modal hide fade">' + data + '</div>').modal();
          }).success(function() { $('input:text:visible:first').focus(); });
        }
      });

      $("#saveSfPT").click(function(){
        var standardPT = $("#standardPT").val();

        if(standardPT=='0.00'){
          alertify.alert("Value must be set.")
        }else{
          var dataSfPT = {'typeSave' : 'setSfPT', 'req_id' : <?php echo $_GET["idReq"] ?>, 'sfpt' : standardPT, 'userLogin':"<?php echo $_SESSION['user'] ?>"};

          $.ajax({
            data: dataSfPT,
            type: "POST",
            url: "process.php",
            success: function(data){
              if(data=="false"){
                alertify.alert("Insert Failed.");
              }else{
                // alertify.alert("Set Value Success");
                window.location = "http://www.edii.local/sms_hc/index.php?mn=3&&idReq=" + <?php echo $_GET["idReq"] ?> ; 
              }
            }
          });
        }
      })

    });
  </script>