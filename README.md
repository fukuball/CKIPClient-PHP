# CKIPClient-PHP 中研院斷詞系統客戶端程式

[![Build Status](https://travis-ci.org/fukuball/CKIPClient-PHP.png?branch=master)](https://travis-ci.org/fukuball/CKIPClient-PHP)
[![Coverage Status](https://coveralls.io/repos/fukuball/CKIPClient-PHP/badge.png?branch=master)](https://coveralls.io/r/fukuball/CKIPClient-PHP?branch=master)
[![Latest Stable Version](https://poser.pugx.org/fukuball/ckip-client-php/v/stable.png)](https://packagist.org/packages/fukuball/ckip-client-php)

自然語言處理系統最基本需要讓電腦能夠分辨文本中字詞的意義，才能夠更進一步發展出自然語言處理系統的相關演算法，其中斷詞處理便是一個重要的前置技術，而中研院的[斷詞系統](http://ckipsvr.iis.sinica.edu.tw/)便是一個處理中文斷詞的系統

重新撰寫中研院斷詞系統的客戶端程式，主要是想讓有中文斷詞需求的研究者或程式人員可以專注於開發自己的核心演算法，中研院官方提供的客戶端程式已有很長一段時間沒有更新維護，以我自己的經驗是用得非常不愉快， CKIPClient-PHP 可以將這些不愉快都趕走！

中文斷詞系統還有 [Stanford Word Segmenter](http://nlp.stanford.edu/software/segmenter.shtml) 這個選擇，不過需要先將文本轉成簡體字再給 Stanford Word Segmenter 進行斷詞才會有比較好的效果，但為了支持國產還是鼓勵大家多多使用中研院的斷詞系統，或許多多使用未來中研院的斷詞系統會就變得越來越好（？）

## Demo

### [線上中文斷詞](http://www.fukuball.com/ckip-client/)

## 注意事項

### [申請帳號](http://ckipsvr.iis.sinica.edu.tw/)

請使用「[線上服務申請](http://ckipsvr.iis.sinica.edu.tw/)」進行申請帳號的作業，由於中研院斷詞系統的網頁使用 frame 來寫，所以原諒我無法直接貼連結給各位，自行找「線上服務申請」這個連結吧！根據經驗申請作業需要幾個工作天，只能耐心等待了。

### 中研院斷詞系統每天上午六點進行系統維護

請注意中研院斷詞系統每天上午六點進行系統維護，每次維護期間大概半小時，這段時間請不要執行程式或是進行重要的排程工作，否則可能會得到非預期的結果。

### 不要一次送出大量資料，也不要密集送出資料

這點是我個人經驗，若一次送出大量資料，得到的回傳 xml 會不完整，造成 parse error，所以我會先自行將文章進行斷句（利用標點符號斷句），再送出給斷詞系統。也請注意不要密集送出資料給中研院斷詞系統，否則會暫時被鎖住帳號，可以在每次送出資料後，讓 script sleep 幾秒鐘，如此就不會被鎖住帳號了。如何自行斷句送出資料給斷詞系統可參考：[schedule-ckip-test-driver.php](https://github.com/fukuball/CKIPClient-PHP/blob/master/schedule-ckip-test-driver.php)

### 擁有能夠執行 PHP 程式的環境

使用 CKIPClient-PHP 必須先在自己的機器上安裝好能夠執行 PHP 程式的環境。

## 使用方式

**CKIPClient-PHP** 提供 CKIPClient.php 作為串接[中研院斷詞系統](http://ckipsvr.iis.sinica.edu.tw/)的介面程式類別， ckip-test-driver.php 是簡單的範例程式，可以直接執行這支程式來觀察斷詞結果。

首先必須先將 CKIPClient.php 類別程式匯進需要使用到斷詞的 PHP 程式：

    require_once "src/CKIPClient.php";

接下來使用「線上服務申請」中取得的 server ip 、 server port 、 username 及 password 初始化 CKIPClient 物件：

    $ckip_client_obj = new CKIPClient(
        CKIP_SERVER,
        CKIP_PORT,
        CKIP_USERNAME,
        CKIP_PASSWORD
    );

再來就可以使用 CKIPClient 物件來處理斷詞了，將需要斷詞的文件組成如下格式：

    $raw_text = "獨立音樂需要大家一起來推廣，\n".
                "歡迎加入我們的行列！\n";
    $return_text = $ckip_client_obj->send($raw_text);

上述的範例中，我有進行前處理將文件分段，這樣斷詞出來的效果會比較好，使用一整個文件進行斷詞也可以的，但是建議一個句子（標點符號之間的字數）不要超過 80 個字：

    $raw_text = "獨立音樂需要大家一起來推廣，歡迎加入我們的行列！";
    $return_text = $ckip_client_obj->send($raw_text);

經過上述步驟之後就可以進行回傳文件的剖析，可以得到文件的斷句結果也可以得到文件的斷詞結果：

取得斷句結果

    $return_sentences = $ckip_client_obj->getSentence();
    print_r($return_sentences);

斷句結果會取得一個斷句陣列：

    Array
    (
        [0] => 　獨立(Vi)　音樂(N)　需要(Vt)　大家(N)　一起(ADV)　來(ADV)　推廣(Vt)　，(COMMACATEGORY)
        [1] => 　歡迎(Vt)　加入(Vt)　我們(N)　的(T)　行列(N)　！(EXCLAMATIONCATEGORY)
    )

取得斷詞結果

    $return_terms = $ckip_client_obj->getTerm();
    print_r($return_terms);

斷詞結果會取得一個斷詞陣列，其中 term 代表斷詞， tag 代表斷詞的詞性，如動詞、名詞等等，詳細詞性列表可參考[中研院斷詞系統](http://ckipsvr.iis.sinica.edu.tw/)：

    Array
    (
        [0] => Array
            (
                [term] => 獨立
                [tag] => Vi
            )
        [1] => Array
            (
                [term] => 音樂
                [tag] => N
            )
        [2] => Array
            (
                [term] => 需要
                [tag] => Vt
            )
        [3] => Array
            (
                [term] => 大家
                [tag] => N
            )
        [4] => Array
            (
                [term] => 一起
                [tag] => ADV
            )
        [5] => Array
            (
                [term] => 來
                [tag] => ADV
            )
        [6] => Array
            (
                [term] => 推廣
                [tag] => Vt
            )
        [7] => Array
            (
                [term] => ，
                [tag] => COMMACATEGORY
            )
        [8] => Array
            (
                [term] => 歡迎
                [tag] => Vt
            )
        [9] => Array
            (
                [term] => 加入
                [tag] => Vt
            )
        [10] => Array
            (
                [term] => 我們
                [tag] => N
            )
        [11] => Array
            (
                [term] => 的
                [tag] => T
            )
        [12] => Array
            (
                [term] => 行列
                [tag] => N
            )
        [13] => Array
            (
                [term] => ！
                [tag] => EXCLAMATIONCATEGORY
            )
    )

## License

Released under the [MIT License](http://opensource.org/licenses/MIT).


## Contact

若有任何問題可以與我聯繫，也歡迎大家幫忙修正 CKIPClient-PHP ！

* Twitter: [@fukuball](https://twitter.com/fukuball)
* Gmail: fukuball@gmail.com