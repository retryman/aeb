<?php
/**
 +---------------------------------
 * 功能：随机生成10个百分数，其和为1
 * @auathor beatyou385981202
 * @time 2012-6-15
 +---------------------------------
 */

print_r(percentage_num());

function percentage_num()
{	
//随机生成的百分数存放位置
$arr_num = array();

//初始化第一个值的范围
$num = 100;

for($i=1;$i<10;$i++)
{
$arr_num[$i] = random_num($num);
$num = $num - $arr_num[$i];
}

//最后一个百分数，用100减去前5个和
for($i=1;$i<10;$i++)
{	
$add_num += $arr_num[$i];
}

$arr_num[10] = 100 - $add_num;

return $arr_num;
}

function random_num($num)
{
return rand(1,$num/2.5);
  //这里将其随机生成的范围缩小，是为了得到结果更加理想
}
?>