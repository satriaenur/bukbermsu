<base href="<?= $this->config->item('base_url') ?>" />
<script type="text/javascript" src="<?php echo $this->config->item('js_path');?>swfobject.js"></script>

<script type="text/javascript">
swfobject.embedSWF(
"<?php echo $this->config->item('swf_path');?>open-flash-chart.swf", "test_chart", "650", "200",
"9.0.0", "expressInstall.swf",
{"data-file":"<?php echo urlencode($data_url);?>"},{"wmode":"transparent"}
);
</script>

<div align="center" id="test_chart">&nbsp;</div>

<?php 
$uid = $this->session->userdata('id_user');
$inbox = $this->Message_model->get_messages(array('type' => 'inbox', 'uid' => $uid))->num_rows();
$outbox = $this->Message_model->get_messages(array('type' => 'outbox', 'uid' => $uid))->num_rows();
$sentitems = $this->Message_model->get_messages(array('type' => 'sentitems', 'uid' => $uid))->num_rows();
$trash_inbox = $this->Message_model->get_messages(array('type' => 'inbox', 'id_folder' => '5', 'uid' => $uid))->num_rows();
$trash_sentitems = $this->Message_model->get_messages(array('type' => 'sentitems', 'id_folder' => '5', 'uid' => $uid))->num_rows();
$trash = $trash_inbox + $trash_sentitems;
?>

<div style="float: left; width: 200px;">
<h4><?php echo lang('kalkun_folder');?>: </h4>
<p><span><?php echo lang('kalkun_inbox');?>:</span> <?php echo $inbox;?></p>
<p><span><?php echo lang('kalkun_outbox');?>:</span> <?php echo $outbox;?></p>
<p><span><?php echo lang('kalkun_sentitems');?>:</span> <?php echo $sentitems;?></p>
<p><span><?php echo lang('kalkun_trash');?>:</span> <?php echo $trash;?></p>
</div>

<div style="float: left; width: 250px;">
<h4><?php echo lang('kalkun_myfolder');?>: </h4>
<?php  
foreach($this->Kalkun_model->get_folders('all')->result() as $val):
$folder_count_inbox = $this->Message_model->get_messages(array('type' => 'inbox', 'id_folder' => $val->id_folder))->num_rows();
$folder_count_sentitems = $this->Message_model->get_messages(array('type' => 'sentitems', 'id_folder' => $val->id_folder))->num_rows();
$folder_count = $folder_count_inbox + $folder_count_sentitems;
echo "<p><span>".$val->name.": </span>".$folder_count."</p>";
endforeach;	
?>
</div>

<div style="float: left; width: 200px;">
<h4><?php echo lang('kalkun_phonebook');?>: </h4>
<p><span><?php echo lang('kalkun_contact');?>: </span>
<?php echo  $this->Phonebook_model->get_phonebook(array('option' => 'all'))->num_rows();?></p>
<p><span><?php echo lang('kalkun_group');?>: </span>
<?php echo  $this->Phonebook_model->get_phonebook(array('option' => 'group'))->num_rows();?></p>
</div>

<div style="clear: both;">&nbsp;</div>