<?php
/**
 * 关闭博客插件
 * design by Amanda
 */

!defined('EMLOG_ROOT') && exit('access deined!');

function plugin_setting_view()
{
	include(EMLOG_ROOT.'/content/plugins/closed-master/closed-master_config.php');
?>

<style type="text/css">
.table_b { float:left;border-collapse: collapse;border-style: none; border:1px solid #ccc; width:100%;}
.table_b td { border:1px solid #e0e0e0; padding:2px 5px; line-height:22px; }
</style>

<script type="text/javascript">
$(function(){
$("#closed").addClass('sidebarsubmenu1');
})
</script>
<div class="heading-bg  card-views">
<ul class="breadcrumbs">
<li><a href="./"><i class="fa fa-home"></i> 首页</a></li>
<li class="active">博客状态设置</li>
</ul>
</div>
<?php if(isset($_GET['setting'])):?>
<div class="actived alert alert-success alert-dismissable">
<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
插件设置完成
</div>
<?php endif;?>
<div class="row">
<div class="col-lg-12">
<div class="panel panel-default card-view">
<div class="panel-body"> 
提示：请确保本插件目录及closed_config.php文件据有读写权限（777）。
</div>
<div class=line></div>
<?php
if (CLOSED_YN == "Y") {
        $now = "关闭，非管理员无法访问博客";
        if (MCLOSED_YN == "N") {//手机版状态显示
                $mnow = "关闭，非管理员无法访问博客";
        } else if (MCLOSED_YN == "Y") {
                $mnow = "开启，所有用户可正常访问博客";
        }
} else {
        $now = "开启，所有用户可正常访问博客";
        $mnow = "无效";
}
?>
<div class="form-group">
    <label>博客目前状态为:</label>
<font color=red><?php echo $now; ?></font>
  </div>
<div class="form-group">
    <label>手机版目前状态为:</label>
<font color=red><?php echo $mnow; ?></font>
  </div>  


<form id="form1" name="form1" method="post" action="plugin.php?plugin=closed-master&action=setting">

<div class="form-group">
    <label>是否关闭博客访问:</label>
<select name="yn">
	<option value="Y" <?php echo $ex1; ?>>是</option>
	<option value="N" <?php echo $ex2; ?>>否</option>
</select>
  </div>  

<div class="form-group">
    <label>否允许手机版访问:<font color=red>提示：需要在m/view/header.php里面的 < /head> 上面添加挂载点&nbsp;doAction('index_mhead')</font></label>
<select name="myn">
        <option value="Y" <?php echo $ex3; ?>>是</option>
        <option value="N" <?php echo $ex4; ?>>否</option>
</select>
  </div>  
<div class="form-group">
    <label>博客关闭原因说明:</label>
<input type="input" name="be" id="post" value="<?php echo CLOSED_BE; ?>" class="form-control"/>
  </div>  
<div class="form-group" style="padding-top:10px">

	<input name="input" class="btn btn-info" type="submit" value="保存设置" />
</div>

</form>
</div>

<?php
}

function plugin_setting()
{
	//修改配置信息
	$fso = fopen(EMLOG_ROOT.'/content/plugins/closed-master/closed-master_config.php','r'); //获取配置文件内容
	$config = fread($fso,filesize(EMLOG_ROOT.'/content/plugins/closed-master/closed-master_config.php'));
	fclose($fso);

	$yn=htmlspecialchars($_POST['yn'], ENT_QUOTES);
	$myn=htmlspecialchars($_POST['myn'], ENT_QUOTES);
	$be=htmlspecialchars($_POST['be'], ENT_QUOTES);

	$patt = array(
	"/define\('CLOSED_YN',(.*)\)/",
	"/define\('MCLOSED_YN',(.*)\)/",
	"/define\('CLOSED_BE',(.*)\)/",
	);

	$replace = array(
	"define('CLOSED_YN','".$yn."')",
	"define('MCLOSED_YN','".$myn."')",
	"define('CLOSED_BE','".$be."')",
	);

	$new_config = preg_replace($patt, $replace, $config);
	$fso = fopen(EMLOG_ROOT.'/content/plugins/closed-master/closed-master_config.php','w'); //写入替换后的配置文件
        if(!$fso) {
            emMsg('操作失败，请确保插件目录(/content/plugins/closed-master/)可写');
        }
	fwrite($fso,$new_config);
	fclose($fso);
}
?>
<script>
$("#menu_mg").addClass('active');
$("#menu_close").addClass('active-page');
</script>
