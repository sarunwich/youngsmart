<?php session_start();
include_once dirname(dirname(__FILE__)) . "/includes/config.php";
// echo dirname(dirname(__FILE__));  
// echo $_SERVER['SERVER_NAME']."<br/>";

?>
<link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
<script src="js/sweetalert2.min.js"></script>
<link rel="stylesheet" href="css/sweetalert2.min.css">
<style>
    * {
        box-sizing: border-box;
    }


    #adjust {
        background-color: #ffffff;
        margin: 10px auto;

        padding: 10px;
        width: 95%;
        min-width: 300px;
    }

    h5 {
        text-align: left;
    }

    /* input {
        padding: 10px;
        width: 100%;
        font-size: 17px;
        font-family: Raleway;
        border: 1px solid #aaaaaa;
    }

    /* Mark input boxes that gets an error on validation: */
    input.invalid {
        background-color: #ffdddd;
    }

    /* Hide all steps by default: */
    .tab {
        display: none;
    }

    button {
        background-color: #4CAF50;
        color: #ffffff;
        border: none;
        padding: 10px 20px;
        font-size: 17px;

        cursor: pointer;
    }

    button:hover {
        opacity: 0.8;
    }

    #prevBtn {
        background-color: #bbbbbb;
    }

    /* Make circles that indicate the steps of the form: */
    .step {
        height: 25px;
        width: 12%;
        margin: 0 2px;
        background-color: #bbbbbb;
        border: none;
        /*border-radius: 50%;*/
        display: inline-block;
        opacity: 0.5;
    }

    .step.active {
        opacity: 1;
        background-color: #36F;
    }

    /* Mark the steps that are finished and valid: */
    .step.finish {
        background-color: #4CAF50;
    }

    .myDiv {
        font-size: calc(0.45vw + 0.45vh + 0.75vmin);
        margin-left: calc(3vw + 5px);
        margin-right: calc(3vw + 5px);
        padding-left: calc(0.5vw + 3px);
        ;
        padding-top: calc(1vw + 5px);
        padding-bottom: calc(1vw + 5px);
        background-color: LightGrey;
        color: dimgrey;
    }

    .myDiv h5 {
        color: dodgerblue;
        /*font-size: calc((100%+0.2vw));*/
    }

    .myDiv .form-check-inline {
        margin-left: calc(2vw+5px);
    }

    .disabled {
        pointer-events: none;
        cursor: default;
    }
</style>
<?php // print_r($_SESSION); 
?>
<?php
//echo $_POST['p_id'] . $_POST['p_time'];
$sql_edit = "SELECT * FROM `Protocol` WHERE `p_id` = '" . $_POST['p_id'] . "' AND `p_time` = $_POST[p_time]";
$qry_edit = mysqli_query($conn, $sql_edit);
$row_edit = mysqli_fetch_array($qry_edit);
//echo $row_edit['P_Th_name'];
?>
<h5 class="text-primary">แบบยื่นปรับปรุงโครงการวิจัย </h5>
<div style="color:#FFF; text-align:center;margin-top:10px;">
    <span class="step disabled" onclick="clickTab(0)">ส่วนที่ 1</span>
    <span class="step disabled" onclick="clickTab(1)">ส่วนที่ 2</span>
    <span class="step disabled" onclick="clickTab(2)">ส่วนที่ 3</span>
    <span class="step disabled" onclick="clickTab(3)">ส่วนที่ 4</span>
    <span class="step disabled" onclick="clickTab(4)">ส่วนที่ 5</span>
    <span class="step disabled" onclick="clickTab(5)">ส่วนที่ 6</span>
    <span class="step disabled" onclick="clickTab(6)">ส่วนที่ 7</span>
