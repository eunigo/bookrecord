<?php
//mysql과 연동 
$conn = mysqli_connect("localhost","root","try1234","bookrecord");

settype($_POST['id'],'integer');

//입력 받은 값 SQL injection 방지 
$filtered = array (
    'id'=>mysqli_real_escape_string($conn,$_POST['id']),
    'title'=>mysqli_real_escape_string($conn,$_POST['title']),
    'description'=>mysqli_real_escape_string($conn,$_POST['description'])
);



//query (글 수정)
$sql="
UPDATE topic
SET 
title = '{$filtered['title']}',
description = '{$filtered['description']}'

WHERE
id ={$filtered['id']}

";

//query 실행 후 결과 
$result = mysqli_query($conn,$sql);

//query가 오류나면 원인이 뭔지 
if ( $result == false ){
    echo '저장하는 과정에서 문제가 생겼습니다. 관리자에게 문의해주세요.';
    error_log(mysqli_error($conn)); 
}
else{
    echo '성공했습니다!<a href="index.php">돌아가기</a>';
}


?>