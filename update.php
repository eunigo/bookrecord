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


//while문을 통해 배열을 한행씩 반환
while($row = mysqli_fetch_array($result) ){ //가져올 정보가 없으면 (false) 종료
    //책 제목 & 링크 리스트 
    $escaped_title = htmlspecialchars($row['title']);
    $list = $list."<li><a href=\"index.php?id={$row['id']}\">{$escaped_title}</a></li>";
}  


//(key,value)로 구성된 배열 
$article = array(
    'title'=>'Welcome',
    'description'=>'Hello,book'
);

$update_link = '';

//id 유무 검사 후 제목 & 설명 배열 구성  
if(isset($_GET['id'])){  //id가 있는지 검사 
    $filtered_id = mysqli_real_escape_string($conn,$_GET['id']);
    $sql = "SELECT * FROM topic WHERE id={$filtered_id}";
    $result = mysqli_query($conn,$sql);
    $row = mysqli_fetch_array($result);
    $article['title'] = htmlspecialchars($row['title']);
    $article['description'] = htmlspecialchars($row['description']);
    

    $update_link = '<a href="update.php?id='.$_GET['id'].'">update</a>';



}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Book Recording</title>
</head>
<body>
<h1><a href="index.php">독서기록장</a></h1>
        <ol>
            <?=$list?>
        </ol>

        <!--글수정-->
        <form action = "process_update.php" method="POST">
            <input type="hidden" name="id" value="<?=$_GET['id']?>">
            <p><input type="text" name="title" placeholder="책 제목" value="<?=$article['title']?>"></p>
            <p><textarea name="description" placeholder="소감을 적어주세요.."><?=$article['description']?></textarea></p>
            
</p>
            <p><input type="submit" value="제출"></p>
        </form>
    
</body>
</html>