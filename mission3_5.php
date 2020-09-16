<!DOCTYPE html>
<head>
  <meta charset="UTF-8">
  <title>mission3_5</title>
</head>
<body>
    <?php
          $editname = "名前を入れて下さい";
          $editcmt = "コメントを入れて下さい";
          $edit = 0;
          
          if($_SERVER["REQUEST_METHOD"] === "POST") {
          
            $name = $_POST["name"];
            $cmt = $_POST["cmt"];
            $dele = $_POST["dele"];
            $edit = $_POST["edit"];
            $id = $_POST["id"];
            $sbm_pw = $_POST["sbm_pw"];
            $dele_pw = $_POST["dele_pw"];
            $edit_pw = $_POST["edit_pw"];
            $filename = "mission3_5.before.txt";
            $date=date("Y年m月d日 H時i分s秒");
          
            if(isset($_POST["edit_btn"])) {
                // echo "編集モード"."<br>"; //PHP_EOLではうまく行かなかった。
                if ($edit && $edit_pw === "pass") { // $edit_pw にした理由：３つともpwにすると、$pw = $_POST["pw"]; の得る値が一番最後のeditのpwになってしまう。
                    $fl=file($filename,FILE_IGNORE_NEW_LINES);
                    foreach($fl as $fline) {
                        $flconv=mb_convert_encoding($fline,"utf-8"); //文字化け防止
                        $flstr=explode("<>",$flconv);
                        if($flstr[0] === $edit) {
                          $editname=$flstr[1];
                          $editcmt=$flstr[2];
                        }else {
                            // echo "error";
                        }
                    }
                }else {
                    // echo "Edit Number Error or Passward Error";
                }
                
            }elseif(isset($_POST["dele_btn"])) {
                // echo "削除モード"."<br>"; 
                if($dele && $dele_pw === "pass") {
                    $fl=file($filename,FILE_IGNORE_NEW_LINES);
                    $fpw=fopen($filename,"w");
                    foreach($fl as $fline) {
                        $flconv=mb_convert_encoding($fline,"utf-8");
                        $flstr=explode("<>",$flconv);
                        if($flstr[0] === $dele) {
                            fwrite($fpw,"削除されました".PHP_EOL); //$fpwは$filenameを上書きする。そしてfcloseをしない限り、追加で書き込みが行われるので、$fpwでオッケイ
                        }else {
                            fwrite($fpw,"$fline".PHP_EOL);
                        }
                    }
                }else {
                    // echo "Delete Number Error or Passward Error";
                }
            }elseif (isset($_POST["sbm_btn"])) {
                if($id) {
                    echo "編集モード"."<br>";
                    $fpa=fopen($filename,"a");
                    $fl=file($filename,FILE_IGNORE_NEW_LINES);
                    $fledit="$id<>$name<>$cmt<>$date";
                    $fl[$id-1] = str_replace($fl[$id-1],$fledit,$fl[$id-1]); //入れ替え関数
                    $fpw=fopen($filename,"w");
                    foreach ($fl as $fline) {
                        fwrite($fpw,"$fline".PHP_EOL);
                    }
                    fclose($fpa);
                }else {
                    echo "新規投稿モード"."<br>";
                    if ($name && $cmt && $sbm_pw === "pass") {
                        $fpa=fopen($filename,"a");
                        $num=count(file($filename))+1;
                        fwrite($fpa,"$num<>$name<>$cmt<>$date".PHP_EOL);
                        fclose($fpa);
                    }else {
                        // echo "No name or No comment or Passward Error";
                    }
                }
            }else {
                // echo "ボタンを押して下さい";
            }
        }else {
            // echo "button error";
        }
    ?>
  <form action = "" method = "post">
    <input type = "hidden" name = "id" value = "<?=$edit?>">
    <br>
    <h5>  [投稿フォーム]</h5>
    名前:       <input type = "text" name = "name" placeholder = "<?=$editname?>">
    <br>
    コメント:   <input type = "text" name = "cmt" placeholder = "<?=$editcmt?>">
    <br>
    パスワード: <input type = "password" name = "sbm_pw">
    <button type = "submit" name ="sbm_btn">送信</button>
    <br>
    <h5>  [削除フォーム]</h5>
    削除番号:   <input type = "text" name = "dele">
    <br>
    パスワード: <input type = "password" name = "dele_pw">
    <button type = "submit" name ="dele_btn">削除</button>
    <br>
    <h5>  [編集フォーム]</h5>
    編集番号:   <input type = "text" name = "edit">
    <br>
    パスワード: <input type = "password" name = "edit_pw">
    <button type = "submit" name ="edit_btn">編集</button>
  </form>
    <?php
        echo "<br> <hr>";
        if($_SERVER["REQUEST_METHOD"] === "POST") {
          if(isset($_POST["sbm_btn"])) {
            if($name) {
                
            }else {
                echo "<font color='red'><br> ------  Error: Name is empty  ------ <br></font>";
            }
            if($cmt) {
                
            }else {
                echo "<font color='red'><br> ------  Error: Comment is empty  ------ <br></font>";
            }
            if($sbm_pw === 'pass') {
                
            }else {
                echo "<font color='red'><br> ------  Error: Password is not correct  ------ <br></font>";
            }
          }elseif (isset($_POST["dele_btn"])) {
              if($dele) {
                  
              }else {
                  echo "<font color='red'><br> ------  Error: Delete Number is empty  ------ <br></font>";
              }
              if($dele_pw === 'pass') {
                  
              }else {
                  echo "<font color='red'><br> ------  Error: Password is not correct  ------ <br></font>";
              }    
          }elseif (isset($_POST["edit_btn"])) {
              if($edit) {
                  
              }else {
                  echo "<font color='red'><br> ------  Error: Edit Number is empty  ------ <br></font>";
              }
              if($edit_pw === 'pass') {
                  
              }else {
                  echo "<font color='red'><br> ------  Error: Password is not correct  ------ <br></font>";
              }
          }else {
              
          }
          echo "<br> <hr> <br>";
          echo " [投稿一覧] <br><br>";
          $fl = file($filename,FILE_IGNORE_NEW_LINES); //ここで更新しないと、最新の$filenammeをfile関数として使えない。
          foreach($fl as $fline) {
              $flconv = mb_convert_encoding($fline,"utf-8"); //https://www.sejuku.net/blog/24369
              $flstr = explode("<>",$flconv);
              echo $flstr[0].' '; 
              echo $flstr[1].' '; 
              echo $flstr[2].' '; 
              echo $flstr[3].'<br>'; 
          }
        }else {

        }
    ?>    
</body>
</html>