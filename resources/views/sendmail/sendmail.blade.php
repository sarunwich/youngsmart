<!DOCTYPE html>
<html>
<head>
    <title>แจ้งสถานะการสมัครเรียนผ่านระบบ Young Smart</title>
</head>
<body>
<h3>{{ $SendMailData['title'] }}</h3>
    <p>{{ $SendMailData['body'] }}</p>
    <strong>สถานะ</strong>{{ $SendMailData['status'] }}<br>
    <p>{{ $SendMailData['URL'] }}</p>
    <p>Thank you</p>
    <p>*** Email เป็นการส่งอัตโนมัติ ไม่ต้องตอบกลับ</p>
</body>
</html>