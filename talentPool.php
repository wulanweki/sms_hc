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
          <div class="panel-heading"><span class="glyphicon glyphicon-home" aria-hidden="true"></span><b> Add Talent Pool</b></div>
          <div class="panel-body">
            <div class="col-md-6">
              <form id="frmSave">               
                <div class="form-group" id="eSource">
                  <div class="input-group">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>    
                    <input type="hidden" name="req_id" id="req_id" class="form-control" placeholder="req_id" required value="<?php echo $_GET["idReq"] ?>">
                    <input type="hidden" name="typeSave" id="typeSave" class="form-control" value="addTalentPool">
                    <input type="hidden" name="source" id="source" class="form-control" value="1">
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
                    <span class="input-group-addon"><span class="glyphicon glyphicon-cloud"></span></span>    
                    <input type="text" name="resource" id="resource" class="form-control" placeholder="Resource From. ex : jobstreet.co.id, Mr. X, Cenayang, ect.">
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
                  <button id="saveTalentPool" type="button" class="btn btn-info" aria-haspopup="true">Save</button>
                </div>
              </form>
            </div>
          </div>
          <hr>
          <div class="panel-body">
            <div class="col-md-12">
              <h3 id="cl" name="cl">Talent Pool List</h3>
              <!-- <div class="alert alert-danger" role="alert">
                <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                <span class="sr-only">Error:</span>
                <b>Note : T1 : <i>TPA</i>, T2 : <i>Practical Test</i>, T3 : <i>Interview</i>, T4 : <i>Psikotest</i></b>
              </div> -->
              <!-- Table -->
              <form id="frmTestResult">
                <table class="table">
                  <thead>
                    <tr>
                      <th>No.</th>
                      <th>Input Date</th>
                      <th>Name</th>
                      <th>Gender</th>
                      <th>Address</th>
                      <th>Phone</th>
                      <th>Resource</th>
                      <th></th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $sqlRequest = "SELECT a.*, DATE_FORMAT(a.created_at,'%d %M %Y %h:%i:%s') created_at,
                                CASE WHEN a.gender = 1 THEN 'Male' ELSE 'Female' END gender
                                FROM sm_hc_talentpool a
                                ORDER BY a.created_at DESC";
                    $dataRequest = $conn->query($sqlRequest);

                    if ($dataRequest->num_rows > 0) {
                      $no = 1;
                      while($rowRequest = $dataRequest->fetch_assoc()) {
                    ?>
                    <tr data-toggle="collapse" data-target="#demo<?php echo $no ?>" class="accordion-toggle">
                      <td><?php echo $no ?></td>
                      <td><?php echo $rowRequest["created_at"] ?></td>
                      <td><b><?php echo $rowRequest["name"] ?></b><br>
                          <small><a href="mailto:<?php echo $rowRequest["email"] ?>" target="_top"><?php echo $rowRequest["email"] ?></a></small>
                        <br>
                        <select name="switch" id="switch" class="selectpicker" data-show-subtext="true" data-live-search="true" onchange="switchto(this)">
                          <option data-subtext="to req ..." value="0">Switch</option>
                          <?php
                          $sqlSwitch = "SELECT a.id, a.req_number, b.nama FROM sm_hc_request a 
                                          LEFT JOIN tb_datapribadi b ON a.pic = b.nik WHERE a.status IN (1) ORDER BY a.req_date DESC";
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
                      <td><?php echo $rowRequest["gender"] ?></td>
                      <td><?php echo $rowRequest["address"] ?></td>
                      <td><?php echo $rowRequest["phone"] ?></td>
                      <td><?php echo $rowRequest["resource"] ?></td>
                      <td>
                        <?php 
                        if($rowRequest["cvfile"]!=="-"){
                        ?>
                        <a class="btn btn-info btn-xs" target="_blank" role="button" href="files/<?php echo $rowRequest["cvfile"] ?>">CV</a>
                        <?php
                        }
                        ?>
                      </td>
                    </tr>
                  </tbody>
                    <?php
                      $no += 1;
                      }
                    }
                    ?>

                </table>
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

    function switchto(req_id){
      var id = req_id.value;
      // alert(id);
      var splitid = id.split("||");

      alertify.confirm("Are you sure to switch this candidate to Request " + splitid[2] + "?", 
      function(a){
        var dataRequest = {req_id:splitid[1], cad_id:splitid[0], typeSave:"switchTalentPool", userLogin:"<?php echo $_SESSION['user'] ?>"};

        $.ajax({
          data: dataRequest,
          type: "POST",
          url: "process.php",
          success: function(data){
            // alert(data);
            if(data=="true"){
              window.location = "http://www.edii.local/sms_hc/index.php?mn=4";
            }else{
              alertify.alert("Switch Candidate Failed, contact your Administrator")
            }
          }
        });
      },
      function(){
        
      });
    }

    $(document).ready(function(){

      // Save Candidate
      $("#saveTalentPool").click(function(){
        $("#modal").show();

        // var a = $("input[name$='source']").val();
        // alert(a);
        var dataCandidate = $("#frmSave").serialize();
        var file_data = $('#cv').prop('files')[0];   
        var form_data = new FormData(); 

        form_data.append('name', $("#name").val());
        form_data.append('email', $("#email").val());
        form_data.append('gender', $("#gender").val());
        form_data.append('phone', $("#phone").val());
        form_data.append('address', $("#address").val());
        form_data.append('userLogin', $("#userLogin").val());
        form_data.append('source', $("#source").val());
        form_data.append('file', file_data);
        form_data.append('typeSave', $("#typeSave").val());
        form_data.append('resource', $("#resource").val());

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
              window.location = "http://www.edii.local/sms_hc/index.php?mn=4";
            }

          }
        });
      });
    });
  </script>