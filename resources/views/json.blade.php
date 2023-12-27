<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
        <!-- テキストを表示する場所 -->
        <div id="textDisplay"></div>

        <!-- スクリプト -->
        <script>
            // ページ読み込み後に実行される部分
            window.onload = function() {
                // 表示するテキスト
                var text = "Hello World!";
    
                // テキストを表示するための要素を取得
                var displayElement = document.getElementById("textDisplay");
    
                // テキストを表示する
                displayElement.innerText = text;
            };
        </script>
    
</body>
</html>