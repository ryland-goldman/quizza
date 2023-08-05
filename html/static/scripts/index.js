    // runs on page load
    function onload_1() {
      for (var i = 0; i < subjects.length-1; i++) { // loop over each item
        (function(index) {
          $("#"+subjects[index]+"-B").hide(); // hide the row

          // get classes through AJAX
          $.get("/docs/lib/getClass.php?subj="+subjects[index], function(d,s){
            $("#"+subjects[index]+"-B .classes").html(d);
          });
        })(i);

      }
    }
    function onload_2(){

      $("#fav-B").show();

      // attempt to render sign in button if it exists
      try {
          render_gSignIn();
      } catch (e) {}

    }
    function onload_3(){
      for(var i=0;i<subjects.length;i++){
        (function(index) {
          var row = "#" + subjects[index] + "-B";
            $("#" + subjects[index] + "-H").click(function() {
              $(row).toggle(); // toggle it when clicked
            });
        })(i);
      }
    }

    onload_1();
    setTimeout(onload_2, 1000);
    onload_3();

    $("#search-home").focus(function(event){
      $(".resultscontainer").show();
    });

    $("#search-home").blur(function(event){
      setTimeout(function(){$(".resultscontainer").hide();},100);
    });

    $('#search-home').keyup(function(event) {
      var val = this.value;
      $.get("/docs/lib/searchClasses.php?query="+encodeURIComponent(val), function(data, status){
        try {var results = JSON.parse(data);}
        catch {
          $(".resultscontainer").html("");
          return;
        }
        var results_str = "";
        for(var i=0;i<results.length && i<5;i++){
          var id = 'resultscontainer-'+i;
          if(results.length >= 2 && i==0){ id = 'resultscontainer-div-first'; }
          if(results.length >= 2 && i==results.length-1){ id = 'resultscontainer-div-last'; }
          if(results.length >= 2 && i==4){ id = 'resultscontainer-div-last'; }
          results_str += "<a href='"+results[i][1]+"'><div id='"+id+"'>"+results[i][0]+"</div></a>";
        }
        $(".resultscontainer").html(results_str);
      });
    });