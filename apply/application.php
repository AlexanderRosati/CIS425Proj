<?php 
    include('header.php');
    session_start();
?>

<main>
    <div id="server_err">
        <?php
            // no error
            if (!isset($_GET['err'])) {
                ;
            }
            // student ID not found
            else if ($_GET['err'] === 'stud_id_not_found') {
                echo '<p class="err">Student ID not found</p>';
            }
            // gender didn't match
            else if ($_GET['err'] === 'invalid_gender') {
                echo '<p class="err">You entered the wrong gender.</p>';
            }
            // dob is invalid
            else if ($_GET['err'] === 'invalid_dob') {
                echo '<p class="err">You entered an invalid Date of Birth</p>';
            }
            // dob didn't match
            else if ($_GET['err'] === 'nomatch_dob') {
                echo '<p class="err">Your entry for Date of Birth does not match our records.</p>';
            }
            // status didn't match
            else if ($_GET['err'] === 'nomatch_status') {
                echo '<p class="err">Your entry for status does not match our records.</p>';
            }
            // cgpa didn't match
            else if ($_GET['err'] === 'nomatch_cgpa') {
                echo '<p class="err">Your entry for Cumulative GPA does not match our records.</p>';
            }
            // number of credit hours didn't match
            else if ($_GET['err'] === 'nomatch_crdt_hrs') {
                echo '<p class="err">Your entry for number of credit hours does not match our records.</p>';
            }
        ?>
    </div>
    <div id="client_err"></div>
    <?php if(!file_exists('../data/winners.xml')): ?>
        <form id="app-form" action="submit-form.php" method="POST">
            <!--Student ID-->
            <label class="fixed-width" for="stud_id">Student ID:</label>
            <input id="stud_id" name="stud_id" type="text" placeholder="Student ID"><br>

            <!--First Name-->
            <label class="fixed-width" for="fname">First Name:</label>
            <input id="fname" name="fname" type="text" placeholder="First Name"><br>

            <!--Last Name-->
            <label class="fixed-width" for="lname">Last Name:</label>
            <input id="lname" name="lname" type="text" placeholder="Last Name"><br>

            <!--Phone Number-->
            <label class="fixed-width" for="phone">Phone Number:</label>
            <input id="phone" name="phone" type="text" placeholder="Phone Number">&nbsp;&nbsp;&nbsp;
            <em>Must be in XXX-XXX-XXXX format.</em><br>

            <!--Email-->
            <label class="fixed-width" for="email">Email:</label>
            <input id="email" name="email" type="text" placeholder="Email"><br>

            <!--Gender-->
            <label class="fixed-width" for="gender">Gender:</label>
            <select id="gender" name ="gender">
                <option value="F">Female</option>
                <option value="M">Male</option>
            </select><br>
                    
            <!--DOB-->
            <label class="fixed-width" for="dob">Date of Birth:</label>
            <input id="dob" name="dob" type="text" placeholder="Date of Birth">&nbsp;&nbsp;&nbsp;
            <em>Must be in yyyy-mm-dd format</em><br>

            <!--Status-->
            <label class="fixed-width" for="status">Status:</label>
            <select id="status" name="status">
                <option value="FRESHMAN">Freshman</option>
                <option value="SOPHMORE">Sophmore</option>
                <option value="JUNIOR">Junior</option>
                <option value="SENIOR">Senior</option>
            </select><br>

            <!--CGPA-->
            <label class="fixed-width" for="cgpa">CGPA:</label>
            <input id="cgpa" name="cgpa" type="text" placeholder="CGPA">&nbsp;&nbsp;&nbsp;
            <em>Must contain exactly two decimal digits</em><br>

            <!--Number of Credit Hours-->
            <label class="fixed-width" for="crdt_hrs">Number of Credit Hours:</label>
            <input id="crdt_hrs" name="crdt_hrs" type="text" placeholder="Credit Hours"><br>

            <!--Submit-->
            <label class="fixed-width" for="submit_btn">&nbsp;</label>
            <input id="submit_btn" name="submit_btn" type="button" value="Submit Application">

            <!--Hidden-->
            <input id="submit-form" name="submit-form" type="hidden" value="submitted">
        </form>
    <?php else: ?>
        <h3>Application Period is Over</h3>
        <p>The next application period has not yet started.</p>
    <?php endif; ?>
</main>
<script src="validate-form.js"></script>
<footer>
    <ul>
        <li><a class="footer_nav" href="../admin/login.php">Committee Member?</a></li>
        <?php if(isset($_SESSION['user'])): ?>
            <li><a class="footer_nav" href="logout.php">Logout</a></li>
        <?php endif ?>
    </ul>
</footer>

</body>
</html>