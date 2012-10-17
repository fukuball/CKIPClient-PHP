# CKIPClient-PHP 中研院斷詞系統客戶端程式

自然語言處理系統最基本需要讓電腦能夠分辨文本中字詞的意義，才能夠更進一步發展出自然語言處理系統的相關演算法，其中斷詞處理便是一個重要的前置技術，而中研院的[斷詞系統](http://ckipsvr.iis.sinica.edu.tw/)便是一個處理中文斷詞的系統

重新撰寫中研院斷詞系統的客戶端程式，主要是想讓有中文斷詞需求的研究者或程式人員可以專注於開發自己的核心演算法，中研院官方提供的客戶端程式已有很長一段時間沒有更新維護，以我自己的經驗是用得非常不愉快， CKIPClient-PHP 可以將這些不愉快都趕走！

中文斷詞系統還有 [Stanford Word Segmenter](http://nlp.stanford.edu/software/segmenter.shtml) 這個選擇，不過需要先將文本轉成簡體字再給 Stanford Word Segmenter 進行斷詞才會有比較好的效果，但為了支持國產還是鼓勵大家多多使用中研院的斷詞系統，或許多多使用未來中研院的斷詞系統會就變得越來越好（？）

## 注意事項

### [申請帳號](http://ckipsvr.iis.sinica.edu.tw/)

請使用「線上服務申請」進行申請帳號的作業，由於中研院斷詞系統的網頁使用 frame 來寫，所以原諒我無法直接貼連結給各位，自行找「線上服務申請」這個連結吧！根據經驗申請作業需要幾個工作天，只能耐心等待了。

### 中研院斷詞系統每天上午六點進行系統維護

請注意中研院斷詞系統每天上午六點進行系統維護，每次維護期間大概半小時，這段時間請不要執行程式或是進行重要的排程工作，否則可能會得到非預期的結果。

### 擁有能夠執行 PHP 程式的環境

使用 CKIPClient-PHP 必須先在自己的機器上安裝好能夠執行 PHP 程式的環境。

## 使用方式

**CKIPClient-PHP** 提供 CKIPClient.php 作為串接[中研院斷詞系統](http://ckipsvr.iis.sinica.edu.tw/)的介面程式類別， ckip-test-driver.php 是簡單的範例程式，可以直接執行這支程式來觀察斷詞結果。

首先必須先將 CKIPClient.php 類別程式匯進需要使用到斷詞的 PHP 程式：

    require_once "CKIPClient.php";

接下來使用「線上服務申請」中取得的 server ip 、 server port 、 username 及 password 初始化 CKIPClient 物件：

    $ckip_client_obj = new CKIPClient(
        CKIP_SERVER,
        CKIP_PORT,
        CKIP_USERNAME,
        CKIP_PASSWORD
    );