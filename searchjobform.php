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
        <h1>Job Vacancy Searching System</h1>
        <form action="searchjobprocess.php" method="get" class="center form-style">
            <div class="center text-input">
                <label for="title">Job Title:</label>
                <input type="text" id="title" name="title">
            </div>
            <div class="center text-input">
                <label for="position">Position:</label>
                <select id="position" name="position">
                    <option value="">---</option>
                    <option value="Full Time">Full Time</option>
                    <option value="Part Time">Part Time</option>
                </select>
            </div>
            <div class="center text-input">
                <label for="contract">Contract:</label>
                <select id="contract" name="contract">
                    <option value="">---</option>
                    <option value="On-going">On-going</option>
                    <option value="Fixed Term">Fixed Term</option>
                </select>
            </div>
            <div class="center text-input">
                <label for="application">Application by:</label>
                <select id="application" name="application">
                    <option value="">---</option>
                    <option value="Post">Post</option>
                    <option value="Email">Mail</option>
                </select>
            </div>
            <div class="center text-input">
                <label for="location">Location:</label>
                <select id="location" name="location">
                    <option value="">---</option>
                    <option value="ACT">ACT</option>
                    <option value="NSW">NSW</option>
                    <option value="NT">NT</option>
                    <option value="QLD">QLD</option>
                    <option value="SA">SA</option>
                    <option value="TAS">TAS</option>
                    <option value="VIC">VIC</option>
                    <option value="WA">WA</option>
                </select>
            </div>
            <div class="center">
                <button type="submit">Search</button>
            </div>
        </form>
        <div class="redirect-link center"><p><a href="index.php">Return to Home Page</a></p></div>
    </div>
</body>
</html>