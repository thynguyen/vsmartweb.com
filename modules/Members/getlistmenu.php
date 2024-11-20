<?php
namespace Modules\Pages;

$menus = [
	route('members.web.register') => transmod('members::RegisterMember'),
	route('members.web.userpanel') => transmod('members::ProfileMember')
];