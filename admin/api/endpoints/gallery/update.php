<?php
Database::execOperation("UPDATE Gallery
SET `Date`=?, Name=?, Description=?, Tags=?
WHERE Id=?", "ssssi", [$_REQUEST['Date'], $_REQUEST['Name'], $_REQUEST['Description'], $_REQUEST['Tags'], $_REQUEST['Id']]);