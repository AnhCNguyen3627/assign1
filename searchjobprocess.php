<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="description" content="Job Search index page" />
    <meta name="keywords" content="index" />
    <meta name="author" content="NguyenCongAnh" />
    <link href="style.css" rel="stylesheet" />
    <title>Search Job Vacancy Page</title>
</head>
<body>
    <div class="center container">
        <h1>Job Vacancy Information</h1>
        <?php
            $title = isset($_GET["title"]) ? $_GET["title"] : "";
            $position = isset($_GET["position"]) ? $_GET["position"] : "";
            $ontract = isset($_GET["contract"]) ? $_GET["contract"] : "";
            $application = isset($_GET["application"]) ? $_GET["application"] : "";
            $location = isset($_GET["location"]) ? $_GET["location"] : "";
          
            $file_path = "../../data/jobposts/jobs.txt";  
    
            if (empty($title)) {
                echo "<p>Please provide a job title to search.</p>";
            } elseif (!file_exists($file_path)) {
                echo "<p>No job vacancy records found.</p>";
            } else {
                $file_contents = file_get_contents($file_path);
                $lines = explode("\n", $file_contents);

                $found_jobs = [];

                foreach ($lines as $line) {
                    $fields = explode("\t", $line);
                    if (
                        count($fields) >= 8 && 
                        (empty($title) || preg_match("/\b" . preg_quote($title, '/') . "\b/i", $fields[1])) &&
                        (empty($position) || $fields[4] === $position) &&
                        (empty($contract) || $fields[5] === $contract) &&
                        (empty($application) || stripos($fields[7], $application) !== false) &&
                        (empty($location) || $fields[8] === $location)
                    ) {
                        $found_jobs[] = $fields;
                    }
                }

                $current_date = date("d/m/y");
                $filtered_jobs = array_filter($found_jobs, function ($job) use ($current_date)  {
                    return $job[3] >= $current_date;
                });

                function compareClosingDates($a, $b) {
                    $dateA = $a[3];
                    $dateB = $b[3];
                
                    if ($dateA == $dateB) {
                        return 0;
                    }
                    return ($dateA > $dateB) ? -1 : 1;
                }
                
                usort($filtered_jobs, 'compareClosingDates');
    
                if (empty($filtered_jobs)) {
                    echo "<p>No job vacancies found for your search.</p>";
                } else {
                    foreach ($filtered_jobs as $job) {
                        echo "<div class='job' >
                        <p><b>Job Title:      </b> $job[1]</p>
                        <p><b>Description:    </b> $job[2]</p>
                        <p><b>Closing Date:   </b> $job[3]</p>
                        <p><b>Position:       </b> $job[4]</p>
                        <p><b>Contract:       </b> $job[5]</p>
                        <p><b>Application by: </b> $job[7]</p>
                        <p><b>Location:       </b> $job[8]</p>
                        </div>";
    
                    }
                }
            }
        ?>
        <div class="redirect-link center">
            <p><a href="searchjobform.php">Search for another job vacancy</a></p>
            <p><a href="index.php">Return to Home Page</a></p>
        </div>
    </div>
</body>
</html>