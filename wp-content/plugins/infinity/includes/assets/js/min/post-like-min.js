!function($){$(document).ready(function(){$("body").on("click",".vb-post-like",function(a){a.preventDefault();var i=$(this);i.find(".fa-heart").hide();var e=i.data("post_id");i.html("<i id='icon-like' class='fa fa-heart'></i><i id='icon-gear' class='fa fa-circle-o-notch fa-spin'></i>"),$.ajax({type:"post",url:ajax_var.url,data:"action=vb-post-like&nonce="+ajax_var.nonce+"&vb_post_like=&post_id="+e,success:function(a){if(-1!==a.indexOf("already")){var e=a.replace("already","");"0"===e&&(e="Like"),i.prop("title","Like"),i.removeClass("liked"),i.html("<i id='icon-unlike' class='fa fa-heart-o'></i>&nbsp;"+e)}else i.prop("title","Unlike"),i.addClass("liked"),i.html("<i id='icon-like' class='fa fa-heart'></i>&nbsp;"+a)}})})})}(jQuery);