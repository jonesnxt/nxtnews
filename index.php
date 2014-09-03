<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<script src="../jquery.js"></script>
<link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css"/>
<script type="text/javascript" src="ZeroClipboard.min.js"></script>
<title>NXT decentralized news</title>
</head>
<body>
<div class="container container-fluid" role="main">
	<div class="topbar">
<nav class="navbar navbar-default" role="navagation">
<div class="container-fluid">
<div class="navbar-header">
<a class="navbar-brand" href="https://www.jaft.pw/news">NXT News (BETA)</a>
</div>

</div></nav>

</div>


	
	
	<div class="col-md-12">	
			<div class="row">
				<div class="page-header text-center"><h2><small>Contribute with an AM to <span>NXT-NEWS-XDAE-AKPD-2H8H2</span>&nbsp;&nbsp;<button type='button' class='btn btn-default btn-sm btn-clip'>Copy</button></small></h2></div>
			</div>
			<?php
				
				function replace($text){
      $text = ereg_replace("www\.", "http://www.", $text);
      $text = ereg_replace("http://http://www\.", "http://www.", $text);
      $text = ereg_replace("https://http://www\.", "https://www.", $text);
      $exUrl = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";
      preg_match_all($exUrl, $text, $url);
      foreach($url[0] as $k=>$v) $text = str_replace($url[0][$k], '<a href="'.$url[0][$k].'" target="_blank" rel="nofollow">'.$url[0][$k].'</a>', $text);
      return $text;
    }
				// ok lets get some arbitrary messages
				function nxtapi($type, $attr)
				{
					return json_decode(file_get_contents("http://127.0.0.1:7876/nxt?requestType=".$type."&".$attr));
				}
				$msgs = nxtapi("getAccountTransactions", "account=NXT-NEWS-XDAE-AKPD-2H8H2&type=1&subtype=0");
				$counter = 15;
				foreach($msgs->transactions as $msg)
				{	
					if($counter-- == 0) break;
					if(isset($msg->attachment->message))
						$me = $msg->attachment->message;

					else if(isset($msg->attachment->encryptedMessage))
					{
						$me = nxtapi("readMessage", "transaction=".$msg->transaction."&secretPhrase=X51UOCT9YEC4DYJLR876V8G15SCUFVWY0RQ6XO72F1JTQQLK35")->decryptedMessage;
					}

					$name = "";
					$accd = nxtapi("getAccount", "account=".$msg->senderRS);
					if(isset($accd->name)) $name = "<strong>".$accd->name . "</strong> - <span>" . $msg->senderRS."</span>";
					else $name = "<strong><span>".$msg->senderRS."</span></strong>";
					?>
				<div class="col-md-10 col-md-offset-1">
					<div class="panel panel-primary">
						<div class="panel-heading">
					<?php
					echo "<h3 class='panel-title'>" . $name . "<button style='color: #31708F;' type='button' class='pull-right btn-clip'>Copy</button></h3>";
					 ?>
					 </div>
						<div class="panel-body">
					<p><?php


echo replace($me);
?></p>
					</div>
					</div>
				</div>
				
				<?php
				}

				?>
				
			
		</div>
	</div>

	    <script type="text/javascript">
      var client = new ZeroClipboard( $('.btn-clip') );

      client.on( 'ready', function(event) {
        // console.log( 'movie is loaded' );

        client.on( 'copy', function(event) {
          event.clipboardData.setData('text/plain', event.target.parentNode.getElementsByTagName("span")[0].innerHTML);
        } );

        client.on( 'aftercopy', function(event) {
          console.log('Copied text to clipboard: ' + event.data['text/plain']);
          event.target.innerHTML = "Copied...";
        } );
      } );

      client.on( 'error', function(event) {
        // console.log( 'ZeroClipboard error of type "' + event.name + '": ' + event.message );
        ZeroClipboard.destroy();
      } );
    </script>	
<?php include_once("../closing.php") ?>
</div>

</body>
</html>