






<?php 
    
    if (isset($_POST['submit'])) {

        require "../config.php"; 

        try {
            $connection = new PDO($dsn, $username, $password, $options);

            $new_work = array( 
                "artistname"    => $_POST['artistname'], 
                "worktitle"     => $_POST['worktitle'],
                "workdate"      => $_POST['workdate'],
                "worktype"      => $_POST['worktype'], 
            );

            $sql = "INSERT INTO works (
                artistname,
                worktitle,
                workdate,
                worktype
            ) VALUES (
                :artistname,
                :worktitle,
                :workdate,
                :worktype
            )";        
        
            $statement = $connection->prepare($sql);
            $statement->execute($new_work);

        
        } catch (PDOException $error) {
            echo $sql . "<br>" . $error->getMessage();
        
        }
    }

?>


<?php include "templates/header.php"; ?>  

<?php if (isset($_POST['submit']) && $statement) { ?>
    <p>Work successfully added.</p>
<?php } ?>

<form method="post">
    <label for="artistname">Artist Name</label> 
    <input type="text" name="artistname" id="artistname"> 

    <label for="worktitle">Work Title</label> 
    <input type="text" name="worktitle" id="worktitle"> 

    <label for="workdate">Work Date</label> 
    <input type="text" name="workdate" id="workdate"> 

    <label for="worktype">Work Type</label> 
    <input type="text" name="worktype" id="worktype"> 

    <input type="submit" name="submit" value="Submit">
</form>



<?php include "templates/footer.php"; ?>