</div>
<form id="adjust" name="adjust" method="post" enctype="multipart/form-data" action="" autocomplete="on">
    <input type="hidden" name="p_id" value="<?php echo $_POST['p_id']; ?>">
    <input type="hidden" name="p_time" value="<?php echo $_POST['p_time']; ?>">
    <!-- One "tab" for each step in the form: -->
    <div class="tab">
        <?php include_once "PartForm/PartEdit1.php";
        ?>
    </div>
    <div class="tab">
        <?php include_once "PartForm/PartEdit2.php";
        ?>
    </div>
    <div class="tab">
        <?php include_once "PartForm/PartEdit3.php";
        ?>
    </div>
    <div class="tab">
        <?php include_once "PartForm/PartEdit4.php";
        ?>
    </div>
    <div class="tab">
        <?php include_once "PartForm/PartEdit5_1.php";
        ?>
    </div>
    <div class="tab">
        <?php include_once "PartForm/PartEdit6_1.php";
        ?>
    </div>
    <div class="tab">
        <?php include_once "PartForm/PartEdit6.php";
        ?>
    </div>
    <div style="overflow:auto;">
        <div style="float:right;">
            <button type="button" id="prevBtn" onclick="nextPrev(-1)">Previous</button>
            <button type="button" id="nextBtn" onclick="nextPrev(1)">Next</button>
        </div>
    </div>

</form>
<div id='loadingmessage' class="overlay" style="display:none">
    <div class="overlay-content" align="center">
        <div class="progress progress-striped active" style="margin-bottom:0 auto">
            <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%"> 0% Complete</div>
        </div>
        <div class="spinner-border text-primary"></div>
        <div id="status">PROGRESS HERE</div>
    </div>
