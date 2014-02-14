<?php
	if(isset($_GET["count"]))
	{
		setcookie($_GET["count"],$_GET["count"],0,'/~cnc34/','cs1520.cs.pitt.edu');
		
	}
	if(isset($_POST["name"]))
	{
		
		$fd=fopen("users.txt",'a');
		flock($fd,LOCK_EX);
		if(isset($_POST["name"])&&isset($_GET["count"]))
		{
			fwrite($fd,$_POST["name"]."^");
			for($c=0;$c<($_GET['sched']);$c++):
				if(isset($_POST[$c])):
					fwrite($fd,$c."|");
				endif;
				
			endfor;
			flock($fd,LOCK_UN);
			fclose($fd);
			unset($fd);
			$fd=fopen("users.txt","r+");
			flock($fd,LOCK_EX);
			fseek($fd,-1,SEEK_END);
			fwrite($fd,"\n");
			flock($fd,LOCK_UN);
			fclose($fd);
				
		}
	}
	else if(isset($_POST["newname"])&&isset($_GET["edit"]))
	{
	
		$fd=fopen("users.txt",'r');
		flock($fd,LOCK_EX);
		$lines=array();
		while($lines[]=fgets($fd));
		
		$z=0;
		foreach($lines as $key=>$line):
			if($z==$_GET["edit"]):
				$lines[$key]=$_POST["newname"]."^";
				
				for($l=0;$l<$_GET["count"];$l++):
					if(isset($_POST[$l]))
						$lines[$key]=$lines[$key].$_POST[$l]."|";
				endfor;
				$lines[$key]=rtrim($lines[$key],"|");
				$lines[$key]=$lines[$key]."\n";
			endif;
			$z++;
		endforeach;
		flock($fd,LOCK_UN);
		fclose($fd);
		$fd=fopen("users.txt","w");
		flock($fd,LOCK_EX);
		foreach($lines as $line):
			fwrite($fd,$line);
		endforeach;
		flock($fd,LOCK_UN);
		fclose($fd);
		
		
	}
	include "index.php";
?>
