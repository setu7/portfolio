/* header menuにスムーススクロールを追加 */
$(function(){
  /* <a>リンクをクリックした時 */
  $('a[href^="#"]').click(function(){
    /* スクロールの速さ */
    let speed = 300;
    /* attr()は選択された要素の属性の値を受け取り、それを使用する*/
    let href = $(this).attr("href"); 
    /* リンク先を取得 */
    let target = $(href == "#" || href == "" ? 'html' :href);
    /* headerからリンク先までの距離を取得 */
    let position = target.offset().top - 70;
    /* スムーススクロールのアニメーション */
    $("html, body").animate({scrollTop:position}, speed, "swing");
    return false;
  });
});


/*  skillのグラフを作成 レーダーチャート */
/* skill  プログラミングの技術力*/

let ctx = document.getElementById('myChart').getContext('2d');
let myRadarChart = new Chart(ctx, {
  type: 'radar',
  data: {
    labels: ["HTML/CSS","jQuery","JavaScript","Sass","PHP / Python"],
    datasets:[{
      label:'言語の理解',
      data: [50,20,40,30,20],
      backgroundColor: 'RGBA(225,95,150,0.2)', /* 水色 */
      borderColor: 'RGBA(225,95,159,1)', /* 勿忘草色 */
      borderWidth:1,
      pointBackgroundColor: 'RGB(225,106,177)'
    }]
  },
  options:{
    title: {
      display: true,
      text: '使用した経験がある言語'
    },
    responsive: false, /* canvasのサイズをdivで設定して変更できる */
    mainAspectRatio:false,
    scale:{
      ticks:{
        suggestedMax: 100,
        suggestedMin: 0,
        stepSize: 20,
      }
    }
  }
})

/* pastime 趣味*/

let ctx2 = document.getElementById('myChart2').getContext('2d');
let myRadarChart2 = new Chart(ctx2, {
  type: 'radar',
  data: {
    labels: ["アニメ鑑賞","カラオケ","和菓子を食べる","音楽を聴く","漫画・小説を読む"],
    datasets:[{
      label:'趣味の優先度',
      data: [80,50,40,70,70],
      backgroundColor: 'RGBA(187,226,232,0.3)',
      borderColor: 'RGBA(135,195,233,1)',
      borderWidth:1,
      pointBackgroundColor: 'RGB(135,195,233)'
    }]
  },
  options:{
    title: {
      display: true,
      text: '趣味'
    },
    responsive: false, /* canvasのサイズをdivで設定して変更できる */
    mainAspectRatio:false,
    scale:{
      ticks:{
        suggestedMax: 100,
        suggestedMin: 0,
        stepSize: 20,
      }
    }
  }
})


/* pagetop return button*/

$(function () {
  let pagetop = $('#pagetop');
  //ボタンを表示
  pagetop.hide();

  // 100px スクロールしたら、ボタンを表示
  $(window).scroll(function () {
    if ($(this).scrollTop() > 100){
      pagetop.fadeIn();
    } else {
      pagetop.fadeOut();
    }
  });

  //スクロールするときの時間間隔を設定 スムーススクロールのアニメーション
  pagetop.click(function () {
    $('body, html').animate({ scrollTop: 0 }, 500);
    return false;
  });
});
