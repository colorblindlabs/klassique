<?php
	require 'SMTP/config.php';
	//GET VARIABLES OF CONTACT FORM
	$to = $emailmembername;
	//define the subject of the email
	$subject = $confirmemailtext_deli;
	//create a boundary string. It must be unique
	//so we use the MD5 algorithm to generate a random hash
	$random_hash = md5(date('r', time()));
	//define the headers we want passed. Note that they are separated with \r\n
	$headers = $email_from;
	//add boundary string and mime type specification
	$headers.= "\r\nContent-Type: text/html; boundary=\"PHP-alt-".$random_hash."\"";
	$headers.= "MIME-version: 1.0\n";
	$headers.= "Content-type: text/html; charset= iso-8859-1\n";
	//define the body of the message.
	ob_start(); //Turn on output buffering
	?>

    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
		"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
		
	<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title><?php echo $nameconfig ;?></title>
	<style type="text/css"> 
	
	    /* Client-specific Styles */
        #outlook a{padding:0;} /* Force Outlook to provide a "view in browser" button. */
        body{width:100% !important;} .ReadMsgBody{width:100%;} .ExternalClass{width:100%;} /* Force Hotmail to display emails at full width */
        body{-webkit-text-size-adjust:none; -ms-text-size-adjust:none;} /* Prevent Webkit and Windows Mobile platforms from changing default font sizes. */

        /* Reset Styles */
        body{margin:0; padding:0; font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#333;}
        img{height:auto; line-height:100%; outline:none; text-decoration:none;}
        #backgroundTable{height:100% !important; margin:0; padding:0; width:100% !important;}

	   
	   p {
	       margin: 1em 0;
	   }
	      
	   
	   h1, h2, h3, h4, h5, h6 {
	       color: #555 !important;
	       line-height: 100% !important;
	   }
	   
	   h1 a, h2 a, h3 a, h4 a, h5 a, h6 a {
	       color: #1694B9 !important;
	   }
	   
	   h1 a:active, h2 a:active,  h3 a:active, h4 a:active, h5 a:active, h6 a:active {
   	       color: #1694B9 !important; /* Preferably not the same color as the normal header link color.  There is limited support for psuedo classes in email clients, this was added just for good measure. */
   	   }
	   
	   h1 a:visited, h2 a:visited,  h3 a:visited, h4 a:visited, h5 a:visited, h6 a:visited {
	       color: #1694B9 !important; /* Preferably not the same color as the normal header link color. There is limited support for psuedo classes in email clients, this was added just for good measure. */
	   }
	   
	   
       table td {
           border-collapse:collapse;
       }
       
       .yshortcuts, .yshortcuts a, .yshortcuts a:link,.yshortcuts a:visited, .yshortcuts a:hover, .yshortcuts a span 
	   { color: black; text-decoration: none !important; border-bottom: none !important; background: none !important;} 
	   
	   #grey-wrap {}
	   #grey-wrap h1 {font-size:18px; text-shadow:0 1px 1px #fff; color:#1694B9 !important;}
	   #grey-wrap p {line-height:1.5em; margin:0; margin-bottom:10px;}
	   #white-wrap {background:#fff; margin-bottom:10px;}
	   .nuke-table {margin-bottom:10px; font-weight:bold;}
	   .small {font-size:10px; color:#555;}
       </style>
</head>
<body>
    <table cellpadding="0" cellspacing="0" border="0" width="100%">
    	<tr>
        	<td style="padding:10px;">
            
            	<table width="100%">
                    <tr>
                        <td width="100%" style="padding-left:20px; padding-top:20px;">
                       
                      		 <a href="<?php echo $WEBSITE_NAME;?>" title="" target="_blank">
								<img src="<?php echo $UPLOAD_FOLDER;?><?php echo $picconfig;?>" alt="<?php echo $nameconfig;?>" width="200" style="display:block; margin-bottom:1px;" title="" />
                            </a>
                      </td>
                    </tr>
                </table>
            
                <table cellpadding="0" cellspacing="0" border="0" id="grey-wrap" width="650">
                    <tr>
                        <td style="padding:25px; padding-top:5px;">
							 <h1 style="color:#1694B9;">aaaa</h1>
							
							 <table cellpadding="0" cellspacing="0" border="0" id="white-wrap" bgcolor="#ffffff" style="margin-bottom:10px;" width="100%">
                                <tr>
                                    <td style="padding:2px;">
									
                                       <p>Dear <?php echo $member_name;?></p>
                                       
                                       <p>Your order has been sent to:</p>
                                       
                                       <p>Shipping Address:</p>
                                       
                                       <p>
										   <?php echo'<strong>'.$row['nama_penerima'].'</strong> '.$Phonelabel.'<br />';?>
                                               <?php
                                                       echo $row['address_penerima'].'<br />';
                                                       echo getnamegeneral("ongkir","nama_kota",$row['kota_penerima']).', '. $row['kabupaten_penerima'].'<br />';
                                                       echo $row['provinsi_penerima'].' - '.$row['country_penerima'];				
                                               ?> 
                                       </p>
                                       
                                       <p><span style="display:inline-block; width:150px;">ORDER ID</span> : <strong style="font-size:15px;"><?php echo sprintf('%06d',$ordidmm);?></strong></p>  
                                       
                                       <p><span style="display:inline-block; width:150px;">TOTAL AMOUNT</span> : <strong style="font-size:15px;">IDR <?php echo number_format($totalamount);?></strong></p>
                                       
                                       <p><span style="display:inline-block; width:150px;">COURIER</span> : <strong style="font-size:15px;"><?php echo $row['kurir'];?></strong></p>  
                                       
                                       <?php if($no_resinumber!=""):?> 
                                       	<p><span style="display:inline-block; width:150px;">NO. RESI</span> : <strong style="font-size:15px;"><?php echo $no_resinumber;?></strong></p>  
                                       <?php endif;?>
                                       
										<p><br /><br />Cheers, </p>
                                        <p><strong><?php echo $nameconfig;?></strong></p>
                                    </td>
                                </tr>
                            </table><!-- #white-wrap -->  
                        </td>
                    </tr>
                </table>
    		</td>
    	</tr>
    </table>
    <!-- End of wrapper table -->
</body>
</html>
<?php
	//copy current buffer contents into $message variable and delete current output buffer
    $message = ob_get_clean();
    //send the email
    //$mail_sent = @mail( $to, $subject, $message, $headers );
    $mail->setFrom('herman@nukegraphic.com', 'Klassique');
	$mail->addAddress($emailmembername);			// Add a recipient
	//$mail->AddCC("ranto@nukegraphic.com");	
	$mail->isHTML(true);										// Set email format to HTML
	$mail->Subject = $subject;
	$mail->msgHTML($message);

	if(!$mail->send()) {
		//echo 'Message could not be sent.';
		echo 'Mailer Error: ' . $mail->ErrorInfo;
		die();
	} else {
		echo 'Message has been sent';
	}
?>