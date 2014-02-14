
<?php
	date_default_timezone_set("America/New_York");
	$schedule;
	$people;
	$fp=fopen("schedule.txt","r");
	flock($fp,LOCK_SH);
	while($fp&&!feof($fp))
	{
		$schedule[]=new TimeSlot(fgets($fp));	
	}
	flock($fp,LOCK_UN);
	fclose($fp);
	
	$fd=fopen("users.txt","c+");
	flock($fd,LOCK_SH);
	$buffer=fgets($fd);
	while($buffer!=null)
	{
		
		$people[]=new User($buffer);
		$buffer=fgets($fd);
	}
	flock($fd,LOCK_UN);
	fclose($fd);
	
	
	class User
	{
		private $times=array();
		private $name;
		public function __construct($str)
		{
			if(isset($str))
			{
				$arr=explode("^",$str);
				if(isset($arr[0])&&isset($arr[1]))
				{
					$this->name=$arr[0];
					$this->times=explode("|",$arr[1]);
				}
			}
		}
		public function name()
		{
			return $this->name;	
		}
		public function timeSlots()
		{
			if(isset($this->times))
				return $this->times;
		}
		public function __toString()
		{
		
				return (string)$this->name;
		}
	
		
	}
	class TimeSlot
	{
		protected $day;
		protected $dates;
		protected $count;
		public $times=array();
		public function __construct($str)
		{
			if(isset($str))
			{
				$s=explode("^",$str);
				$this->dates=$s[0];
				if(isset($s[1]))
				{
					$this->times=explode("|",$s[1]);
					$this->count=count($this->times);
				}
			}
		}
		public function getTimes()
		{
			$time_arr=array();
			foreach($this->times as $time)
			{
				$time_arr[]=date("l\nm/d/y\ng:i A",strtotime(($this->dates)."".$time));
			}
			return $time_arr;	
		}
		public function __toString()
		{
			return $this->day." ".$this->dates." ".$this->times;
		}
	}

?>


