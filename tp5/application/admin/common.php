<?php

// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件

  /**
   *  2014-08-25
   *  描述：PHP邮件发送
   *  使用PHPMailer类
   *  发送附件,多人发送
   *  发送附件
   *  发送附件的时候，鉴于本地网络和服务器的速度，如不能正常上传，修改php配置文件中的memory_limit限制
   *  其他可能的限制post_max_size  upload_max_filesize
   *  也可能要将max_execution_time修改
   *  请使用前确认发送邮件的邮箱帐号开启了SMTP
   */ 

                             //如果上传附件卡，将脚本执行限制时间修改为0
    include_once  'PHPMailer.php';
    include_once 'SMTP.php';
     function mailto($to,$subject, $content)
     {
     	$mail = new PHPMailer(true);
     try {
        $mail->SMTPDebug = 0;                                 // Enable verbose debug output
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'smtp.163.com';  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = 'lx5566lh@163.com';                 // SMTP username
        $mail->Password = 'huanxiao123';                           // SMTP password
        $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 465;                                    // TCP port to connect to
        $mail->CharSet = 'utf-8';

        //Recipients
        $mail->setFrom('lx5566lh@163.com', '梦中程序员');
        $mail->addAddress($to);
        //Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body    = $content;

        return $mail->send();
    }catch (Exception $e) {
        exception($mail->ErrorInfo(), 1001);
    }
   } 
   function replace($data)
   {
   	return str_replace('span', 'a', $data);
   }
?>
