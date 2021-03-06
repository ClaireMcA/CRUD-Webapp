<?php 

    // include the config file that we created last week
    require "../config.php";
    require "common.php";

    
    // run when submit button is clicked
    if (isset($_POST['submit'])) {
        try {

            $connection = new PDO($dsn, $username, $password, $options);  

            //grab elements from form and set as varaible
            $work =[
                "id"         => $_POST['id'],
                "artistname" => $_POST['artistname'],
                "worktitle"  => $_POST['worktitle'],
                "workdate"   => $_POST['workdate'],
                "worktype"   => $_POST['worktype'],
                "date"   => $_POST['date'],
            ];
        
            // create SQL statement
            $sql = "UPDATE `works` 
                    SET id = :id, 
                        artistname = :artistname, 
                        worktitle = :worktitle, 
                        workdate = :workdate, 
                        worktype = :worktype, 
                        date = :date('l jS \of F Y h:i:s A') 
                    WHERE id = :id";
        
            //prepare sql statement
            $statement = $connection->prepare($sql);
        
            //execute sql statement
            $statement->execute($work);

        } catch(PDOException $error) {

            echo $sql . "<br>" . $error->getMessage();
            
        }
    }
?>

<?php

    if (isset($_GET['id'])) {

        try {
            // standard db connection
            $connection = new PDO($dsn, $username, $password, $options);
            
            // set if as variable
            $id = $_GET['id'];
            
            //select statement to get the right data
            $sql = "SELECT * FROM works WHERE id = :id";
            
            // prepare the connection
            $statement = $connection->prepare($sql);
            
            //bind the id to the PDO id
            $statement->bindValue(':id', $id);
            
            // now execute the statement
            $statement->execute();
            
            // attach the sql statement to the new work variable so we can access it in the form
            $work = $statement->fetch(PDO::FETCH_ASSOC);
            
        } catch(PDOExcpetion $error) {
            echo $sql . "<br>" . $error->getMessage();
        }

    } else {
        // If no ID, show error
        echo "No ID - Something went wrong";
    }

?>

<?php include "templates/header.php"; ?>

<?php if (isset($_POST['submit']) && $statement) : ?>
	<p>Work successfully updated.</p>
<?php endif; ?>

<h2>Edit a work</h2>

<form method="post">
    <label for="id">ID</label> 
    <input type="text" name="id" id="id" value="<?php echo $work['id']; ?>" readonly="readonly">
    
    <label for="artistname">Artist Name</label> 
    <input type="text" name="artistname" id="artistname" value="<?php echo $work['artistname']; ?>"> 

    <label for="worktitle">Work Title</label> 
    <input type="text" name="worktitle" id="worktitle" value="<?php echo $work['worktitle']; ?>"> 

    <label for="workdate">Work Date</label> 
    <input type="text" name="workdate" id="workdate" value="<?php echo $work['workdate']; ?>"> 

    <label for="worktype">Work Type</label> 
    <input type="text" name="worktype" id="worktype" value="<?php echo $work['worktype']; ?>"> 

    <label for="date">Date Created</label>
    <input type="text" name="date" id="date" value="<?php echo $work['date']; ?>" readonly="readonly">

    <input type="submit" name="submit" value="Save">
</form>


<?php include "templates/footer.php" ?>