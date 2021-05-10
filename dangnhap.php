<?php
//Khai báo sử dụng session
session_start();

//Khai báo utf-8 để hiển thị được tiếng việt
header('Content-Type: text/html; charset=UTF-8');

//Xử lý đăng nhập
if (isset($_POST['dangnhap'])) {
    //Kết nối tới database
    include('ketnoi.php');

    //Lấy dữ liệu nhập vào
    $username = addslashes($_POST['txtUsername']);
    $password = addslashes($_POST['txtPassword']);

    //Kiểm tra đã nhập đủ tên đăng nhập với mật khẩu chưa
    if (!$username || !$password) {
        echo "Vui lòng nhập đầy đủ tên đăng nhập và mật khẩu. <a href='javascript: history.go(-1)'>Trở lại</a>";
        exit;
    }

    // mã hóa pasword
    $password = md5($password);

    //Kiểm tra tên đăng nhập có tồn tại không
    $query = mysqli_query($conn, "SELECT username, password FROM members WHERE username='$username'");
    if (mysqli_num_rows($query) == 0) {
        echo "Tên đăng nhập này không tồn tại. Vui lòng kiểm tra lại. <a href='javascript: history.go(-1)'>Trở lại</a>";
        exit;
    }

    //Lấy mật khẩu trong database ra
    $row = mysqli_fetch_assoc($query);

    //So sánh 2 mật khẩu có trùng khớp hay không
    if ($password != $row['password']) {
        echo "Mật khẩu không đúng. Vui lòng nhập lại. <a href='javascript: history.go(-1)'>Trở lại</a>";
        exit;
    }

    //Lưu tên đăng nhập
    $_SESSION['username'] = $username;
    echo "Xin chào " . $username . ". Bạn đã đăng nhập thành công. <a href='index.php'>Về trang chủ</a>";
    die();
}
?>
<!DOCTYPE html>
<html>
<head>
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
      <link href="css/login.css" rel="stylesheet" type="text/css"/>
</head>
<body>
    <div class="login-form">
        <form action='dangnhap.php?do=login' method='POST'>
            <h1>Đăng nhập vào website</h1>
            <div class="input-box">
                <i ></i>
                <input name="txtUsername" type="text" placeholder="Nhập username">
            </div>
            <div class="input-box">
                <i ></i>
                <input name="txtPassword" type="password" placeholder="Nhập mật khẩu">
            </div>
            <div class="btn-box">
                <input type='submit' value='Đăng nhập' name="dangnhap" />
                <a href='dangky.php' survey_name='Đăng ký'>Đăng ký</a>
            </div>
        </form>
    </div>


</body>
</html>