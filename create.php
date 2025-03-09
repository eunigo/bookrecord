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

$sql = "SELECT * FROM author";
$result = mysqli_query($conn, $sql);

//작가 고를 수 있도록 
$select_form = '<select name="author_id">'; 

while($row = mysqli_fetch_array($result) ){ //가져올 정보가 없으면 (false) 종료
    $select_form = $select_form.'<option value="'.$row['id'].'">'.$row['name'].'</option>';
}  

$select_form = $select_form.'</select>'; 


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

        <!--글생성-->
        <form action = "process_create.php" method="POST">
            <p><input type="text" name="title" placeholder="책 제목"></p>
            <p><textarea name="description" placeholder="소감을 적어주세요.."></textarea></p>
            <!--작가 선택-->
            <?=$select_form?>
            <p><input type="submit" value="제출"></p>
        </form>
    
</body>
</html>