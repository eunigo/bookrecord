<?php
//mysql과 연동 
$conn = mysqli_connect("localhost","root","try1234","bookrecord");

//입력 받은 값 SQL injection 방지 
$filtered = array (
    'title'=>mysqli_real_escape_string($conn,$_POST['title']),
    'description'=>mysqli_real_escape_string($conn,$_POST['description']),
    'author_id'=>mysqli_real_escape_string($conn,$_POST['author_id'])
);



//query (글 생성 - 입력 받은 책 정보 처리)
$sql="
INSERT INTO topic
(title,description,author_id)
VALUES
('{$filtered['title']}','{$filtered['description']}',{$filtered['author_id']})
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