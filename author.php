<?php
//mysql과 연동 
$conn = mysqli_connect("localhost","root","try1234","bookrecord");





?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Book Recording</title>
    </head>

    <body>
        <h1><a href="index.php">독서기록장</a></h1>
        <p><a href="index.php">book</a></p>

        <!--작가,이력 표-->
        <table border="1">
            <tr>
                <td>id</td><td>name</td><td>profile</td>
                <td></td>
                <?php
                $sql = "SELECT * FROM author";
                $result = mysqli_query($conn,$sql);
                while($row = mysqli_fetch_array($result)){
                    $filtered = array(
                        'id'=>htmlspecialchars($row['id']),
                        'name'=>htmlspecialchars($row['name']),
                        'profile'=>htmlspecialchars($row['profile'])
                    )
                    ?>
            <tr>
                <td><?=$filtered['id']?></td>
                <td><?=$filtered['name']?></td>
                <td><?=$filtered['profile']?></td>
                <td><a href="author.php?id=<?=$filtered['id']?>">update</a></td>
            </tr>
                    <?php
                }
                ?>
            </tr>

        </table>
        
        <?php
        $escaped = array(
            'name'=>'',
            'profile'=>''
          );
          $label_submit = 'Create author';
          $form_action = 'process_create_author.php';
          $form_id = '';

          if(isset($_GET['id'])){
            $filtered_id = mysqli_real_escape_string($conn, $_GET['id']);
            settype($filtered_id, 'integer');
            $sql = "SELECT * FROM author WHERE id = {$filtered_id}";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_array($result);
            $escaped['name'] = htmlspecialchars($row['name']);
            $escaped['profile'] = htmlspecialchars($row['profile']);
            $label_submit = 'Update author';
            $form_action = 'process_update_author.php';
            $form_id = '<input type="hidden" name="id" value="'.$_GET['id'].'">';
          }
        ?>
         <form action="<?=$form_action?>" method="post">
       <?=$form_id?>
       <p><input type="text" name="name" placeholder="name" value="<?=$escaped['name']?>"></p>
       <p><textarea name="profile" placeholder="profile"><?=$escaped['profile']?></textarea></p>
       <p><input type="submit" value="<?=$label_submit?>"></p>

    
            </form>
    
    </body>
</html>