<?php
class logger
{
	public $log_file;
	function writelog($logstr,$logfrom='unknown')
	{date_default_timezone_set("Asia/Shanghai");
		if(flock($this->log_file, LOCK_EX | LOCK_NB))
		{
			$now=gettimeofday();
			fwrite($this->log_file, date('Y-m-d H:i:s',$now['sec']).'|'.$now['usec'].'|'.$logfrom.'|'.$logstr."||\n");
			flock($this->log_file,LOCK_UN);
			return 0;
		}
		else return -1;
	}
	function __construct($log_url) 
	{
		if (file_exists($log_url))
		$this->log_file=fopen($log_url,'ab+');
		else $this->log_file=fopen($log_url,'wb+');
	}
	function __destruct()
	{
		fclose($this->log_file);
	}
	function getlog()
	{date_default_timezone_set("Asia/Shanghai");
	$now=gettimeofday();
		echo  date('Y-m-d H:i:s',$now['sec']).'|'.$now['usec'];
		$log_array=array();
		flock($this->log_file, LOCK_SH);
	//	$log=fread($this->log_file,20971520);//最大日志文件大小20M
		while (!feof($this->log_file)) 
		{
			$line = stream_get_line($this->log_file, 1000000, "||");
			array_push($log_array,$line);
		}
		flock($this->log_file,LOCK_UN);
		$now=gettimeofday();
		echo '<br>';
		echo date('Y-m-d H:i:s',$now['sec']).'|'.$now['usec'];

//		$log_array=explode("||",$log);
		$report=array();
		while ($log_line=array_pop($log_array))
		{
			$log_inf=explode('|',$log_line);
			$log_time=strtotime($log_inf[0]);
			if ((isset($log_inf[2]))&&($log_inf[2]=="SQL-QUERY"))
			{
				$report[$log_time]=(isset($report[$log_time]))?$report[$log_time]+1:1; 
			}
			if ((isset($log_inf[0]))&&($log_time<time()-260)) break;
		}
//		var_dump($report);
$now=gettimeofday();
		echo '<br>';
		echo date('Y-m-d H:i:s',$now['sec']).'|'.$now['usec'];
				echo '<br>';


	}
	function getlogdata($long=300,$type='SQL-QUERY',$length=60)
	{
			$log_array=array();
		date_default_timezone_set("Asia/Shanghai");
		flock($this->log_file, LOCK_SH);
		//$log=fread($this->log_file,20971520);//最大日志文件大小20M
		while (!feof($this->log_file)) 
		{
			$line = stream_get_line($this->log_file, 1000000, "||");
			array_push($log_array,$line);
		}
		flock($this->log_file,LOCK_UN);
//		$log_array=explode("||",$log);
		$report=array();
		while ($log_line=array_pop($log_array))
		{
			$log_inf=explode('|',$log_line);
			$log_time=strtotime($log_inf[0]);
			if ((isset($log_inf[2]))&&($log_inf[2]==$type))//&&(strtotime($log_inf[0])>=$time))
			{
				$report[$log_time]=(isset($report[$log_time]))?$report[$log_time]+1:1; 
			}
			if ((isset($log_inf[0]))&&($log_time<time()-$long)) break;
		}

		$report_plotdata=array();
		$long+=1;
		for ($i=0;$i<$long;$i++)
		{
			$report_plotdata[$i]=array(($i%($length)==0)?date('H:i:s',time()-$i):'',0);
		}
		$j=0;
		foreach ($report as $key=>$line)
		{

			//array_push($report_plotdata	,array(($i%5==0)?date('H:i:s',$key):'',$line));
			$array=array(($j%30==0)?date('H:i:s',$key):'',$line);
			//echo 300-time()+$key.'<br>';
			if (isset($report_plotdata[time()-$key]))
			{
				$report_plotdata[time()-$key][1]=$line;
			}
			$j++;
		}

		return $report_plotdata;

	}

}