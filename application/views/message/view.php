<?php

  set_page_title($message->getTitle());
  project_tabbed_navigation('messages');
  project_crumbs(array(
    array(lang('messages'), get_url('message', 'index')),
    array(lang('view message'))
  ));
  if (ProjectMessage::canAdd(logged_user(), active_project())) {
    add_page_action(lang('add message'), get_url('message', 'add'));
  } // if
  add_stylesheet_to_page('project/messages.css');

?>
<div class="message">
  <div class="messageDetails">
<?php if ($message->isPrivate()) { ?>
    <div class="private" title="<?php echo lang('private message') ?>"><span><?php echo lang('private message') ?></span></div>
<?php } // if ?>
<?php if ($message->getCreatedBy() instanceof User) { ?>
    <div class="messageAuthor"><?php echo lang('posted on by', format_datetime($message->getCreatedOn()), $message->getCreatedBy()->getCardUrl(), clean($message->getCreatedBy()->getDisplayName())) ?></div>
<?php } else { ?>
    <div class="messageAuthor"><?php echo lang('posted on', format_datetime($message->getCreatedOn())) ?></div>
<?php } // if ?>
  </div>
  <div class="messageText">
    <?php echo do_textile($message->getText()) ?>
<?php if (trim($message->getAdditionalText())) { ?>
    <div class="messageSeparator"><?php echo lang('message separator') ?></div>
    <?php echo do_textile($message->getAdditionalText()) ?>
<?php } // if?>
  </div>
<?php echo render_object_files($message, $message->canEdit(logged_user())) ?>
  <div class="messageCommentCount">
<?php if ($message->countComments()) { ?>
    <span><?php echo lang('comments') ?>:</span> <a href="<?php echo $message->getViewUrl() ?>#objectComments"><?php echo $message->countComments() ?></a>
<?php } else { ?>
    <span><?php echo lang('comments') ?>:</span> <?php echo $message->countComments() ?>
<?php } // if ?>
  </div>
    <?php echo render_object_tags($message); ?>
<?php
  $extra_options = array();
  if ($message->canDelete(logged_user())) {
    $extra_options[] = '<a href="' . $message->getMoveUrl() . '">' . lang('move') . '</a>';
  } // if
  echo render_object_options($message, $extra_options);
?>
</div>
<!-- Comments -->
<?php echo render_object_comments($message, $message->getViewUrl()) ?>