<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="description" content="Job Search index page" />
    <meta name="keywords" content="index" />
    <meta name="author" content="NguyenCongAnh" />
    <link href="style.css" rel="stylesheet" />
    <title>Post Job Page</title>
</head>
<body>
    <div class="center container">
        <h1>Job Post Process</h1>
        <?php
            function check_empty(&$string)
            {
                $string = trim($string);
                if (!empty($string))
                    return false;
                return true;
            }
            function validate_pid($i)
            {
                if (check_empty($i))
                    return "Position ID cannot be empty";
                if (strlen($i) !== 5)
                    return "Position ID must be 5 characters in length";
                if (preg_match("/^P[0-9]{4}$/", $i) == 0)
                    return "Position ID must start with an uppercased \"P\" 
                        followed by 4 digits";
                return "";
            }
            function validate_title($i)
            {
                if (check_empty($i))
                    return "Title cannot be empty";
                if (strlen($i) > 20)
                    return "Title must be 20 characters or less in length";
                if (preg_match("/[^\d\w,.! ]/", $i) == 1)
                    return "Title can only contain alphanumeric characters including
                        spaces, comma, period";
                return "";
            }
            function validate_desc($i)
            {
                if (check_empty($i))
                    return "Description cannot be empty";
                if (strlen($i) > 260)
                    return "Description must be 260 characters or less in length";
                return "";
            }
            function validate_cdate($i)
            {
                if (check_empty($i))
                    return "Closing Date cannot be empty";
                if (preg_match("/^(0?[1-9]|[12]\d|3[01])[\/](0?[1-9]|1[0-2])[\/]\d{2}$/", $i) == 0)
                    return "Date must follow dd/mm/yy format";
                $temp = explode("/", $i);
                if (!checkdate($temp[1], $temp[0], "20" . $temp[2])) {
                    return "Date is not valid";
                }
                return "";
            }
            function validate_pos($i)
            {
                if (check_empty($i))
                    return "Position option must be selected";
                return "";
            }
            function validate_contract($i)
            {
                if (check_empty($i))
                    return "Contract option must be selected";
                return "";
            }
            function validate_app($p, $m)
            {
                if (check_empty($p) && check_empty($m))
                    return "At least one application method must be selected";
                return "";
            }
            function validate_loc($i)
            {
                if (check_empty($i))
                    return "Location option must be selected";
                return "";
            }

            function validate_form(
                &$pid,
                &$title,
                &$desc,
                &$cdate,
                &$pos,
                &$contract,
                &$post,
                &$email,
                &$loc
            ) {
                $e_pid = validate_pid($pid);
                $e_title = validate_title($title);
                $e_desc = validate_desc($desc);
                $e_cdate = validate_cdate($cdate);
                $e_pos = validate_pos($pos);
                $e_contract = validate_contract($contract);
                $e_app = validate_app($post, $email);
                $e_loc = validate_loc($loc);
                $errors = array(
                    $e_pid,
                    $e_title,
                    $e_desc,
                    $e_cdate,
                    $e_pos,
                    $e_contract,
                    $e_app,
                    $e_loc
                );
                $count = 0;
                foreach ($errors as $e) {
                    if ($e !== "") {
                        echo "<p>" . $e . "</p>";
                        $count++;
                    }
                }
                return $count;
            }
        ?>

        <?php
            $pid = $_POST["pid"];
            $title = $_POST["title"];
            $desc = $_POST["desc"];
            $cdate = $_POST["cdate"];
            $pos = isset($_POST["pos"]) ? $_POST["pos"] : "";
            $contract = isset($_POST["contract"]) ? $_POST["contract"] : "";
            $post = isset($_POST["post"]) ? $_POST["post"] : "";
            $email = isset($_POST["email"]) ? $_POST["email"] : "";
            $loc = isset($_POST["loc"]) ? $_POST["loc"] : "";
            $count = validate_form($pid, $title, $desc, $cdate, $pos, $contract, $post, $email, $loc);
            if ($count !== 0) {
                echo "<p>Use the browser's \"Go Back\" button to complete the form</p>";
                return;
            }
            $dir = "../../data/jobposts";
            if (!file_exists($dir)) {
                umask(0007);
                mkdir($dir, 02770);
            }
            $filename = "../../data/jobposts/jobs.txt";
            $joblist = array();
            if (!file_exists($filename)) {
                $new_data = true;
            } else {
                $handle = fopen($filename, "r");
                while (!feof($handle)) {
                    $data = fgets($handle);
                    $data = explode("\t", $data);
                    $joblist[] = $data;
                }
                foreach ($joblist as $job) {
                    if (in_array($pid, $job)) {
                        $new_data = false;
                        break;
                    }
                    $new_data = true;
                }
                fclose($handle);
            }
            if ($new_data) {
                $data = $pid . "\t" . $title . "\t" . $desc . "\t" .
                    $cdate . "\t" . $pos . "\t" . $contract . "\t" .
                    $post . "\t" . $email . "\t" . $loc . "\n";
                $joblist[] = $data;
                file_put_contents($filename, $data, FILE_APPEND);
                echo "<p>Job successfully posted</p>";
            } else
                echo "<p>Job with the same ID already exist</p>";
        ?>
        <div class="redirect-link"><a href="index.php">Go back</a></div>
    </div>
</body>
</html>