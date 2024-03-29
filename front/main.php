<style>
    .lists {
        position: relative;
        left: 114px;
        width: 200px;
        height: 240px;
        overflow: hidden;
    }

    .item * {
        box-sizing: border-box;
    }

    .item {
        width: 200px;
        height: 240px;
        margin: auto;
        position: absolute;
        box-sizing: border-box;
        display: none;

    }

    .item div img {
        width: 100%;
        height: 220px;
    }

    .item div {
        text-align: center;
    }

    .left,
    .right {
        width: 0px;
        border: 20px solid black;
        border-top-color: transparent;
        /* border-right-color: green; */
        border-bottom-color: transparent;
    }

    .left {
        border-left-width: 0;
    }

    .right {
        border-right-width: 0;
    }

    .btns {
        width: 360px;
        height: 100px;
        /* background-color: lightcyan; */
        display: flex;
        overflow: hidden;

        /* background-color: lightblue; */
    }

    .btns img {
        width: 60px;
        height: 80px;
    }

    .btn {
        font-size: 12px;
        text-align: center;
        flex-shrink: 0;
        width: 90px;
        position: relative;



    }

    .controls {
        width: 420px;
        height: 100px;
        position: relative;
        margin-top: 10px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
</style>
<div class="half" style="vertical-align:top;">
    <h1>預告片介紹</h1>
    <div class="rb tab" style="width:95%;">
        <div class="lists">
            <!-- 項目 -->
            <?php
            $posters = $Poster->all(['sh' => 1], " order by rank");
            foreach ($posters as $idx => $poster) {
            ?>
                <div class="item" data-ani=<?=$poster['ani'];?>>
                    <div><img src="./img/<?= $poster['img']; ?>" alt="">
                </div>
                    <div><?= $poster['name']; ?></div>
                </div>
            <?php
            }
            ?>
        </div>

        <!-- 預告片下半部 -->
        <div class="controls">
            <div class="left"></div>
            <div class="btns">
                <?php
                foreach ($posters as $idx => $poster) {
                ?>
                    <div class="btn">
                        <div><img src="./img/<?= $poster['img']; ?>"></div>
                        <div><?= $poster['name']; ?></div>
                    </div>
                <?php
                }
                ?>
            </div>
            <div class="right"></div>
        </div>
    </div>

</div>
<script>
    $(".item").eq(0).show(); //只顯示一張預告片
    let total=$(".btn").length;
    let now = 0;
    let next = 0;
    let timer = setInterval(() => {slide()}, 3000) //每隔3秒執行slide  
    function slide(n) {//n=>指定下一張要換的圖
        let ani =$(".item").eq(now).data("ani");
            if(typeof(next)!=='undefined'){
                next= now+1;
                    if(next>=total){
                        next=0;
                    }
            }else{
                next=n;
            }

        switch (ani){
            case 1:
                $(".item").eq(now).fadeOut(1000,function(){
                    $(".item").eq(next).fadeIn(1000);
                });
            break;
            case 2:
                $(".item").eq(now).hide(1000,function(){
                    $(".item").eq(next).show(1000);
                });
            break;
            case 3:
                $(".item").eq(now).slideUp(1000,function(){
                    $(".item").eq(next).slideDown(1000);
                });

            break;
        }
        now=next;

    }


   
    let p = 0;
    // console.log(total)
    $(".left,.right").on("click", function() { //class是left和right，當click時
        let arrow = $(this).attr('class'); //找到元件的屬性
        switch (arrow) {
            case "right": //點right這個屬性時，會+1
                if (p + 1 <= (total - 4)) {
                    p = p + 1;
                }
                break;
            case "left": //點right這個屬性時，會-1
                if (p - 1 >= 0) {
                    p = p - 1;
                }
                break;
        }
        $(".btn").animate({
            right: 90 * p
        })
    })

    //4-5當訪客點選按鈕列之按鈕時，能切換相對應預告片海報圖片及名片
    $(".btn").on("click",function(){//當滑鼠點擊時，就跳到指定的那張圖。
        let idx=$(this).index()
        slide(idx);
        console.log("idx",idx)
    })

    $(".btns").hover(//滑鼠移進時，停止動畫
        function(){
            clearInterval(timer); //刪除這個動畫
        },
        function(){
        timer = setInterval(() => {slide()}, 3000) //每隔3秒執行slide  

        }
    )

</script>


<!--//=====院線片清單=====-->

















<style>
    .movies {
        display: flex;
        flex-wrap: wrap;
    }

    .movie {
        display: flex;
        flex-wrap: wrap;
        box-sizing: border-box;
        padding: 2px;
        margin: 0.5%;
        border: 1px solid #ccc;
        border-radius: 5px;
        width: 49%;
    }
</style>
<div class="half">
    <h1>院線片清單</h1>
    <div class="rb tab" style="width:95%;">
        <div class="movies">
            <?php
            $today = date("Y-m-d");
            $ondate = date("Y-m-d", strtotime("-2 days"));
            $total = $Movie->count(" where `ondate`>='$ondate'  && `ondate` <='$today'  && `sh`=1");
            $div = 4;
            $pages = ceil($total / $div);
            $now = $_GET['p'] ?? 1;
            $start = ($now - 1) * $div;
            $movies = $Movie->all(" where `ondate`>='$ondate'  && `ondate` <='$today'  && `sh`=1 order by rank limit $start,$div");
            foreach ($movies as $movie) {
            ?>
                <div class="movie">
                    <div style="width:35%">
                        <a href='?do=intro&id=<?= $movie['id']; ?>'>
                            <img src="./img/<?= $movie['poster']; ?>" style="width:60px;border:3px solid white">
                        </a>
                    </div>
                    <div style="width:65%">
                        <div><?= $movie['name']; ?></div>
                        <div style="font-size:13px;">分級: <img src="./icon/03C0<?= $movie['level']; ?>.png" style="width:20px"></div>
                        <div style="font-size:13px;">上映日期:<?= $movie['ondate']; ?></div>
                    </div>
                    <div style="width:100%">
                        <button onclick="location.href='?do=intro&id=<?= $movie['id']; ?>'">劇情介紹</button>
                        <button onclick="location.href='?do=order&id=<?= $movie['id']; ?>'">線上訂票</button>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
        <div class="ct">
            <?php
            if ($now - 1 > 0) {
                $prev = $now - 1;
                echo "<a href='?p=$prev'> < </a>";
            }

            for ($i = 1; $i <= $pages; $i++) {
                echo "<a href='?p=$i'> $i </a>";
            }

            if ($now + 1 <= $pages) {
                $next = $now + 1;
                echo "<a href='?p=$next'> > </a>";
            }
            ?>

        </div>
    </div>
</div>