<style>
  .input-group{
    padding-bottom: 5px;
  }  
</style>

<div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="panel panel-default">
        <!-- Default panel contents -->
          <div class="panel-heading"><span class="glyphicon glyphicon-home" aria-hidden="true"></span><b> Add Staff Request</b></div>
          <div class="panel-body">
            <div class="col-md-6">
              <form id="frmSave">
                <div class="input-group">
                  <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>    
                  <input type="hidden" name="typeSave" id="typeSave" class="form-control" value="request">
                  <input type="hidden" name="userLogin" id="userLogin" class="form-control" value="<?php echo $_SESSION["user"] ?>">
                  <input type="text" id="reqNumber" name="reqNumber" class="form-control" placeholder="Number (Nomor PP)" required>
                </div>
                <div class="input-group">
                  <div class="row-fluid">
                    <select name="division" id="division" class="selectpicker" data-show-subtext="true" data-live-search="true">
                      <option data-subtext="Select one" value="0">Division</option>
                      <?php
                      $sqlDivision = "SELECT id, nama_div_ext FROM tbldivmaster WHERE type IS NULL ORDER BY nama_div_ext";
                      $dataDivision = $conn->query($sqlDivision);

                      if ($dataDivision->num_rows > 0) {
                        while($rowDivision = $dataDivision->fetch_assoc()) {
                      ?>
                          <option data-subtext="Division" value="<?php echo $rowDivision["id"] ?>"><?php echo $rowDivision["nama_div_ext"] ?></option>
                      <?php
                        }
                      } 
                      ?>
                    </select>
                  </div>
                </div>
                <div class="input-group">
                  <div class="row-fluid">
                    <select name="pic" id="pic" class="selectpicker" data-show-subtext="true" data-live-search="true">
                      <option data-subtext="Select one" value="0">PIC</option>
                      <?php
                      $sqlPIC = "SELECT a.nik, a.nama, b.nama_div_ext 
                                  FROM tb_datapribadi a  
                                  LEFT JOIN tbldivmaster b ON a.Divisi = b.id 
                                  WHERE a.idpangkat IN (2,3,4,5,6,7) AND resign = 'N'";
                      $dataPIC = $conn->query($sqlPIC);

                      if ($dataPIC->num_rows > 0) {
                        while($rowPIC = $dataPIC->fetch_assoc()) {
                      ?>
                          <option data-subtext="<?php echo $rowPIC["nama_div_ext"] ?>" value="<?php echo $rowPIC["nik"] ?>"><?php echo $rowPIC["nik"]." - ".$rowPIC["nama"] ?></option>
                      <?php
                        }
                      } 
                      ?>
                    </select>
                  </div>
                </div>
                <div class="input-group">
                  <div class="row-fluid">
                    <select name="position" id="position" class="selectpicker" data-show-subtext="true" data-live-search="true">
                      <option data-subtext="Select one" value="0">Position</option>
                      <?php
                      $sqlPosition = "SELECT id, jabatan FROM tb_jabatan WHERE type IS NULL AND jabatan <> '' ORDER BY jabatan";
                      $dataPosition = $conn->query($sqlPosition);

                      if ($dataPosition->num_rows > 0) {
                        while($rowPosition = $dataPosition->fetch_assoc()) {
                      ?>
                          <option data-subtext="Position" value="<?php echo $rowPosition["id"] ?>"><?php echo $rowPosition["jabatan"] ?></option>
                      <?php
                        }
                      } 
                      ?>
                    </select>
                  </div>
                </div>
                <div class="input-group">
                  <span class="input-group-addon"><span class="glyphicon glyphicon-info-sign"></span></span>    
                  <textarea class="form-control" name="detPosition" id="detPosition" cols="20" rows="5" placeholder="Detail Position -- Ex : Programmer PHP, Programmer .Net, Etc."></textarea>
                </div>
                <div class="input-group">
                  <div class="row-fluid">
                    <select id="qty" name="qty" class="selectpicker" data-show-subtext="true" data-live-search="true">
                      <option data-subtext="Select one" value="0">Quantity</option>
                      <option data-subtext="Person" value="1">1</option>
                      <option data-subtext="Person" value="2">2</option>
                      <option data-subtext="Person" value="3">3</option>
                      <option data-subtext="Person" value="4">4</option>
                      <option data-subtext="Person" value="5">5</option>
                    </select>
                  </div>
                </div>
                <div class="input-group">
                  <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>    
                  <input class="form-control" id="deadlineDate" name="deadlineDate" placeholder="Deadline Date - MM/DD/YYY" type="text"/>
                </div>
                <div class="input-group">
                  <button id="saveRequest" type="button" class="btn btn-info" aria-haspopup="true">Save</button>
                </div>
              </form>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
  <script src="assets/js/jquery.min.js"></script>
  <script>
      $(document).ready(function(){
        var date_input=$('input[name="deadlineDate"]'); 
        var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
        var options={
          format: 'yyyy/mm/dd',
          container: container,
          todayHighlight: true,
          autoclose: true,
        };
        date_input.datepicker(options);

        // Save Request
        $("#saveRequest").click(function(){

          var dataRequest = $("#frmSave").serialize();

          $.ajax({
            data: dataRequest,
            type: "POST",
            url: "process.php",
            success: function(data){
              if(data=="true"){
                alertify.alert("Request Received")
                window.location = "http://www.edii.local/sms_hc/index.php";
              }else{
                alertify.alert("Insert Failed, contact your Administrator")
              }
            }
          });


        });
      });
  </script>