</div>
<?php //include_once "PartForm/PartForm4.php";
?>
<script>
    /////////dd

    ////download file
    function downfile(id, ptime, doctype) {
        //alert(id+'-'+ptime+'-'+doctype);
        window.location = 'hiddenpartfiledown.php?id=' + id + '&ptime=' + ptime + '&doctype=' + doctype;

    }




    ///////////////////TEL
    function autoTab(obj, typeCheck) {
        /* กำหนดรูปแบบข้อความโดยให้ _ แทนค่าอะไรก็ได้ แล้วตามด้วยเครื่องหมาย
        หรือสัญลักษณ์ที่ใช้แบ่ง เช่นกำหนดเป็น  รูปแบบเลขที่บัตรประชาชน
        4-2215-54125-6-12 ก็สามารถกำหนดเป็น  _-____-_____-_-__
        รูปแบบเบอร์โทรศัพท์ 08-4521-6521 กำหนดเป็น __-____-____
        หรือกำหนดเวลาเช่น 12:45:30 กำหนดเป็น __:__:__
        ตัวอย่างข้างล่างเป็นการกำหนดรูปแบบเลขบัตรประชาชน
        */
        if (typeCheck == 1) {
            var pattern = new String("__-____-____"); // กำหนดรูปแบบในนี้ TEL
            var pattern_ex = new String("-"); // กำหนดสัญลักษณ์หรือเครื่องหมายที่ใช้แบ่งในนี้
        } else {
            var pattern = new String("_-____-____"); // กำหนดรูปแบบในนี้ FAX
            var pattern_ex = new String("-"); // กำหนดสัญลักษณ์หรือเครื่องหมายที่ใช้แบ่งในนี้
        }
        var returnText = new String("");
        var obj_l = obj.value.length;
        var obj_l2 = obj_l - 1;
        for (i = 0; i < pattern.length; i++) {
            if (obj_l2 == i && pattern.charAt(i + 1) == pattern_ex) {
                returnText += obj.value + pattern_ex;
                obj.value = returnText;
            }
        }
        if (obj_l >= pattern.length) {
            obj.value = obj.value.substr(0, pattern.length);
        }
    }

    /////////////////////////////////

    ///////////////////////////////////////////////////////////////
    function EnableDisableCompensation() {

        var cchkYes = document.getElementById("cchkYes");
        var Compensationpement = document.getElementById("Compensationpement");
        Compensationpement.disabled = cchkYes.checked ? false : true;
        if (!Compensationpement.disabled) {
            Compensationpement.focus();
        }
    }

    function EnableDisableOther_specify() {

        var ochkYes = document.getElementById("ochkYes");
        var Other_specify = document.getElementById("Other_specify");
        Other_specify.disabled = ochkYes.checked ? false : true;
        if (!Other_specify.disabled) {
            $('#Other_specify').attr("required", "");
            $('#Other_specify').focus();
        } else {
            $('#Other_specify').removeAttr("required");
        }
    }

    function EnableDisableTextBox() {
        var chkYes = document.getElementById("chkYes");
        var registration = document.getElementById("registration");
        registration.disabled = chkYes.checked ? false : true;
        if (!registration.disabled) {
            registration.focus();
        }
    }
    ////////////////////////////////////////


    var currentTab = 0; // Current tab is set to be the first tab (0)
    showTab(currentTab); // Display the current tab

    function showTab(n) {
        // This function will display the specified tab of the form...
        var x = document.getElementsByClassName("tab");
        x[n].style.display = "block";
        //... and fix the Previous/Next buttons:
        if (n == 0) {
            document.getElementById("prevBtn").style.display = "none";
        } else {
            document.getElementById("prevBtn").style.display = "inline";
        }
        if (n == (x.length - 1)) {
            document.getElementById("nextBtn").innerHTML = "Submit";
        } else {
            document.getElementById("nextBtn").innerHTML = "Next";
        }
        //... and run a function that will display the correct step indicator:
        fixStepIndicator(n)
    }

    function clickTab(n) {
        var i, x = document.getElementsByClassName("tab");
        for (i = 0; i < x.length; i++) {
            x[i].style.display = "none";
        }
        // currentTab=n;
        // if (!validateForm()){ return false;}
        showTab(n);
    }

    function nextPrev(n) {
        // This function will figure out which tab to display
        var x = document.getElementsByClassName("tab");
        // Exit the function if any field in the current tab is invalid:
        if (n == 1 && !validateForm()) return false;
        // Hide the current tab:
        x[currentTab].style.display = "none";
        // Increase or decrease the current tab by 1:
        currentTab = currentTab + n;
        // if you have reached the end of the form...
        if (currentTab >= x.length) {
            // ... the form gets submitted:
            // document.getElementById("regForm").submit();

            functSubmit1();
            return false;
        }
        // Otherwise, display the correct tab:
        showTab(currentTab);
    }

    function validateForm() {
        // This function deals with validation of the form fields
        var x, y, i, k = 0,
            c = [],
            n = [],
            str, j = 0,
            valid = true;
        x = document.getElementsByClassName("tab");
        y = x[currentTab].getElementsByTagName("input");

        x[currentTab].classList.add('was-validated');
        // var frm = $('#adjust');
        // if (frm[0].checkValidity() === false) {
        //     alert('error');
        //     x[currentTab].classList.add('was-validated');
        //     valid = false;
        //     $(frm).find(".form-control:invalid").focus();
        // }
        // A loop that checks every input field in the current tab:
        for (i = 0; i < y.length; i++) {
            // If a field is empty...
            if (y[i].type === 'hidden') {

                if (y[i].value === "") {
                    // alert(y[i].id);
                    var str = y[i].id;
                    var res = str.substring(5, 7);
                    //   alert(res);
                    document.getElementById('username_' + res).value = "";
                    valid = false;
                    Swal.fire({
                        icon: 'error',
                        title: 'ไม่พบข้อมูลในระบบ',
                        text: 'ไม่พบข้อมูลในระบบกรุณาค้นหาชื่อใหม่อีกครั้ง หรือ ติดต่อเจ้าหน้าที่'
                    })
                }

            }
            if (y[i].type === 'checkbox') {
                //  alert(y[i].name);
                k++;
                if (c[j - 1] != (y[i].name)) {
                    c.push(y[i].name);

                    j++;
                    if (k != 0) {
                        //  alert('K >> '+k);
                        n.push(k);
                        k = 0;
                    }

                }
            } else
            if (y[i].checkValidity() === false) {
                // if (y[i].value == "") {
                // add an "invalid" class to the field:
                // y[i].className += " is-invalid";
                // and set the current valid status to false
                valid = false;

            } else {
                // y[i].classList.remove("is-invalid");
                // y[i].className += " is-valid";
            }
        }
        n.push(k);
        //alert('n >> '+n.length);
        //alert(c.length);
        for (i = 0; i < c.length; i++) {
            var checked = false;
            var cname = c[i];
            var numc = adjust.elements[c[i]].length;
            var flag = 0;
            //alert(numc);
            var res = cname.substring(0, cname.length - 2);
            // alert(res);
            // alert(n[i+1]);
            for (var j = 0; j < numc; j++) {
                var res = cname.substring(0, cname.length - 2) + j;
                // alert(res);
                $("#" + res).removeAttr("required");

                if ($('#' + res).prop('checked') == true) {

                    flag++;
                } else {

                }
            }

            if (flag <= 0) {

                var res = cname.substring(0, cname.length - 2) + '0';
                $("#" + res).attr("required", "");

                alert("กรุณาเลือกอย่างน้อย 1 ช่อง")

                valid = false;

            }

        }

        // If the valid status is true, mark the step as finished and valid:
        if (valid) {
            document.getElementsByClassName("step")[currentTab].classList.remove("finish");
            document.getElementsByClassName("step")[currentTab].classList.remove("disabled");
            document.getElementsByClassName("step")[currentTab].className += " finish";
        }
        return valid; // return the valid status
    }

    function fixStepIndicator(n) {
        // This function removes the "active" class of all steps...
        var i, x = document.getElementsByClassName("step");
        for (i = 0; i < x.length; i++) {
            x[i].className = x[i].className.replace(" active", "");
        }
        //... and adds the "active" class on the current step:
        document.getElementsByClassName("step")[n].classList.remove("disabled");
        x[n].className += " active";
    }
    /////////////submitForm/////////////


    function functSubmit1() {


        //function submitForm() {
        //    alert(5555);
        //   document.getElementById("regForm").submit();
        // $(document).ready(function() {
        //     alert(555);
        //     // process the form
        //     $('#regForm').submit(function(event) {
        var frm = $('#adjust');


        // e.preventDefault();
        var data = new FormData();
        //Form data
        var form_data = $('#adjust').serializeArray();
        $.each(form_data, function(key, input) {
            // alert(input.name);
            data.append(input.name, input.value);
        });
        //file

        //var afiles = document.getElementsByName("fileUpload[]").files;  
        var filedatas = $('input[name="fileUpload[]"]');
        //alert(filedatas.length);
        for (var i = 0; i < filedatas.length; i++) {
            if (filedatas[i].value) {
                data.append("fileUpload[]", $('input[name="fileUpload[]"]')[i].files[0]);
            }
        }

        //Custom data
        data.append('key', 'value');
        $('#loadingmessage').show();

        var progressBar = $('.progress-bar');
        var percentVal = 0;

        $.ajax({
            type: "POST",
            enctype: 'multipart/form-data',
            url: "adjust_insert_db.php",
            data: data,
            processData: false,
            contentType: false,
            cache: false,
            timeout: 600000,
            xhr: function() {
                var xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener("progress", function(evt) {
                    if (evt.lengthComputable) {
                        percentVal = evt.loaded / evt.total;
                        //console.log(percentVal);
                        $('#status').html('<b> Uploading -> ' + (Math.round(percentVal * 100)) + '% </b>');
                        progressBar.css("width", Math.round(percentVal * 100) + '%').attr("aria-valuenow", 50 + '%').text(Math.round(percentVal * 100) + '%');
                    }
                }, false);
                return xhr;
            },
            success: function(data) {
                $('#loadingmessage').hide();
                // alert('success' + data);
                // $("#result").text(data);
                console.log("SUCCESS : ", data);
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Your work has been saved',
                    showConfirmButton: false,
                    timer: 2500
                })
                // location.reload();
                window.setTimeout(function() {
                    location.reload();
                }, 3000);
            },
            error: function(e) {

                console.log("ERROR : ", e);
                // location.reload();

            }

        });

        //     });
        // })
    }
    /////////////////////////