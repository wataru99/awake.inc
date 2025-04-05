<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Composer で PHPMailer をインストールしている場合

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST["name"]);
    $email = filter_var($_POST["email"], FILTER_VALIDATE_EMAIL);
    $message = htmlspecialchars($_POST["message"]);

    if (!$email) {
        die("無効なメールアドレスです。");
    }

    $mail = new PHPMailer(true);

    try {
        // SMTP 設定
        $mail->isSMTP();
        $mail->Host       = 'smtp.example.com'; // SMTP サーバー
        $mail->SMTPAuth   = true;
        $mail->Username   = 'your-email@example.com'; // SMTP ユーザー名
        $mail->Password   = 'your-email-password';   // SMTP パスワード
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // TLS 暗号化
        $mail->Port       = 587;

        // 送信先・送信者情報
        $mail->setFrom('your-email@example.com', '株式会社サンプル');
        $mail->addAddress('info@example.com'); // 受信者

        // メール内容
        $mail->Subject = "お問い合わせ from $name";
        $mail->Body    = "お名前: $name\nメールアドレス: $email\n\nお問い合わせ内容:\n$message";

        $mail->send();
        echo "メールが送信されました。";
    } catch (Exception $e) {
        echo "メール送信に失敗しました: {$mail->ErrorInfo}";
    }
} else {
    echo "不正なアクセスです。";
}
?>
