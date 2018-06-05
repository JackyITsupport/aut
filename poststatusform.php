    <!DOCTYPE html>


<head>
    <meta charset="utf-8" />
    <title>Post Status page</title>
</head>
<body background = "images/picture.jpg">
    <h1>Status Posting System</h1>
    <form action="poststatusprocess.php" method="post">

        <label>Status Code (required): &nbsp;<input type="text" name="code" id = "code"
                                                    placeholder= "e.g. S0000" maxlength= "5" > </label><br />
        <label>
            Status(required):
            <script>
                for (i = 0; i < 10; i++) {
                    document.write("&nbsp;");
                }
            </script>
            <input type="text" name="status">
        </label><br />
        <script>
            for (i = 0; i < 2; i++) {
                document.write("<br/>");
            }
        </script>
        <label>Share</label> &nbsp; &nbsp; &nbsp;
        <input type="radio" name="sharetype" value= "p"/>Public &nbsp; &nbsp; &nbsp;
        <input type="radio" name="sharetype" value= "f"/>Friends &nbsp; &nbsp; &nbsp;
        <input type="radio" name="sharetype" value= "o" />Only Me
        <br />
        <label>
            Date:  &nbsp; &nbsp; &nbsp;
            <input type="text" name="date" id = "date" placeholder="<?php echo date('d/m/y')?>" maxlength= "10"
                   value= "<?php echo date('d/m/y')?>" />
        </label>
        <br />
        <label>Permission Type: </label>
        <input type="checkbox" name="like" value="1" /> Allow Like
        <input type="checkbox" name="comment" value="1" /> Allow Comment
        <input type="checkbox" name="share" value="1" /> Allow Share
        <br />
        <br/>

        <input type= "submit" value= "Post" />
        <input type= "reset"  value= "Reset"/>
        <br/>
        <br/>
    </form>
    
</body>
<div>
    <a href="index.html">Return to Home Page</a>
</div>
</html>