<html>
<head>
    <meta charset="utf-8" />
    <title>Search Status Page</title>
    <h1><strong>Status Posting System</strong></h1>
</head>
<body background= "images/searchPic.jpg">
    <form method = "get" action = "searchstatusprocess.php">
    <label> Status:
      
    <input type="text" name="status" maxlength="255" />
        
    <input type="submit" name= "viewstatus" />
    </label>
    <script>
            for (i = 0; i < 2; i++) {
                document.write("<br/>");
            }
    </script>
    <a href="index.html"> Return to Home Page</a>
</body>
</html>