(function($) {
  "use strict"; // Start of use strict

  // Toggle the side navigation
  $("#sidebarToggle, #sidebarToggleTop").on('click', function(e) {
    $("body").toggleClass("sidebar-toggled");
    $(".sidebar").toggleClass("toggled");
    if ($(".sidebar").hasClass("toggled")) {
      $('.sidebar .collapse').collapse('hide');
    };
  });

  // Close any open menu accordions when window is resized below 768px
  $(window).resize(function() {
    if ($(window).width() < 768) {
      $('.sidebar .collapse').collapse('hide');
    };
    
    // Toggle the side navigation when window is resized below 480px
    if ($(window).width() < 480 && !$(".sidebar").hasClass("toggled")) {
      $("body").addClass("sidebar-toggled");
      $(".sidebar").addClass("toggled");
      $('.sidebar .collapse').collapse('hide');
    };
  });

  // Prevent the content wrapper from scrolling when the fixed side navigation hovered over
  $('body.fixed-nav .sidebar').on('mousewheel DOMMouseScroll wheel', function(e) {
    if ($(window).width() > 768) {
      var e0 = e.originalEvent,
        delta = e0.wheelDelta || -e0.detail;
      this.scrollTop += (delta < 0 ? 1 : -1) * 30;
      e.preventDefault();
    }
  });

  // Scroll to top button appear
  $(document).on('scroll', function() {
    var scrollDistance = $(this).scrollTop();
    if (scrollDistance > 100) {
      $('.scroll-to-top').fadeIn();
    } else {
      $('.scroll-to-top').fadeOut();
    }
  });

  // Smooth scrolling using jQuery easing
  $(document).on('click', 'a.scroll-to-top', function(e) {
    var $anchor = $(this);
    $('html, body').stop().animate({
      scrollTop: ($($anchor.attr('href')).offset().top)
    }, 1000, 'easeInOutExpo');
    e.preventDefault();
  });
  //datepicker
  $("#datepicker,#datepickere").on('click', function(e) {
    $(this).datepicker( {
      format: 'yyyy-mm',
      startDate:'2020-01',
      endDate:'2020-07',
      startView: "months", 
      minViewMode: "months"
    });
    $(this).datepicker('show');
  });


  $("#tableStart,#tableEnd").on('click', function(e) {
    $(this).datepicker( {
      format: 'yyyy-mm-dd',
      startDate:'2020-01-01',
      endDate:'2020-06-30'
    });

    $(this).datepicker('show');
  });



  $("#scountry,#smain").on('change',function(e){
    var id=$(this).attr("id");
    var val = $(this).val();
    var temp="<option>-</option>"
    var output;
    if (id=="scountry"){
      output={
        "南投縣":["草屯鎮"],
        "台中市":["大雅區","西區","霧峰區","南屯區","北區","大里區","南區","北屯區","大甲區","東區","西屯區","中區","烏日區","豐原區"],
        "台北市":["松山區","信義區","中山區","南港區","內湖區","士林區"],
        "台南市":["永康區","仁德區","東區","佳里區","西港區"],
        "屏東縣":["恆春鎮","春日鄉","九如鄉","潮州鎮","東港鎮","屏東市"],
        "彰化縣":["和美鎮","二林鎮","田中鎮","N/A"],
        "新北市":["汐止區","樹林區","永和區","瑞芳區","新店區","土城區","蘆洲區","林口區","鶯歌區","泰山區","三峽區","中和區","新莊區","五股區","板橋區","三重區","N/A"],
        "新竹縣":["湖口鄉","竹北市","竹東鎮"],
        "桃園市":["龜山區","八德區","中壢區","桃園區"],
        "苗栗縣":["苑裡鎮"],
        "雲林縣":["北港鎮","水林鄉"],
        "高雄市":["鼓山區","三民區","六龜區","鳳山區","苓雅區","湖內區","林園區","前鎮區"]
      };
    }
    else{
      output={
        "中藥":["科學中藥","廣告藥","外用製劑","傳統中藥"],
        "其他":["資訊器材","贈品","其他費用","雜類","美工設計","N/A"],
        "婦嬰":["童車大型玩具","嬰童保養","嬰童清潔用品","嬰兒食品","哺乳用品","06大類金額入部門","禮盒組合","孕產婦女用品","嬰用百貨","文具玩具"],
        "美清":["緊實除皺","體香除毛","男士清潔保養","基礎清潔保養","身體 私密清保","美容美髮器材","油痘粉刺","美白淡斑","頭皮清潔保養","防曬修護","04大類金額入部門","胸部保養","局部雕塑","妊娠保養","彩妝","美髮造型"],
        "藥品":["呼吸道","胃、腸、肝、膽","中樞神經","營養素、輸液、電解質","外科用藥","化學治療劑","心臟血管、血液","內分泌","雜項藥物","解熱止痛肌肉","01大類金額入部門","泌尿系統","N/A"],
        "食品":["健康食品","休閒食品","10大類金額入部門","一般食品","N/A"],
        "保健食品":["胃.腸.肝.膽","解熱止痛","眼科","腦部代謝","其他","泌尿、腎","營養素","呼吸道","新陳代謝、內分泌","免疫療法","心臟血管,血液","骨科","減肥.美容"],
        "奶粉尿褲":["嬰幼米麥精粉","羊奶","成人奶粉","成人尿褲","液體奶水","嬰幼特殊","嬰幼奶粉","嬰兒尿褲","成人麥粉麥片","N/A"],
        "日用百貨":["居家清潔","環境衛生","口腔保健","棉製品","個人用品","寵物用品","紙類製品","家庭用品","05大類金額入部門","衛生棉","衣物清潔","N/A"],
        "醫療器材":["眼部用品","醫療器材","化工","家庭計劃用品","外科用品","外傷敷料","調劑用品","照護用品"]
      };
    }
    for(var i in output[val]){
      temp=temp+"<option>"+output[val][i]+"</option>"
    }
    if (id=="scountry"){
      $("#stown").html(temp);
      $('#stown').selectpicker('refresh');
    }
    else{
      $("#smiddle").html(temp);
      $('#smiddle').selectpicker('refresh');
    }
  });

  $("#smiddle").on('change',function(e){
    $.get("db/side_bar.php",{smiddle:$("#smiddle").val()},function (data){
      var temp="<option>-</option>"
      for (var i in data){
        temp=temp+"<option>"+data[i]['detail']+"</option>";
      }
      $("#sdetail").html(temp);
      $('#sdetail').selectpicker('refresh');
    });
  });

  $("#select").on('change',function(e){
    var val = $(this).val();
    var temp="<option>-</option>";
    for(var i in val){
      if (val[i]!="Percentage(Profit)")
        temp=temp+"<option>"+val[i]+"</option>";
    }
    $("#order").html(temp);
    $('#order').selectpicker('refresh');
  });
  
  $("#send,#sendTable").on('click', function(e) {
    var start,end,sarea,scountry,stown,smain,smiddle,sdetail,group,order,limit;
    var select;
    var temp;
    var id=$(this).attr("id");
    sarea=$("#sarea").val();
    scountry=$("#scountry").val();
    stown=$("#stown").val();
    smain=$("#smain").val();
    smiddle=$("#smiddle").val();
    sdetail=$("#sdetail").val();
    if(id=="sendTable"){
      temp=$( "#tableStart" ).val();

      temp=temp.replace(/-/g,"");
      start=parseInt(temp);
      temp=$( "#tableEnd" ).val();
      temp=temp.replace(/-/g,"");
      end=parseInt(temp);
      group=$("#group").val();
      order=$("#order").val();
      limit=$("#limit").val();
      select=$("#select").val().join();
      document.location.href= "tables.php?start="+start+"&end="+end+
      "&area="+sarea+"&country="+scountry+"&town="+stown+
      "&main="+smain+"&middle="+smiddle+"&detail="+sdetail+
      "&select="+select+"&group="+group+"&order="+order+"&limit="+limit;
    }
    else{
      temp=$( "#datepicker" ).val();
      temp=temp.replace("-","")+"01";
      start=parseInt(temp);
      //start=parseInt(temp[2])*(10**4)+parseInt(temp[0])*(10**2)+parseInt(temp[1]);
      temp=$( "#datepickere" ).val();
      temp=temp.replace("-","")+"99";
      end=parseInt(temp);  
      document.location.href=
      "index.php?start="+start+"&end="+end+"&area="+sarea+"&country="+scountry+"&town="+stown+"&main="+smain+"&middle="+smiddle+"&detail="+sdetail;
    }
  });
  $("#sendSeat").on('click',function(e){
    var start,end,sstore,smain,smiddle,sdetail;
    sstore=($("#sstore").val()).match(/\d+/);
    if (sstore ==null) sstore='-';
    smain=$("#smain").val();
    smiddle=$("#smiddle").val();
    sdetail=$("#sdetail").val();
    start=$( "#datepicker" ).val();
    end=$( "#datepickere" ).val();
    document.location.href=
      "seatmap.php?start="+start+"&end="+end+"&store="+sstore+"&main="+smain+"&middle="+smiddle+"&detail="+sdetail;
  });

})(jQuery); // End of use strict
