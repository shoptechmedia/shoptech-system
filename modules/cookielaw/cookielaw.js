		$(document).ready(function(){
      if(!$.totalStorage('iqiteucookie'))
        $("#cookielaw").show();

           $("#cookie_close").click(function (event) {
               event.preventDefault();
               $("#cookielaw").fadeOut(400);
               setcook();
           });


       });
		
        function setcook() {
            $.totalStorage('iqiteucookie', true);
            var name = 'cookielaw_module';
            var value = '1';
            var expire = new Date();
            expire.setMonth(expire.getMonth()+12);
            document.cookie = name + "=" + escape(value) +";path=/;" + ((expire==null)?"" : ("; expires=" + expire.toGMTString()))
        }

        
        
        