<?php print_r($ret); ?>
<?php print_r($ok); ?>
<?php print_r($success); ?>
<?php echo $header; ?><?php echo $column_left; ?>

<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-banner" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
	<div class="panel panel-default mvps-wrap">
      <div class="panel-heading">
        <h3 class="panel-title"><?php echo $table_header; ?></h3>
		<table style="width: 100%;">
			<thead>
				<tr>
					<td><?php echo $table_id;?></td>
					<td><?php echo $table_name;?></td>
					<td><?php echo $table_image;?></td>
					<td><?php echo $table_text;?></td>
					<td><?php echo $table_edit;?></td>
					<td><?php echo $table_delete;?></td>
				</tr>
			</thead>
		<?php if(!$comments) { echo "no comments"; } ?>
		<?php foreach ($comments as $comment) { ?>
			<tr>
				<td class="comment-id"><?php echo $comment['id']; ?></td>
				<td class="comment-name"><?php echo $comment['name']; ?></td>
				<td class="comment-image"><img width="100" src="<?php echo '/image/'; if ($comment['image']) echo $comment['image']; ?>"/><span style="display:none"><?php echo $comment['image']; ?></span></td>
				<td class="comment-text"><?php echo $comment['text']; ?></td>
				<td><a href="<?php echo $comment['id']; ?>" data-toggle="tooltip" title="" class="btn btn-primary comments-edit" data-original-title="Редактировать"><i class="fa fa-pencil"></i><input type="hidden" name="id" value="<?php echo $comment['id']; ?>"/></a></td>
				<td><a href="#" data-toggle="tooltip" title="" class="btn btn-danger comment-delete" data-original-title="Удалить без подтверждения"><i class="fa fa-trash-o"><input type="hidden" name="id" value="<?php echo $comment['id']; ?>"/></i></a></td>
			</tr>
		<?php } ?>
		</table>
		<div class="add_com" style="margin-top:50px;">
		<h3><?php echo $title_add;?></h3>
			<table width="100%">
				<thead>
					<tr>
						<td><?php echo $table_id;?></td>
						<td><?php echo $table_name;?></td>
						<td><?php echo $table_image;?></td>
						<td><?php echo $table_text;?></td>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td id="add_id"></td>
						<td id="add_name"><input type="text" name="name"/></td>
						<td id="add_image">
							<div>
								<a href="" id="thumb-image" data-toggle="image" class="img-thumbnail">
									<img src="/image/catalog/avatars/no_ava.png" alt="" title="" data-placeholder="" />
								</a>
								<input type="hidden" name="image" value="catalog/avatars/no_ava.png" id="input-image" />
							</div>
						</td>
						<td id="add_text"><textarea type="text" name="text"></textarea></td>

					</tr>
				</tbody>
			</table>
			<input type="submit" id="ret" value="add"/>
		</div>
		<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-account" class="form-horizontal">
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-status"><?php echo 11; ?></label>
            <div class="col-sm-10">
              <select name="comments_status" id="input-status" class="form-control">
                <?php if ($comments_status) { ?>
                <option value="1" selected="selected"><?php echo 1; ?></option>
                <option value="0"><?php echo 0; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo 1; ?></option>
                <option value="0" selected="selected"><?php echo 0; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
        </form>
		<script type="text/javascript"><!--

	$('.comments-edit').click(function(){
		tr = $(this).parents('tr');
		temp_id = tr.find('.comment-id').html();
		temp_name = tr.find('.comment-name').html();
		temp_img = tr.find('.comment-image span').html();
		temp_text = tr.find('.comment-text').html();
		$('#add_id').html(temp_id+' <input type="hidden" value="'+temp_id+'" name="id"/>');
		$('#add_name input').val(temp_name);
		$('#add_image img').attr({'src':'/image/'+temp_img});
		$('#add_image input').val(temp_img);
		$('#add_text input').val(temp_text);
		return false;
	});
	$('.comment-delete').click(function(){
		gems = $(this).find('input');
		$.ajax({
		url: 'index.php?route=module/comments/deleteComment&token=<?php echo $token; ?>',
		type: 'post',
		data: gems,
		dataType: 'json',
		beforeSend: function() {
			console.log(gems);
		},
		error: function (json) {
			console.log(json);
		},
		success: function(json) {
			console.log(json);
			location.reload();
		}
	});
		return false;
	});

	$('#ret').click(function(){
		$.ajax({
			url: 'index.php?route=module/comments/addComment&token=<?php echo $token; ?>',
			type: 'post',
			data: $('.add_com input[type=\'text\'],.add_com input[type=\'hidden\'],.add_com textarea'),
			dataType: 'json',
			beforeSend: function() {
				console.log($('.add_com input[type=\'text\']'));
			},
			error: function (json) {
				console.log('error');
			console.log(json);
			},
			success: function(json) {
				console.log('added');
				console.log(json);
			location.reload();
			}
		});
		return false;
	});
//--></script>

      </div>
      <div class="panel-body">
	  </div>
	</div>
  </div>
</div>
<?php echo $footer; ?>
