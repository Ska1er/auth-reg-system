<?php

function relocate(string $url) {
	header("Location: {$url}");
	die();
}

?>
