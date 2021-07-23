<!-- 条件分岐でPOSTかGETか判断 -->
<!-- $selectで input confirm sendを管理する -->
<?php 
  session_start(); //セッションの開始
  $select = "input";
  $errmaessage = array(); //エラーメッセージを配列にする
  
  if(isset($_POST["back"]) && $_POST["back"]){
    //入力画面に戻る
  }elseif(isset($_POST["confirm"]) && $_POST["confirm"]){

    //nameに入力間違いがないか確認
    if(!$_POST["name"]){
      $errmaessage[] = "名前を入力して下さい。";
    }elseif(mb_strlen($_POST["name"]) > 50){ //mb_strlen()で50文字以内か確認
      $errmaessage[] = "名前は50文字以内にして下さい。";
    }
      $_SESSION["name"] = htmlspecialchars($_POST["name"]);

    //emailに入力間違いがないか確認
    if(!$_POST["email"]){
      $errmaessage = "Eメールを入力して下さい。";
    }elseif(mb_strlen($_POST["email"]) > 100){ //100文字以内か確認
      $errmaessage[] = "Eメールは100文字以内にして下さい。";
    }elseif(!filter_var($_POST["email"])){ //filter_var()でメールアドレスか確認
      $errmaessage[] = "メールアドレスが正しくありません。";
    }
      $_SESSION["email"] = htmlspecialchars($_POST["email"]);

    //textに入力間違いがないか確認
    if(!$_POST["text"]){
      $errmaessage = "お問い合わせ内容を入力して下さい。";
    }elseif(mb_strlen($_POST["text"]) > 500){ //500文字以内か確認
      $errmaessage[] = "お問い合わせ内容は500文字以内にして下さい。";
    }
      $_SESSION["text"] = htmlspecialchars($_POST["text"]);

      if($errmaessage){
        $select = "input";
      }else{
        $select = "confirm";
      }

  }elseif(isset($_POST["send"]) && $_POST["send"]){
    //送信完了後の処理
    //formの入力者に送るメール
    mb_language("ja");
    mb_internal_encoding('UTF-8');
  
    $send_to = $_SESSION['email'];
    $subject = "お問合せ内容"; //題名
    $message = "お問い合わせいただき、ありがとうございます。下記がお問合せフォームにご入力いただいた内容です。\r\n"
              ."名前:".$_SESSION["name"]."\r\n"
              ."email:".$_SESSION["email"]."\r\n"
              ."お問い合せ内容:".$_SESSION["text"]."\r\n";
    $headers = [
                'MIME-Version' => '1.0',
                'Content-Transfer-Encording' => '7bit',
                'Content-Type' => 'text/plain; charset=UTF-8',
                'Return-Path' => 'seturh@www1967.sakura.ne.jp',
                'From' => 'seturh@www1967.sakura.ne.jp',
                'Sender' => 'seturh@www1967.sakura.ne.jp',
                'To' => $_SESSION['email'],
                'Reply to' => 'seturh@www1967.sakura.ne.jp',
                'X-Sender' => 'seturh@www1967.sakura.ne.jp',
                'X-Priority' => '3',
              ];

    mail($send_to, $subject, $message, $headers);
   
    //formの入力者に送ったメールを自分に送る
    mb_language('ja');
    mb_internal_encoding('UTF-8');

    $send_to = "gray.901e@gmail.com";
    $subject = "お問合せ内容"; //題名
    $message = "お問い合わせいただき、ありがとうございます。下記がお問合せフォームにご入力いただいた内容です。\r\n"
              ."名前:".$_SESSION["name"]."\r\n"
              ."email:".$_SESSION["email"]."\r\n"
              ."お問い合せ内容:".$_SESSION["text"]."\r\n";
    $headers = [
                'MIME-Version' => '1.0',
                'Content-Transfer-Encording' => '7bit',
                'Content-Type' => 'text/plain; charset=UTF-8',
                'Return-Path' => 'seturh@www1967.sakura.ne.jp',
                'From' => 'seturh@www1967.sakura.ne.jp',
                'Sender' => 'seturh@www1967.sakura.ne.jp',
                'To' => "gray.901e@gmail.com",
                'Reply to' => 'seturh@www1967.sakura.ne.jp',
                'X-Sender' => 'seturh@www1967.sakura.ne.jp',
                'X-Priority' => '3',
              ];

    mail($send_to, $subject, $message, $headers);
  
    $_SESSION = array();
    $select = "send";

  }else{
    $_SESSION = array(); //セッション情報の初期化
  }
?>


<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatioble" content="IE=edge">
    <meta name="description" content="ポートフォリオ">
    <meta name="keywords" content="ポートフォリオ,エンジニア,自己紹介,スキル,成果物,コンタクト">

    <link rel="stylesheet" href="css/styles/bootstrap-reboot.css"> <!-- ノーマライズやリセットでブラウザーの記述を先にリセットしておく-->
    <link rel="stylesheet" href="../css/index.css">
   
      <title>ポートフォリオ</title>
    </head>

  <body>
      <main>
        <section id="contact">
            <?php if($select == "input"){ ?>  
              <!-- 入力画面 -->
              <?php
                //エラー画面が表示された時に画面に表示
                if($errmaessage){
                  echo '<div class="aleart aleart-danger" role="aleart">';
                  echo implode('<br>', $errmaessage); //implode() 配列要素を文字列と連結
                  echo '</div>';
                }
              ?>
              <form action="../index.html" method="POST"></form>

            <?php }elseif($select == "confirm"){?>
              <!-- 確認画面 -->
              <form action="./index.php" method="POST">
                    <!-- nameの入力内容を表示-->
                    名前:<?php echo $_SESSION["name"]?><br>
                    <!-- emailの入力内容を表示-->
                    E-mail:<?php echo $_SESSION["email"]?><br>
                    <!-- textの入力内容を表示-->
                    内容:<?php echo nl2br($_SESSION["text"])?><br> <!--  nl2brは本文中に改行が含まれている場合にHTMLの改行に変換する関数-->

                    <br>
                    <p>上記の入力内容で送信してもよろしいですか？</p>
                    <br>

                    <!-- onclick="history.back('index.html')"でメール送信前の画面に戻せる -->
                    <input class="button back" name= "back" type="button" onclick="history.back('index.html')" value="戻る">
                    <input class="button" name="send" type="submit" value="送信">
              </form>
            <?php }else{ ?>
              <!--完了画面へ-->
              <p>お問合せメールが送信完了しました。ご連絡いただき、ありがとうございます。</p>
            <?php } ?>
        </section>
      </main>

      <footer>
        <div>
          Copyright &copy;Port Forio All Rights Reserved.
        </div>
      </footer>
  </body>
</html>