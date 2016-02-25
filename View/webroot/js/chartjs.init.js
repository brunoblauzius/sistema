/**
 * Created by westilian on 1/19/14.
*/ 

(function(){
    var t;
    
    function size(animate, json){
        if (animate == undefined){
            animate = false;
        }
        clearTimeout(t);
        t = setTimeout(function(){
            $("canvas").each(function(i,el){
                $(el).attr({
                    "width":$(el).parent().width(),
                    "height":$(el).parent().outerHeight()
                });
            });
            redraw(animate, json);
            var m = 0;
            $(".chartJS").height("");
            $(".chartJS").each(function(i,el){ m = Math.max(m,$(el).height()); });
            $(".chartJS").height(m);
        }, 30);
    }
    
    function redraw(animation, json){
        var options = {};
        if (!animation){
            options.animation = false;
        } else {
            options.animation = true;
        }

        var barChartData = json;
        var myLine = new Chart(document.getElementById("bar-chart-js").getContext("2d")).Bar(barChartData);

    }
           
          
        $.ajax({
            url: web_root + 'Reservas/graficoReservasConvidados',
            data:{},
            dataType:'json',
            type:'get',
            success: function (json) {
                
                $(window).on('resize', function(){ size(false, json); });
                size(true, json);
                
            }
        });

        
          
}());
