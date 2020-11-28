<?php function displayApplicantInfo($applicant) {
$html = <<<HTML
<table>
    <tr>
        <th>ID</th>
        <td>$applicant->id</td>
    </tr>
    <tr>
        <th>Status</th>
        <td>$applicant->status</td>
    </tr>
    <tr>
        <th>Cumulative GPA</th>
        <td>$applicant->cgpa</td>
    </tr>
    <tr>
        <th>Gender</th>
        <td>$applicant->gender</td>
    </tr>
    <tr>
        <th>First Name</th>
        <td>$applicant->fname</td>
    </tr>
    <tr>
        <th>Last Name</th>
        <td>$applicant->lname</td>
    </tr>
    <tr>
        <th>Phone Number</th>
        <td>$applicant->phoneNum</td>
    </tr>
    <tr>
        <th>Email</th>
        <td>$applicant->email</td>
    </tr>
    <tr>
        <th>Date of Birth</th>
        <td>$applicant->dob</td>
    </tr>
    <tr>
        <th>Credit Hours</th>
        <td>$applicant->creditHours</td>
    </tr>
    <tr>
        <td colspan="2">&nbsp;</td>
    </tr>
</table>
HTML;

echo $html;
} ?>