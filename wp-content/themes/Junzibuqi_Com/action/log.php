<?php
if( !$_POST && !$_POST['action'] ){
    exit;
}

include 'load.php';

if( !_hui('user_page_s') ){
    exit;
}

$ui = array();
foreach ($_POST as $key => $value) {
    $ui[$key] = esc_sql(trim($value));
}

if( !$ui['action'] ){
    exit;
}

// print_r($ui);

switch ($ui['action']) {
    case 'signin':
        if( is_user_logged_in() ) {
            print_r(json_encode(array('error'=>1, 'msg'=>'你已經登錄')));
            exit;
        }

        if ( !filter_var($ui['username'], FILTER_VALIDATE_EMAIL) ){
            $user_data = get_user_by('login', $ui['username']);
            if (empty($user_data)){
                print_r(json_encode(array('error'=>1, 'msg'=>'用戶名或密碼錯誤')));  
                exit();  
            }
        }else{
            $user_data = get_user_by('email', $ui['username']);
            if (empty($user_data)){
                print_r(json_encode(array('error'=>1, 'msg'=>'郵箱或密碼錯誤')));  
                exit();  
            }
        }

        $username = $user_data->user_login;
    
        if($ui['remember']) $ui['remember'] = "true";  
        else $ui['remember'] = "false";  

        $login_data = array(
            'user_login' => $username,
            'user_password' => $ui['password'],
            'remember' => $ui['remember']
        ); 

        $user_verify = wp_signon( $login_data, false );   

        if ( is_wp_error($user_verify) ){
            print_r(json_encode(array('error'=>1, 'msg'=>'用戶名/郵箱或密碼錯誤')));  
            exit();  
        }

        print_r(json_encode(array('error'=>0, 'msg'=>'成功登錄，頁面跳轉中')));
        exit();  
        

        break;

    case 'signup':
        if( is_user_logged_in() ) {
            print_r(json_encode(array('error'=>1, 'msg'=>'你已經登錄')));
            exit;
        }

        if( !preg_match('/^[a-z\d_]{3,20}$/i', $ui['name']) ) {  
            print_r(json_encode(array('error'=>1, 'msg'=>'暱稱是以字母數字下劃線組合的3-20位字符')));  
            exit();  
        } 

        if ( !filter_var($ui['email'], FILTER_VALIDATE_EMAIL) ){ 
            print_r(json_encode(array('error'=>1, 'msg'=>'郵箱格式錯誤')));  
            exit();  
        }

        /*if( sstrlen($ui['password'])<6 ) {  
            print_r(json_encode(array('error'=>1, 'msg'=>'密碼太短')));  
            exit();
        }*/

        /*if( is_disable_username($ui['name']) ){
            print_r(json_encode(array('error'=>1, 'msg'=>'暱稱含保留或非法字符，換一個再試')));  
            exit();
        }*/

        /*if( $ui['password'] !== $ui['password2'] ) {  
            print_r(json_encode(array('error'=>1, 'msg'=>'兩次密碼輸入不一致')));  
            exit();
        }*/
  
        $random_password = wp_generate_password( 12, false );  
        // $uname = 'u'.get_millisecond().rand(1000,9999);
        $status = wp_create_user( $ui['name'], $random_password , $ui['email'] );  

        if ( is_wp_error($status) ){
            $err = $status->errors;
            // print_r($err);
            if( !empty($err['existing_user_login']) ){
                print_r(json_encode(array('error'=>1, 'msg'=>'用戶名已存在，換一個試試')));  
                exit();
            }else if( !empty($err['existing_user_email']) ){
                print_r(json_encode(array('error'=>1, 'msg'=>'郵箱已存在，換一個試試')));  
                exit();
            }
            print_r(json_encode(array('error'=>1, 'msg'=>'註冊失敗，請稍後再試')));  
            exit();
        }

        /*if( $status ){
            // update_user_meta($status, 'nickname', $ui['name']);
            wp_update_user(array(
                'ID' => $status,
                'display_name' => $ui['name']
            ));

            $login_data = array(
                'user_login' => $ui['name'],
                'user_password' => $ui['password'],
                'remember' => true
            ); 

            $user_verify = wp_signon( $login_data, true );   

            _moloader('mo_get_user_page', false);

            print_r(json_encode(array('error'=>0, 'goto'=>mo_get_user_page())));  
        }
        exit();*/

        $from = get_option('admin_email');  
        $headers = 'From: '.$from . "\r\n";  
        $subject = '您已成功註冊成為'.get_bloginfo('name').'用戶';  
        $msg = '用戶名：'.$ui['name']."\r\n".'密碼：'.$random_password."\r\n".'網址：'.get_bloginfo('url');

        /*print_r($subject);
        print_r($msg);
        die;*/
        if( wp_mail( $ui['email'], $subject, $msg, $headers ) ){
            print_r(json_encode(array('error'=>0, 'msg'=>'密碼已發送到您的郵箱，請前去查收')));  
        }else{
            print_r(json_encode(array('error'=>1, 'msg'=>'密碼郵件發送失敗，請聯繫網站管理員'))); 
        }

        exit();
        
        break;

    case 'password':
        if( !is_user_logged_in() ) {
            print_r(json_encode(array('error'=>1, 'msg'=>'必須登錄才能操作')));
            exit;
        }

        if( !$ui['passwordold'] && !$ui['password'] && !$ui['password2'] ){
            print_r(json_encode(array('error'=>1, 'msg'=>'密碼不能為空'))); 
            exit();
        }

        if( strlen($ui['password'])<6 ) {  
            print_r(json_encode(array('error'=>1, 'msg'=>'密碼至少6位')));  
            exit();
        }

        if( $ui['password'] !== $ui['password2'] ) {  
            print_r(json_encode(array('error'=>1, 'msg'=>'兩次密碼輸入不一致')));  
            exit();
        }

        if( $ui['passwordold'] == $ui['password'] ) {  
            print_r(json_encode(array('error'=>1, 'msg'=>'新密碼和原密碼不能相同')));  
            exit();
        }

        $uid = get_current_user_id();

        global $wp_hasher;
        require_once( ABSPATH.WPINC.'/class-phpass.php' );
        $wp_hasher = new PasswordHash(8, TRUE);

        if(!$wp_hasher->CheckPassword($ui['passwordold'], $current_user->user_pass)) {
            print_r(json_encode(array('error'=>1, 'msg'=>'原密碼錯誤')));  
            exit(); 
        }

        require_once( ABSPATH.WPINC.'/registration.php' );
        $status = wp_update_user( 
            array (
                'ID' => $uid,
                'user_pass' => $ui['password']
            ) 
        );

        if( is_wp_error($status) ){
            print_r(json_encode(array('error'=>1, 'msg'=>'修改失敗，請稍後再試')));  
            exit(); 
        }
        
        print_r(json_encode(array('error'=>0)));  
        exit(); 
        

        break;

    default:
        # code...
        break;
}

exit();
