<?php
require_once "../config.php";
global $table;
$database = new database();
$this_folder = basename(__DIR__);
$pkid = mysql_real_escape_string($_GET['id']);
$query = "select * from " . $table['incorporation'] . " where pkid=$pkid";
$result=$database->query($query);
$rs_array = $result->fetchRow();
?>
<html>
<head>
    <style>
        table, td {
            border: 1px solid black;
            width:100%;
        }
        h3{
            text-align: center;
        }
    </style>
</head>
<body>
<h2>Applications #<?=$pkid?></h2>
<table>
    <tr>
        <td colspan="2"><h3>APPLICANT INFORMATION</h3></td>
    </tr>
    <tr>
        <td>Name</td>
        <td><?=$rs_array['name']?></td>
    </tr>
    <tr>
        <td>Contact</td>
        <td><?=$rs_array['contact']?></td>
    </tr>
    <tr>
        <td>Email</td>
        <td><?=$rs_array['email']?></td>
    </tr>
    <tr>
        <td colspan="2"><h3>PROPOSED COMPANY NAME</h3></td>
    </tr>
    <tr>
        <td>1st Proposed Company Name</td>
        <td><?=$rs_array['company_name_1']?></td>
    </tr>
    <tr>
        <td>2nd Proposed Company Name</td>
        <td><?=$rs_array['company_name_2']?></td>
    </tr>
    <tr>
        <td>3rd Proposed Company Name</td>
        <td><?=$rs_array['company_name_3']?></td>
    </tr>
    <tr>
        <td colspan="2"><h3>CLARIFICATION OF YOUR PROPOSED COMPANY NAME</h3></td>
    </tr>
    <tr>
        <td>If single letters included in the proposed name, it stand for</td>
        <td><?=$rs_array['company_name_meaning']?></td>
    </tr>
    <tr>
        <td>If the proposed name is not in the Bahasa
            Malaysia or English, please clarify
        </td>
        <td><?=$rs_array['company_name_extra']?></td>
    </tr>
    <tr>
        <td colspan="2"><h3>NATURE OF BUSINESS / PRINCIPAL ACTIVITIES</h3></td>
    </tr>
    <tr>
        <td>Nature of business to be carried on by the
            company
        </td>
        <td><?=$rs_array['nature_business']?></td>
    </tr>
    <tr>
        <td>Address</td>
        <td><?=$rs_array['address_1']?></td>
    </tr>
    <tr>
        <td>Address Line 2</td>
        <td><?=$rs_array['address_2']?></td>
    </tr>
    <tr>
        <td>City</td>
        <td><?=$rs_array['city']?></td>
    </tr>
    <tr>
        <td>State</td>
        <td><?=$rs_array['state']?></td>
    </tr>
    <tr>
        <td>Postal Code</td>
        <td><?=$rs_array['postal_code']?></td>
    </tr>
    <tr>
        <td colspan="2"><h3>PARTICULARS OF COMPANY PROMOTERS / DIRECTORS</h3></td>
    </tr>
    <?php
    $count = 0;
    $resultMember = get_query_data($table['incorporation_member'], "form_id=$pkid");
    while ($rs_member = $resultMember->fetchRow()) {
        $count++;
       ?>
        <tr>
            <td colspan="2"><center><b>Promoter/Director #<?=$count?></b></center></td>
        </tr>
        <tr>
            <td>Full Name As Per Identity Card</td>
            <td><?=$rs_member['name']?></td>
        </tr>
        <tr>
            <td>NRIC</td>
            <td><?=$rs_member['ic']?></td>
        </tr>
        <tr>
            <td>Passport</td>
            <td><?=$rs_member['passport']?></td>
        </tr>
        <tr>
            <td>Nationality</td>
            <td><?=$rs_member['country']?></td>
        </tr>
        <tr>
            <td>Date of Birth</td>
            <td><?=$rs_member['dob']?></td>
        </tr>
        <tr>
            <td>Gender</td>
            <td><?=$rs_member['gender']?></td>
        </tr>
        <tr>
            <td>Use InA2nd address</td>
            <td><?=$rs_member['use_office_address'] == "1" ? "Yes" : "No"?></td>
        </tr>
        <tr>
            <td>Address as Per Identity Card</td>
            <td><?=$rs_member['address_1']?></td>
        </tr>
        <tr>
            <td>Address Line 2</td>
            <td><?=$rs_member['address_2']?></td>
        </tr>
        <tr>
            <td>City</td>
            <td><?=$rs_member['city']?></td>
        </tr>
        <tr>
            <td>State</td>
            <td><?=$rs_member['state']?></td>
        </tr>
        <tr>
            <td>Postal Code</td>
            <td><?=$rs_member['postal_code']?></td>
        </tr>
        <tr>
            <td>Contact (Mobile)</td>
            <td><?=$rs_member['contact']?></td>
        </tr>
        <tr>
            <td>Contact (Office)</td>
            <td><?=$rs_member['contact_office']?></td>
        </tr>
        <tr>
            <td>Email</td>
            <td><?=$rs_member['email']?></td>
        </tr>
        <tr>
            <td>Number of shares held</td>
            <td><?=$rs_member['share']?></td>
        </tr>
        <tr>
            <td>Identity Card</td>
            <td><a href="<?=$site_http_url?>files/member/<?=$rs_member['file_url']?>" target="_blank">View</a></td>
        </tr>
    <?php }?>
    <tr>
        <td colspan="2"><h3>CAPITAL STRUCTURE</h3></td>
    </tr>
    <tr>
        <td>Authorised share capital</td>
        <td><?=$rs_array['auth_share_capital']?></td>
    </tr>
    <tr>
        <td>Paid up share capital</td>
        <td><?=$rs_array['paid_share_capital']?></td>
    </tr>
</table>
</body>
</html>