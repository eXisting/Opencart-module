<?php

$this->load->model('user/user_group');
$this->model_user_user_group->addPermission($this->user->getGroupId(), 'access', 'catalog/emails_list');
$this->model_user_user_group->addPermission($this->user->getGroupId(), 'modify', 'catalog/emails_list');

?>
