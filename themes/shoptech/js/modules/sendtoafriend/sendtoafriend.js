$(document).ready(function(){$.prototype.fancybox&&$("#send_friend_button").fancybox({hideOnContentClick:!1}),$("#send_friend_form_content .closefb").click(function(e){$.fancybox.close(),e.preventDefault()}),$("#sendEmail").click(function(){var e=$("#friend_name").val(),n=$("#friend_email").val();e&&n&&!isNaN(id_product)?$.ajax({url:baseDir+"modules/sendtoafriend/sendtoafriend_ajax.php?rand="+(new Date).getTime(),type:"POST",headers:{"cache-control":"no-cache"},data:{action:"sendToMyFriend",secure_key:stf_secure_key,name:e,email:n,id_product:id_product},dataType:"json",success:function(e){$.fancybox.close(),fancyMsgBox(e?stf_msg_success:stf_msg_error,stf_msg_title)}}):$("#send_friend_form_error").text(stf_msg_required)})});