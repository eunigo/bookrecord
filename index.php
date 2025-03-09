<?php
//mysql과 연동 
$conn = mysqli_connect("localhost","root","try1234","bookrecord");

//query (topic 정보)
$sql="
SELECT * FROM topic
";

//query 실행 후 결과 
$result = mysqli_query($conn,$sql);

$list = '';


while($row = mysqli_fetch_array($result) ){ //가져올 정보가 없으면 (false) 종료
    //책 제목 & 링크 리스트 
    $list = $list."<li><a href=\"index.php?id={$row['id']}\">{$row['title']}</a></li>";
}  

//(key,value)로 구성된 배열 
$article = array(
    'title'=>'Welcome',
    'description'=>'Hello,book'
);

$update_link = '';
$delete_link='';
$author = '';

//id 유무 검사 후 제목 & 설명 배열 구성  
if(isset($_GET['id'])){  //id가 있는지 검사 
    $filtered_id = mysqli_real_escape_string($conn,$_GET['id']);
    $sql = "SELECT * FROM topic LEFT JOIN author ON topic.author_id = author.id WHERE topic.id={$filtered_id}";
    $result = mysqli_query($conn,$sql);
    $row = mysqli_fetch_array($result);
    $article['title'] = htmlspecialchars($row['title']);
    $article['description'] = htmlspecialchars($row['description']);
    $article['name'] = htmlspecialchars($row['name']);

    $update_link = '<a href="update.php?id='.$_GET['id'].'">update</a>';

    $delete_link= '<form action="process_delete.php" method="post">
    <input type="hidden" name="id" value="'.$_GET['id'].'">
    <input type="submit" value="delete" onclick="return confirm(\'정말 삭제하시겠습니까?\');">
    </form>
    ';

    $author = "<p>by {$article['name']}</p>";

}


?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Book Recording</title>
    </head>

    <body>
        <h1><a href="index.php">독서기록장</a></h1>
        <a href="author.php">작가</a>
        <ol>
            <!--책 제목 list echo-->
            <?=$list?>
        </ol>

        <!--글생성-->
        <p><a href="create.php">create</a></p>
        <!--글수정-->
        <?=$update_link?>
        <!--글삭제-->
        <?=$delete_link?>


        <h2><?=$article['title']?></h2>
        <?=$article['description']?><br>
        <?=$author?>
    
        
    </body>
</html>