<?php
//mysql과 연동 
$conn = mysqli_connect("localhost","root","try1234","bookrecord");

//입력 받은 값 SQL injection 방지 
$filtered = array (
    'name'=>mysqli_real_escape_string($conn,$_POST['name']),
    'profile'=>mysqli_real_escape_string($conn,$_POST['profile'])
);



//query (작가 생성)
$sql="
INSERT INTO author
(name,profile)
VALUES
(
'{$filtered['name']}',
'{$filtered['profile']}'
)";

//query 실행 후 결과 
$result = mysqli_query($conn,$sql);

//query가 오류나면 원인이 뭔지 
if ( $result == false ){
    echo '저장하는 과정에서 문제가 생겼습니다. 관리자에게 문의해주세요.';
    error_log(mysqli_error($conn)); 
}
else{
    header('Location: author.php');
}


?>