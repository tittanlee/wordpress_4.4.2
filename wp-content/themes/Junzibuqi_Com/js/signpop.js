define(function (){

return {
	init: function (){
		var signHtml = '\
			<div class="sign">\
			    <div class="sign-mask"></div>\
			    <div class="container">\
			        <a href="#" class="close-link signclose-loader"><i class="fa fa-close"></i></a>\
			        <div class="sign-tips"></div>\
			        <form id="sign-in">  \
			            <h3><small class="signup-loader">切換註冊</small>登錄</h3>\
			            <h6>\
			                <label for="inputEmail">用戶名或郵箱</label>\
			                <input type="text" name="username" class="form-control" id="inputEmail" placeholder="用戶名或郵箱">\
			            </h6>\
			            <h6>\
			                <label for="inputPassword">密碼</label>\
			                <input type="password" name="password" class="form-control" id="inputPassword" placeholder="登錄密碼">\
			            </h6>\
			            <div class="sign-submit">\
			                <input type="button" class="btn btn-primary signsubmit-loader" name="submit" value="登錄">  \
			                <input type="hidden" name="action" value="signin">\
			                <label><input type="checkbox" checked="checked" name="remember" value="forever">記住我</label>\
			            </div>'+(jsui.url_rp ? '<div class="sign-info"><a href="'+jsui.url_rp+'">找回密碼？</a></div>' : '')+
			        '</form>\
			        <form id="sign-up"> \
			            <h3><small class="signin-loader">切換登錄</small>註冊</h3>\
			            <h6>\
			                <label for="inputName">暱稱</label>\
			                <input type="text" name="name" class="form-control" id="inputName" placeholder="設置暱稱">\
			            </h6>\
			            <h6>\
			                <label for="inputEmail">郵箱</label>\
			                <input type="email" name="email" class="form-control" id="inputEmail" placeholder="郵箱">\
			            </h6>\
			            <div class="sign-submit">\
			                <input type="button" class="btn btn-primary btn-block signsubmit-loader" name="submit" value="快速註冊">  \
			                <input type="hidden" name="action" value="signup">  \
			            </div>\
			        </form>\
			    </div>\
			</div>\
		'

	    jsui.bd.append( signHtml )

	    if( $('#issignshow').length ){
	        jsui.bd.addClass('sign-show')
	        // $('.close-link').hide()
	        setTimeout(function(){
	        	$('#sign-in').show().find('input:first').focus()
	        }, 300);
	        $('#sign-up').hide()
	    }


	    $('.signin-loader').on('click', function(){
	    	jsui.bd.addClass('sign-show')
	    	setTimeout(function(){
            	$('#sign-in').show().find('input:first').focus()
            }, 300);
            $('#sign-up').hide()
	    })

	    $('.signup-loader').on('click', function(){
	    	jsui.bd.addClass('sign-show')
	    	setTimeout(function(){
            	$('#sign-up').show().find('input:first').focus()
            }, 300);
            $('#sign-in').hide()
	    })

	    $('.signclose-loader').on('click', function(){
	    	jsui.bd.removeClass('sign-show')
	    })

		$('.sign-mask').on('click', function(){
	    	jsui.bd.removeClass('sign-show')
	    })

	    $('.sign form').keydown(function(e){
			var e = e || event,
			keycode = e.which || e.keyCode;
			if (keycode==13) {
				$(this).find('.signsubmit-loader').trigger("click");
			}
		})

	    $('.signsubmit-loader').on('click', function(){
	    	if( jsui.is_signin ) return
                    
            var form = $(this).parent().parent()
            var inputs = form.serializeObject()
            var isreg = (inputs.action == 'signup') ? true : false

            if( !inputs.action ){
                return
            }

            if( isreg ){
            	if( !is_mail(inputs.email) ){
	                logtips('郵箱格式錯誤')
	                return
	            }

                if( !/^[a-z\d_]{3,20}$/.test(inputs.name) ){
                    logtips('暱稱是以字母數字下劃線組合的3-20位字符')
                    return
                }
            }else{
            	if( inputs.password.length < 6 ){
	                logtips('密碼太短，至少6位')
	                return
	            }
            }

            $.ajax({  
                type: "POST",  
                url:  jsui.uri+'/action/log.php',  
                data: inputs,  
                dataType: 'json',
                success: function(data){  
                    // console.log( data )
                    if( data.msg ){
                        logtips(data.msg)
                    }

                    if( data.error ){
                        return
                    }

                    if( !isreg ){
                        location.reload()
                    }else{
                        if( data.goto ) location.href = data.goto
                    }
                }  
            });  
	    })

		var _loginTipstimer
		function logtips(str){
		    if( !str ) return false
		    _loginTipstimer && clearTimeout(_loginTipstimer)
		    $('.sign-tips').html(str).animate({
		        height: 29
		    }, 220)
		    _loginTipstimer = setTimeout(function(){
		        $('.sign-tips').animate({
		            height: 0
		        }, 220)
		    }, 5000)
		}

	}
}

})